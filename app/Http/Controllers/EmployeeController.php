<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Models\Employee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(Request $request): View
    {
        $query = Employee::query()->with('certifications');
        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('divisi', 'like', "%{$search}%");
            });
        }
        $employees = $query->orderBy('nama')->paginate(10)->withQueryString();
        return view('employees.index', compact('employees'));
    }

    public function create(): View
    {
        $certifications = Certification::orderBy('name')->get();
        return view('employees.create', compact('certifications'));
    }

    public function show(Employee $employee): View
    {
        $employee->load('certifications');
        return view('employees.show', compact('employee'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => ['required', 'string', 'max:50', 'unique:employees,nip'],
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150', 'unique:employees,email'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['required', 'string', 'max:150'],
            'divisi' => ['nullable', 'string', 'max:150'],
            'masa_kerja_tahun' => ['required', 'integer', 'min:0', 'max:100'],
            'level_kompetensi' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'certificates' => ['nullable', 'array'],
            'certificates.*.code' => ['required_with:certificates', 'string', 'max:50'],
            'certificates.*.name' => ['nullable', 'string', 'max:150'],
            'certificates.*.issued_date' => ['nullable', 'date'],
            'certificates.*.expiration_date' => ['nullable', 'date', 'after_or_equal:certificates.*.issued_date'],
            'certificates.*.image' => ['nullable', 'image', 'max:5120'],
        ]);

        $levelDefault = $this->tentukanLevelDefault((int) $validated['masa_kerja_tahun']);
        $level = $validated['level_kompetensi'] ?? $levelDefault;

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('employees', 'public');
        }

        $employee = Employee::create([
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'jabatan' => $validated['jabatan'],
            'divisi' => $validated['divisi'] ?? null,
            'masa_kerja_tahun' => (int) $validated['masa_kerja_tahun'],
            'level_kompetensi' => $level,
            'foto_path' => $fotoPath,
        ]);

        // Handle multiple certificates
        $pivotData = [];
        if (!empty($validated['certificates'])) {
            foreach ($validated['certificates'] as $certData) {
                // Create or find certification
                $certification = Certification::firstOrCreate(
                    ['code' => $certData['code']],
                    ['name' => $certData['name'] ?? $certData['code']]
                );

                // Handle certificate image upload
                $certificateImagePath = null;
                $certificateKey = array_search($certData, $validated['certificates']);
                if ($request->hasFile("certificates.{$certificateKey}.image")) {
                    $certificateImagePath = $request->file("certificates.{$certificateKey}.image")->store('certificates', 'public');
                }

                $pivotData[$certification->id] = [
                    'certificate_image' => $certificateImagePath,
                    'issued_date' => $certData['issued_date'] ?? null,
                    'expiration_date' => $certData['expiration_date'] ?? null,
                ];
            }
        }
        $employee->certifications()->sync($pivotData);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(Employee $employee): View
    {
        $employee->load('certifications');
        $certifications = Certification::orderBy('name')->get();
        return view('employees.edit', compact('employee', 'certifications'));
    }

    public function update(Request $request, Employee $employee): RedirectResponse
    {
        $validated = $request->validate([
            'nip' => ['required', 'string', 'max:50', 'unique:employees,nip,' . $employee->id],
            'nama' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email', 'max:150', 'unique:employees,email,' . $employee->id],
            'alamat' => ['nullable', 'string', 'max:500'],
            'no_telp' => ['nullable', 'string', 'max:20'],
            'jabatan' => ['required', 'string', 'max:150'],
            'divisi' => ['nullable', 'string', 'max:150'],
            'masa_kerja_tahun' => ['required', 'integer', 'min:0', 'max:100'],
            'level_kompetensi' => ['nullable', 'string', 'max:100'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'certificates' => ['nullable', 'array'],
            'certificates.*.code' => ['required_with:certificates', 'string', 'max:50'],
            'certificates.*.name' => ['nullable', 'string', 'max:150'],
            'certificates.*.issued_date' => ['nullable', 'date'],
            'certificates.*.expiration_date' => ['nullable', 'date', 'after_or_equal:certificates.*.issued_date'],
            'certificates.*.image' => ['nullable', 'image', 'max:5120'],
        ]);

        $levelDefault = $this->tentukanLevelDefault((int) $validated['masa_kerja_tahun']);
        $level = $validated['level_kompetensi'] ?? $levelDefault;

        $dataUpdate = [
            'nip' => $validated['nip'],
            'nama' => $validated['nama'],
            'email' => $validated['email'] ?? null,
            'alamat' => $validated['alamat'] ?? null,
            'no_telp' => $validated['no_telp'] ?? null,
            'jabatan' => $validated['jabatan'],
            'divisi' => $validated['divisi'] ?? null,
            'masa_kerja_tahun' => (int) $validated['masa_kerja_tahun'],
            'level_kompetensi' => $level,
        ];

        if ($request->hasFile('foto')) {
            if ($employee->foto_path) {
                Storage::disk('public')->delete($employee->foto_path);
            }
            $dataUpdate['foto_path'] = $request->file('foto')->store('employees', 'public');
        }

        $employee->update($dataUpdate);

        // Handle multiple certificates
        $pivotData = [];
        if (!empty($validated['certificates'])) {
            foreach ($validated['certificates'] as $certData) {
                // Create or find certification
                $certification = Certification::firstOrCreate(
                    ['code' => $certData['code']],
                    ['name' => $certData['name'] ?? $certData['code']]
                );

                // Handle certificate image upload
                $certificateImagePath = null;
                $certificateKey = array_search($certData, $validated['certificates']);
                if ($request->hasFile("certificates.{$certificateKey}.image")) {
                    // Delete old certificate image if exists
                    $existingCert = $employee->certifications()->where('certification_id', $certification->id)->first();
                    if ($existingCert && $existingCert->pivot->certificate_image) {
                        Storage::disk('public')->delete($existingCert->pivot->certificate_image);
                    }
                    $certificateImagePath = $request->file("certificates.{$certificateKey}.image")->store('certificates', 'public');
                } else {
                    // Keep existing certificate image if no new one uploaded
                    $existingCert = $employee->certifications()->where('certification_id', $certification->id)->first();
                    if ($existingCert && $existingCert->pivot->certificate_image) {
                        $certificateImagePath = $existingCert->pivot->certificate_image;
                    }
                }

                $pivotData[$certification->id] = [
                    'certificate_image' => $certificateImagePath,
                    'issued_date' => $certData['issued_date'] ?? null,
                    'expiration_date' => $certData['expiration_date'] ?? null,
                ];
            }
        }
        
        // Delete old certificate images that are no longer needed
        $employee->certifications->each(function ($cert) use ($pivotData) {
            if (!array_key_exists($cert->id, $pivotData) && $cert->pivot->certificate_image) {
                Storage::disk('public')->delete($cert->pivot->certificate_image);
            }
        });
        
        $employee->certifications()->sync($pivotData);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Employee $employee): RedirectResponse
    {
        // Delete employee photo
        if ($employee->foto_path) {
            Storage::disk('public')->delete($employee->foto_path);
        }
        
        // Delete certificate images
        $employee->certifications->each(function ($cert) {
            if ($cert->pivot->certificate_image) {
                Storage::disk('public')->delete($cert->pivot->certificate_image);
            }
        });
        
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil dihapus.');
    }

    private function tentukanLevelDefault(int $masaKerjaTahun): string
    {
        if ($masaKerjaTahun >= 10) return 'Ahli Madya';
        if ($masaKerjaTahun >= 6) return 'Ahli Muda';
        if ($masaKerjaTahun >= 3) return 'Terampil';
        return 'Pemula';
    }

    /**
     * Normalisasi input sertifikasi: menerima array, string comma-separated, atau null.
     */
    private function normalizeSertifikasiInput($input): array
    {
        if (is_array($input)) {
            return array_values(array_filter(array_map('trim', $input), fn($v) => $v !== ''));
        }
        if (is_string($input)) {
            $parts = preg_split('/[,\n]/', $input);
            return array_values(array_filter(array_map('trim', $parts), fn($v) => $v !== ''));
        }
        return [];
    }

    /**
     * Menerima array string sertifikasi (code/name) dan mengembalikan ID untuk sync.
     * Jika item tidak ada, akan dibuat sebagai code dan name sama.
     */
    private function syncCertificationsFromInput(array $inputItems): array
    {
        $ids = [];
        foreach ($inputItems as $item) {
            $code = trim($item);
            if ($code === '') continue;
            $cert = Certification::firstOrCreate(
                ['code' => $code],
                ['name' => $code]
            );
            $ids[] = $cert->id;
        }
        return array_values(array_unique($ids));
    }

    /**
     * Hapus sertifikat individual dari karyawan
     */
    public function destroyCertificate(Employee $employee, Certification $certification): RedirectResponse
    {
        // Check if the employee has this certification
        if (!$employee->certifications()->where('certification_id', $certification->id)->exists()) {
            return redirect()->back()->with('error', 'Sertifikat tidak ditemukan untuk karyawan ini.');
        }

        // Get the certificate image path before detaching
        $certificateData = $employee->certifications()->where('certification_id', $certification->id)->first();
        $certificateImagePath = $certificateData->pivot->certificate_image;

        // Detach the certification
        $employee->certifications()->detach($certification->id);

        // Delete the certificate image file if it exists
        if ($certificateImagePath) {
            Storage::disk('public')->delete($certificateImagePath);
        }

        return redirect()->back()->with('success', 'Sertifikat berhasil dihapus.');
    }
}


