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
        $query = Employee::with(['certifications']);
        
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
            $employees->getCollection()->transform(function ($employee) use ($request) {
                $status = $request->status;
                $shouldInclude = false;
                
                $totalCertifications = $employee->certifications->count();
                $expiredCount = 0;
                $expiringSoonCount = 0;
                $activeCount = 0;

                foreach ($employee->certifications as $certification) {
                    $expirationDate = \Carbon\Carbon::parse($certification->pivot->expiration_date);
                    $today = \Carbon\Carbon::now();
                    $diff = $expirationDate->diffInDays($today, false);
                    
                    if ($diff >= 0) {
                        $expiredCount++;
                    } elseif (abs($diff) <= 30) {
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

                return $shouldInclude ? $employee : null;
            })->filter();
        }

        // Get divisions for filter dropdown
        $divisions = Division::where('is_active', true)->orderBy('name')->get();

        return view('certifications.index', compact('employees', 'divisions'));
    }

    /**
     * Show form to add employee to training
     */
    public function create(): View
    {
        $employees = Employee::orderBy('nama')->get();
        $trainings = Training::where('is_active', true)->orderBy('name')->get();
        
        return view('certifications.create', compact('employees', 'trainings'));
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
            // Update existing certification
            $employee->trainings()->updateExistingPivot($training->id, [
                'issued_date' => $validated['issued_date'],
                'expiration_date' => $expirationDate,
                'certificate_image' => $certificateImagePath
            ]);
        } else {
            // Create new certification
            $employee->trainings()->attach($training->id, [
                'issued_date' => $validated['issued_date'],
                'expiration_date' => $expirationDate,
                'certificate_image' => $certificateImagePath
            ]);
        }

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
     * Remove certification from employee
     */
    public function destroy(Employee $employee, Certification $certification): RedirectResponse
    {
        $employee->certifications()->detach($certification->id);
        
        return redirect()->back()
            ->with('success', 'Sertifikasi berhasil dihapus dari ' . $employee->nama);
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
