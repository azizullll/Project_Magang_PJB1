<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use App\Models\Division;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class CertificationController extends Controller
{
    /**
     * Display certification history for all employees
     */
    public function index(Request $request): View
    {
        $query = Employee::with(['certifications', 'trainings']);
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by division
        if ($request->filled('division')) {
            $query->where('divisi', $request->division);
        }

        $employees = $query->orderBy('nama')->paginate(15);

        // Filter by certification status (post-query filtering)
        if ($request->filled('status')) {
            $filtered = $employees->getCollection()->filter(function ($employee) use ($request) {
                $status = $request->status;
                $shouldInclude = false;
                
                // Count both trainings and legacy certifications
                $totalCertifications = $employee->trainings->count() + $employee->certifications->count();
                $expiredCount = 0;
                $expiringSoonCount = 0;
                $activeCount = 0;

                // Check trainings
                foreach ($employee->trainings as $training) {
                    $expirationDate = \Carbon\Carbon::parse($training->pivot->expiration_date);
                    $today = \Carbon\Carbon::now();
                    $diffDays = $expirationDate->diffInDays($today, false);
                    $diffMonths = $expirationDate->diffInMonths($today, false);
                    
                    if ($diffDays >= 0) {
                        $expiredCount++;
                    } elseif ($diffDays >= -7) {
                        // H-7 hari atau kurang
                        $expiringSoonCount++;
                    } elseif ($diffMonths >= -3) {
                        // H-3 bulan atau kurang
                        $expiringSoonCount++;
                    } else {
                        $activeCount++;
                    }
                }
                
                // Check legacy certifications
                foreach ($employee->certifications as $certification) {
                    $expirationDate = \Carbon\Carbon::parse($certification->pivot->expiration_date);
                    $today = \Carbon\Carbon::now();
                    $diffDays = $expirationDate->diffInDays($today, false);
                    $diffMonths = $expirationDate->diffInMonths($today, false);
                    
                    if ($diffDays >= 0) {
                        $expiredCount++;
                    } elseif ($diffDays >= -7) {
                        // H-7 hari atau kurang
                        $expiringSoonCount++;
                    } elseif ($diffMonths >= -3) {
                        // H-3 bulan atau kurang
                        $expiringSoonCount++;
                    } else {
                        $activeCount++;
                    }
                }

                switch ($status) {
                    case 'active':
                        $shouldInclude = $activeCount > 0 && $expiredCount == 0 && $expiringSoonCount == 0;
                        break;
                    case 'expiring':
                        $shouldInclude = $expiringSoonCount > 0;
                        break;
                    case 'expired':
                        $shouldInclude = $expiredCount > 0;
                        break;
                    case 'none':
                        $shouldInclude = $totalCertifications == 0;
                        break;
                }
                return $shouldInclude;
            });

            // Set filtered collection back to paginator
            $employees->setCollection($filtered->values());
        }

        // Divisions for filter dropdown: ambil unik dari data karyawan
        $employeeDivisions = Employee::query()
            ->whereNotNull('divisi')
            ->select('divisi')
            ->distinct()
            ->orderBy('divisi')
            ->pluck('divisi');

        // Tambahkan daftar divisi baku agar selalu tersedia di filter
        $staticDivisions = collect([
            'LINGKUNGAN',
            'SINFO',
            'INVENTORY',
            'SDM',
            'HAR',
            'ENGINEERING TO',
            'KEUANGAN',
            'SARANA',
        ]);

        $divisions = $staticDivisions->merge($employeeDivisions)->unique()->values();

        return view('certifications.index', [
            'employees' => $employees,
            'divisions' => $divisions,
        ]);
    }

    /**
     * Show form to add employee to training
     */
    public function create(Request $request): View
    {
        $employees = Employee::orderBy('nama')->get();
        $trainings = Training::where('is_active', true)->orderBy('name')->get();
        
        // Get selected employee if specified
        $selectedEmployee = $request->filled('employee_id')
            ? Employee::with(['trainings:id'])->find($request->employee_id)
            : null;
        
        return view('certifications.create', compact('employees', 'trainings', 'selectedEmployee'));
    }

    /**
     * Store employee certification
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'training_id' => 'required|exists:trainings,id',
            'issued_date' => 'required|date',
            'certificate_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $employee = Employee::findOrFail($validated['employee_id']);
        $training = Training::findOrFail($validated['training_id']);

        // Calculate expiration date
        $issuedDate = Carbon::parse($validated['issued_date']);
        $expirationDate = $issuedDate->addYears($training->certificate_active_years ?? 3);

        // Handle certificate image upload
        $certificateImagePath = null;
        if ($request->hasFile('certificate_image')) {
            $certificateImagePath = $request->file('certificate_image')->store('certificates', 'public');
        }

        // Check if employee already has this training certification
        $existingCertification = $employee->trainings()->where('training_id', $training->id)->first();

        if ($existingCertification) {
            return redirect()->back()
                ->withErrors(['training_id' => 'Karyawan sudah memiliki sertifikat pelatihan tersebut.'])
                ->withInput();
        }

        // Create new certification
        $employee->trainings()->attach($training->id, [
            'issued_date' => $validated['issued_date'],
            'expiration_date' => $expirationDate,
            'certificate_image' => $certificateImagePath
        ]);

        return redirect()->route('certifications.index')
            ->with('success', 'Sertifikasi berhasil ditambahkan untuk ' . $employee->nama);
    }

    /**
     * Show detailed certification history for specific employee
     */
    public function show(Employee $employee): View
    {
        $employee->load(['certifications' => function($query) {
            $query->orderBy('certification_employee.issued_date', 'desc');
        }]);

        return view('certifications.show', compact('employee'));
    }

    /**
     * Show edit form for a specific training certification (pivot employee_training)
     */
    public function editTraining(Employee $employee, Training $training): View
    {
        // Pastikan relasi ada agar dapat mengambil nilai pivot
        $attachedTraining = $employee->trainings()->where('training_id', $training->id)->firstOrFail();

        return view('certifications.edit-training', [
            'employee' => $employee,
            'training' => $training,
            'pivot' => $attachedTraining->pivot,
        ]);
    }

    /**
     * Update issued_date and certificate_image for a training certification pivot
     */
    public function updateTraining(Request $request, Employee $employee, Training $training): RedirectResponse
    {
        // Validasi: hanya tanggal terbit dan gambar sertifikat yang boleh diubah
        $validated = $request->validate([
            'issued_date' => ['required', 'date'],
            'certificate_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Ambil data pivot saat ini
        $attachedTraining = $employee->trainings()->where('training_id', $training->id)->firstOrFail();

        // Hitung ulang tanggal kadaluarsa berdasarkan masa aktif pelatihan
        $issuedDate = Carbon::parse($validated['issued_date']);
        $expirationDate = (clone $issuedDate)->addYears($training->certificate_active_years ?? 3);

        // Kelola upload gambar sertifikat (opsional)
        $certificateImagePath = $attachedTraining->pivot->certificate_image; // pertahankan yang lama jika tidak diunggah
        if ($request->hasFile('certificate_image')) {
            $certificateImagePath = $request->file('certificate_image')->store('certificates', 'public');
        }

        // Update pivot
        $employee->trainings()->updateExistingPivot($training->id, [
            'issued_date' => $issuedDate->toDateString(),
            'expiration_date' => $expirationDate->toDateString(),
            'certificate_image' => $certificateImagePath,
        ]);

        return redirect()->route('certifications.show', $employee->id)
            ->with('success', 'Sertifikasi berhasil diperbarui.');
    }

    /**
     * Remove certification from employee
     */
    public function destroy(Employee $employee, Certification $certification): RedirectResponse
    {
        $employee->certifications()->detach($certification->id);
        
        return redirect()->back()
            ->with('success', 'Sertifikasi berhasil dihapus dari ' . $employee->nama);
    }

    /**
     * Remove training certification (employee_training pivot)
     */
    public function destroyTraining(Employee $employee, Training $training): RedirectResponse
    {
        // Detach training from employee (safe even if not attached)
        $employee->trainings()->detach($training->id);

        return redirect()->back()
            ->with('success', 'Sertifikasi pelatihan berhasil dihapus dari ' . $employee->nama);
    }

    /**
     * Show form to renew certification (perpanjang sertifikasi)
     */
    public function renewTrainingForm(Employee $employee, Training $training): View
    {
        // Pastikan relasi ada agar dapat mengambil nilai pivot
        $attachedTraining = $employee->trainings()->where('training_id', $training->id)->firstOrFail();

        return view('certifications.renew-training', [
            'employee' => $employee,
            'training' => $training,
            'pivot' => $attachedTraining->pivot,
        ]);
    }

    /**
     * Update renewal date for training certification pivot
     * Logika sama seperti store: input tanggal diterbitkan baru, hitung kadaluarsa = tanggal + masa aktif
     */
    public function renewTraining(Request $request, Employee $employee, Training $training): RedirectResponse
    {
        // Validasi tanggal perpanjangan (tanggal diterbitkan baru)
        $validated = $request->validate([
            'new_issued_date' => ['required', 'date'],
        ]);

        // Hitung tanggal kadaluarsa dari tanggal perpanjangan + masa aktif pelatihan (sama seperti store)
        $newIssuedDate = Carbon::parse($validated['new_issued_date']);
        $newExpirationDate = (clone $newIssuedDate)->addYears($training->certificate_active_years ?? 3);

        // Update issued_date dan expiration_date (sama seperti logika store)
        $employee->trainings()->updateExistingPivot($training->id, [
            'issued_date' => $newIssuedDate->toDateString(),
            'expiration_date' => $newExpirationDate->toDateString(),
        ]);
        
        return redirect()->route('certifications.show', $employee->id)
            ->with('success', 'Sertifikasi berhasil diperpanjang hingga ' . $newExpirationDate->format('d/m/Y') . '.');
    }

    /**
     * API endpoint to get training details
     */
    public function getTrainingDetails(Request $request)
    {
        $training = Training::findOrFail($request->training_id);
        
        return response()->json([
            'code' => $training->code,
            'name' => $training->name,
            'level' => $training->level,
            'competencies_gained' => $training->competencies_gained,
            'institution' => $training->institution,
            'certificate_active_years' => $training->certificate_active_years ?? 3
        ]);
    }
}
