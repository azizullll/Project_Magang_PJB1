<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use App\Models\Division;
use App\Models\JobPosition;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    /**
     * Display recommendation page
     */
    public function index(): View
    {
        $employees = Employee::with('certifications')->get();
        $trainings = Training::where('is_active', true)->get();
        $divisions = Division::where('is_active', true)->get();
        
        return view('recommendations.index', compact('employees', 'trainings', 'divisions'));
    }

    /**
     * Get recommendations for specific employee
     */
    public function getRecommendations(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $employee = Employee::with('certifications')->find($employeeId);
        
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }

        $recommendations = $this->generateRecommendations($employee);
        
        return response()->json([
            'success' => true,
            'employee' => $employee,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Generate smart recommendations for employee
     */
    private function generateRecommendations(Employee $employee)
    {
        $recommendations = [];
        
        // Get employee's current certifications
        $currentCertifications = $employee->certifications->pluck('code')->toArray();
        
        // Get employee's division and job position
        $division = Division::where('name', $employee->divisi)->first();
        $jobPosition = JobPosition::where('name', $employee->jabatan)->first();
        
        if (!$division || !$jobPosition) {
            return $recommendations;
        }

        // Get trainings relevant to employee's division and job position
        $relevantTrainings = Training::where('is_active', true)
            ->where(function($query) use ($division, $jobPosition) {
                $query->whereJsonContains('relevant_divisions', $division->id)
                      ->orWhereJsonContains('relevant_job_positions', $jobPosition->id);
            })
            ->get();

        foreach ($relevantTrainings as $training) {
            $recommendation = $this->analyzeTrainingRecommendation($employee, $training, $currentCertifications);
            if ($recommendation) {
                $recommendations[] = $recommendation;
            }
        }

        // Sort by priority (higher level = higher priority)
        usort($recommendations, function($a, $b) {
            return $b['priority'] <=> $a['priority'];
        });

        return $recommendations;
    }

    /**
     * Analyze if training should be recommended
     */
    private function analyzeTrainingRecommendation(Employee $employee, Training $training, array $currentCertifications)
    {
        $recommendation = null;
        $reasons = [];
        $priority = 0;

        // Check if employee already has this certification
        if (in_array($training->certification_code, $currentCertifications)) {
            return null;
        }

        // Check division relevance
        $division = Division::where('name', $employee->divisi)->first();
        if ($division && in_array($division->id, $training->relevant_divisions ?? [])) {
            $reasons[] = "Relevan dengan divisi {$employee->divisi}";
            $priority += 3;
        }

        // Check job position relevance
        $jobPosition = JobPosition::where('name', $employee->jabatan)->first();
        if ($jobPosition && in_array($jobPosition->id, $training->relevant_job_positions ?? [])) {
            $reasons[] = "Relevan dengan jabatan {$employee->jabatan}";
            $priority += 3;
        }

        // Check competency level progression
        $employeeLevel = $this->getEmployeeCompetencyLevel($employee);
        $trainingLevel = $training->level;
        
        if ($trainingLevel <= $employeeLevel + 1) {
            if ($trainingLevel == $employeeLevel + 1) {
                $reasons[] = "Level berikutnya untuk pengembangan karir";
                $priority += 2;
            } elseif ($trainingLevel <= $employeeLevel) {
                $reasons[] = "Mengisi gap kompetensi";
                $priority += 1;
            }
        } else {
            // Training level too high, recommend prerequisites
            $prerequisites = $this->findPrerequisites($training, $currentCertifications);
            if (!empty($prerequisites)) {
                $reasons[] = "Memerlukan prasyarat: " . implode(', ', $prerequisites);
                $priority += 1;
            } else {
                return null; // Skip if no prerequisites found
            }
        }

        // Check category relevance based on job position
        $categoryRelevance = $this->getCategoryRelevance($employee->jabatan, $training->category);
        if ($categoryRelevance > 0) {
            $reasons[] = "Kategori {$training->category} sangat relevan";
            $priority += $categoryRelevance;
        }

        // Check if training is mandatory for position
        if ($this->isMandatoryTraining($employee->jabatan, $training)) {
            $reasons[] = "Pelatihan wajib untuk jabatan ini";
            $priority += 5;
        }

        if ($priority > 0) {
            $recommendation = [
                'training' => $training,
                'priority' => $priority,
                'reasons' => $reasons,
                'urgency' => $this->getUrgencyLevel($priority),
                'estimated_cost' => $training->cost,
                'duration' => $training->duration_days ? $training->duration_days . ' hari' : ($training->duration_hours ? $training->duration_hours . ' jam' : 'TBD'),
            ];
        }

        return $recommendation;
    }

    /**
     * Get employee competency level
     */
    private function getEmployeeCompetencyLevel(Employee $employee)
    {
        $levelMapping = [
            'Pemula' => 1,
            'Operator' => 2,
            'Terampil' => 3,
            'Ahli Muda' => 4,
            'Supervisor' => 5,
            'Ahli Madya' => 6,
            'Manager' => 7,
        ];

        return $levelMapping[$employee->level_kompetensi] ?? 1;
    }

    /**
     * Find prerequisite trainings
     */
    private function findPrerequisites(Training $training, array $currentCertifications)
    {
        $prerequisites = [];
        
        // Simple prerequisite logic based on level
        $requiredLevel = $training->level - 1;
        if ($requiredLevel > 0) {
            $prerequisites[] = "Level {$requiredLevel} training";
        }

        return $prerequisites;
    }

    /**
     * Get category relevance score
     */
    private function getCategoryRelevance(string $jobPosition, string $category)
    {
        $relevanceMap = [
            'Manager' => ['Manajerial' => 3, 'K3' => 2, 'Teknis' => 1, 'Softskill' => 2],
            'Supervisor' => ['Manajerial' => 2, 'K3' => 2, 'Teknis' => 2, 'Softskill' => 2],
            'Safety Engineer' => ['K3' => 3, 'Teknis' => 2, 'Manajerial' => 1, 'Softskill' => 1],
            'HSE Officer' => ['K3' => 3, 'Teknis' => 1, 'Manajerial' => 1, 'Softskill' => 1],
            'Project Manager' => ['Teknis' => 3, 'Manajerial' => 2, 'K3' => 2, 'Softskill' => 1],
            'Engineer' => ['Teknis' => 3, 'K3' => 2, 'Manajerial' => 1, 'Softskill' => 1],
        ];

        return $relevanceMap[$jobPosition][$category] ?? 0;
    }

    /**
     * Check if training is mandatory for position
     */
    private function isMandatoryTraining(string $jobPosition, Training $training)
    {
        $mandatoryMap = [
            'Safety Engineer' => ['K3-001', 'K3-002', 'ENG-002'],
            'HSE Officer' => ['K3-001', 'K3-002'],
            'Project Manager' => ['ENG-001', 'MGT-001'],
            'Manager' => ['MGT-001', 'MGT-002'],
        ];

        $mandatoryCodes = $mandatoryMap[$jobPosition] ?? [];
        return in_array($training->code, $mandatoryCodes);
    }

    /**
     * Get urgency level based on priority
     */
    private function getUrgencyLevel(int $priority)
    {
        if ($priority >= 8) return 'Sangat Tinggi';
        if ($priority >= 6) return 'Tinggi';
        if ($priority >= 4) return 'Sedang';
        if ($priority >= 2) return 'Rendah';
        return 'Sangat Rendah';
    }
}
