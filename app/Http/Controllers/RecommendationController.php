<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Training;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RecommendationController extends Controller
{
    /**
     * Display recommendation page
     */
    public function index(): View
    {
        $employees = Employee::with('trainings')->orderBy('nama')->get();
        
        return view('recommendations.index', compact('employees'));
    }

    /**
     * Get recommendations for specific employee
     */
    public function getRecommendations(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $employee = Employee::with('trainings')->find($employeeId);
        
        if (!$employee) {
            return response()->json([
                'success' => false,
                'message' => 'Karyawan tidak ditemukan'
            ], 404);
        }

        $recommendations = $this->generateRecommendations($employee);
        
        // Format employee data untuk response
        $employeeData = [
            'nama' => $employee->nama,
            'nip' => $employee->nip,
            'jabatan' => $employee->jabatan,
            'divisi' => $employee->divisi,
            'level_kompetensi' => $employee->level_kompetensi,
            'masa_kerja_tahun' => $employee->masa_kerja_tahun,
        ];
        
        return response()->json([
            'success' => true,
            'employee' => $employeeData,
            'recommendations' => $recommendations
        ]);
    }

    /**
     * Generate smart recommendations for employee berdasarkan divisi dan jabatan
     */
    private function generateRecommendations(Employee $employee)
    {
        $recommendations = [];
        
        // Ambil pelatihan yang sudah dimiliki karyawan (dari relasi trainings)
        $existingTrainingIds = $employee->trainings->pluck('id')->toArray();
        
        // Ambil semua pelatihan aktif
        $allTrainings = Training::where('is_active', true)->get();
        
        // Filter pelatihan berdasarkan divisi dan jabatan karyawan
        foreach ($allTrainings as $training) {
            // Cek apakah pelatihan sudah dimiliki
            if (in_array($training->id, $existingTrainingIds)) {
                continue; // Skip jika sudah dimiliki
            }
            
            // Cek apakah level sesuai dengan jabatan (sesuai aturan: Manajer 0+1-7, Supervisor 0+1-4, Staff 0+1-2)
            // Ini harus dicek pertama untuk efisiensi
            if (!$this->isLevelAllowedForPosition($training->level, $training->category, $employee->jabatan)) {
                continue; // Skip jika level tidak diizinkan untuk jabatan ini
            }
            
            // Untuk pelatihan Umum (level 0): harus relevan dengan jabatan (divisi boleh semua)
            if ($training->level === 0) {
                // Level 0 (Umum): hanya perlu relevan dengan jabatan
                // Divisi tidak perlu dicek untuk level 0
                $positionRelevant = $this->isPositionRelevant($training, $employee->jabatan);
                if (!$positionRelevant) {
                    continue; // Skip jika tidak relevan dengan jabatan
                }
            } else {
                // Level > 0: harus relevan dengan divisi DAN jabatan
                // Cek relevansi dengan divisi terlebih dahulu
                $divisionRelevant = $this->isDivisionRelevant($training, $employee->divisi);
                
                // Cek relevansi dengan jabatan
                $positionRelevant = $this->isPositionRelevant($training, $employee->jabatan);
                
                // Jika training tidak memiliki relevant_job_positions yang diisi, 
                // artinya training untuk semua jabatan (fleksibel)
                $relevantPositions = $training->relevant_job_positions ?? [];
                if (empty($relevantPositions)) {
                    // Jika relevant_job_positions kosong, training untuk semua jabatan
                    $positionRelevant = true;
                }
                
                // Cek divisi - ini penting untuk level > 0
                if (!$divisionRelevant) {
                    continue; // Skip jika tidak relevan dengan divisi
                }
                
                // Cek jabatan
                if (!$positionRelevant) {
                    continue; // Skip jika tidak relevan dengan jabatan
                }
            }
            
            // Analisis rekomendasi
            $recommendation = $this->analyzeTrainingRecommendation($employee, $training, $existingTrainingIds);
            
            if ($recommendation) {
                $recommendations[] = $recommendation;
            }
        }

        // Sort berdasarkan priority (High -> Medium -> Low), kemudian level
        usort($recommendations, function($a, $b) {
            $priorityOrder = ['High' => 3, 'Medium' => 2, 'Low' => 1];
            $priorityDiff = ($priorityOrder[$b['priority']] ?? 0) - ($priorityOrder[$a['priority']] ?? 0);
            if ($priorityDiff !== 0) {
                return $priorityDiff;
            }
            return $b['training']['level'] <=> $a['training']['level'];
        });

        return $recommendations;
    }

    /**
     * Cek apakah pelatihan relevan dengan divisi karyawan
     * Handle berbagai format: string nama divisi atau numeric ID
     */
    private function isDivisionRelevant(Training $training, string $employeeDivision): bool
    {
        // Ambil relevant_divisions, Laravel sudah otomatis cast sebagai array jika ada di $casts
        $relevantDivisions = $training->relevant_divisions;
        
        // Normalisasi divisi karyawan
        $employeeDivisionNormalized = $this->normalizeDivisionName($employeeDivision);
        
        // Jika null atau kosong, return false
        if (empty($relevantDivisions)) {
            return false;
        }
        
        // Jika relevant_divisions adalah string (JSON), decode dulu
        if (is_string($relevantDivisions)) {
            $decoded = json_decode($relevantDivisions, true);
            if (!is_array($decoded)) {
                return false;
            }
            $relevantDivisions = $decoded;
        }
        
        // Pastikan relevant_divisions adalah array
        if (!is_array($relevantDivisions)) {
            return false;
        }
        
        // Cek setiap divisi dalam array
        foreach ($relevantDivisions as $div) {
            // Convert to string untuk handle semua tipe data
            $divString = (string)$div;
            
            // Normalisasi divisi dari training
            $divNormalized = $this->normalizeDivisionName($divString);
            
            // Perbandingan exact match setelah normalisasi
            if ($divNormalized === $employeeDivisionNormalized) {
                return true;
            }
            
            // Fallback 1: cek tanpa normalisasi (case-insensitive)
            if (trim(strtoupper($divString)) === trim(strtoupper($employeeDivision))) {
                return true;
            }
            
            // Fallback 2: jika $div adalah numeric (ID), cek mapping
            if (is_numeric($div)) {
                $divisionNameFromId = $this->getDivisionNameFromId((int)$div);
                if ($divisionNameFromId) {
                    $divNormalizedFromId = $this->normalizeDivisionName($divisionNameFromId);
                    if ($divNormalizedFromId === $employeeDivisionNormalized) {
                        return true;
                    }
                }
            }
        }
        
        // Jika tidak ada match, return false
        return false;
    }
    
    /**
     * Normalisasi nama divisi untuk perbandingan
     * Menangani berbagai format: LINGKUNGAN, SINFO, INVENTORY, SDM, HAR, ENGINEERING TO, KEUANGAN, SARANA
     */
    private function normalizeDivisionName(string $division): string
    {
        // Trim dan uppercase
        $normalized = trim(strtoupper($division));
        
        // Hapus titik (S.INFO -> SINFO)
        $normalized = str_replace('.', '', $normalized);
        
        // Handle "ENGINEERING TO" khusus - hapus semua spasi
        if (stripos($normalized, 'ENGINEERING') !== false) {
            // Jika ada "ENGINEERING" dan "TO", hapus semua spasi
            $normalized = str_replace(' ', '', $normalized);
            if (stripos($normalized, 'TO') !== false) {
                $normalized = 'ENGINEERINGTO';
            }
        }
        
        // Pastikan format konsisten untuk semua divisi
        // Mapping untuk semua kemungkinan format
        $divisionMapping = [
            'LINGKUNGAN' => 'LINGKUNGAN',
            'SINFO' => 'SINFO',
            'S.INFO' => 'SINFO',
            'S INFO' => 'SINFO',
            'SINFO' => 'SINFO',
            'INVENTORY' => 'INVENTORY',
            'SDM' => 'SDM',
            'HAR' => 'HAR',
            'ENGINEERING TO' => 'ENGINEERINGTO',
            'ENGINEERINGTO' => 'ENGINEERINGTO',
            'KEUANGAN' => 'KEUANGAN',
            'SARANA' => 'SARANA',
        ];
        
        // Jika ada di mapping, gunakan mapping
        if (isset($divisionMapping[$normalized])) {
            return $divisionMapping[$normalized];
        }
        
        // Jika tidak ada di mapping, return normalized (untuk handle case baru)
        // Pastikan sudah uppercase dan trim
        return $normalized;
    }
    
    /**
     * Mapping ID divisi ke nama divisi (jika diperlukan)
     * Note: Ini hanya untuk handle data lama yang mungkin menggunakan ID
     */
    private function getDivisionNameFromId(int $divisionId): ?string
    {
        // Mapping ID ke nama divisi (sesuai dengan seeder atau data yang ada)
        // Ini adalah fallback jika data menggunakan ID
        $idToNameMap = [
            1 => 'LINGKUNGAN',
            2 => 'SINFO',
            3 => 'INVENTORY',
            4 => 'SDM',
            5 => 'HAR',
            6 => 'ENGINEERING TO',
            7 => 'KEUANGAN',
            8 => 'SARANA',
        ];
        
        return $idToNameMap[$divisionId] ?? null;
    }

    /**
     * Cek apakah pelatihan relevan dengan jabatan karyawan
     * Jika relevant_job_positions kosong, artinya training untuk semua jabatan
     * Jika training untuk jabatan tertentu, jabatan yang lebih tinggi juga boleh ikut
     */
    private function isPositionRelevant(Training $training, string $employeePosition): bool
    {
        $relevantPositions = $training->relevant_job_positions ?? [];
        
        // Normalisasi jabatan karyawan
        $employeePosition = trim($employeePosition);
        
        // Jika relevant_job_positions kosong atau null, artinya training untuk semua jabatan
        if (empty($relevantPositions)) {
            return true;
        }
        
        // Jika relevant_job_positions adalah string (JSON), decode dulu
        if (is_string($relevantPositions)) {
            $decoded = json_decode($relevantPositions, true);
            if (!is_array($decoded)) {
                return true; // Jika decode gagal, anggap untuk semua jabatan
            }
            $relevantPositions = $decoded;
            
            // Jika setelah decode kosong, artinya untuk semua jabatan
            if (empty($relevantPositions)) {
                return true;
            }
        }
        
        // Pastikan relevant_positions adalah array
        if (!is_array($relevantPositions)) {
            return true; // Jika bukan array, anggap untuk semua jabatan
        }
        
        // Cek setiap jabatan dalam array
        foreach ($relevantPositions as $pos) {
            $posNormalized = trim((string)$pos);
            
            // Perbandingan exact match (case-sensitive karena jabatan bisa punya format khusus)
            if ($posNormalized === $employeePosition) {
                return true;
            }
        }
        
        // Jika tidak exact match, cek apakah jabatan karyawan lebih tinggi dari training
        // Hierarki: Staff < Supervisor(Asmen) < Manajer
        // Jika training untuk Staff, Supervisor dan Manajer juga boleh ikut
        // Jika training untuk Supervisor, Manajer juga boleh ikut
        $positionHierarchy = [
            'Staff' => 1,
            'Supervisor(Asmen)' => 2,
            'Manajer' => 3,
        ];
        
        $employeeLevel = $positionHierarchy[$employeePosition] ?? 0;
        
        foreach ($relevantPositions as $pos) {
            $posNormalized = trim((string)$pos);
            $trainingLevel = $positionHierarchy[$posNormalized] ?? 0;
            
            // Jika jabatan karyawan lebih tinggi atau sama dengan training, boleh ikut
            if ($employeeLevel >= $trainingLevel && $trainingLevel > 0) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Cek apakah level pelatihan diizinkan untuk jabatan tertentu
     * Berdasarkan aturan:
     * - Manajer: Level Umum (0) + semua level (1-7)
     * - Supervisor/Asmen: Level Umum (0) + Level 1-4
     * - Staff: Level Umum (0) + Level 1-2
     */
    private function isLevelAllowedForPosition(int $level, string $category, string $position): bool
    {
        switch($position) {
            case 'Staff':
                // Staff: Level Umum (0) + Level 1-2
                return $level === 0 || ($level >= 1 && $level <= 2);
                
            case 'Supervisor(Asmen)':
                // Supervisor/Asmen: Level Umum (0) + Level 1-4
                return $level === 0 || ($level >= 1 && $level <= 4);
                
            case 'Manajer':
                // Manajer: Level Umum (0) + semua level (1-7)
                return $level === 0 || ($level >= 1 && $level <= 7);
                
            default:
                return false;
        }
    }

    /**
     * Analisis rekomendasi untuk pelatihan tertentu
     * Rekomendasikan semua pelatihan yang belum dimiliki selama sesuai batasan jabatan
     */
    private function analyzeTrainingRecommendation(Employee $employee, Training $training, array $existingTrainingIds)
    {
        $reasons = [];
        $priority = 'High'; // Default priority
        
        // Cek apakah training ini sudah dimiliki
        $trainingAlreadyOwned = $employee->trainings()
            ->where('trainings.id', $training->id)
            ->exists();
        
        if ($trainingAlreadyOwned) {
            return null; // Skip jika sudah dimiliki
        }
        
        // Ambil semua level yang sudah dimiliki untuk kategori ini
        $ownedLevels = $this->getOwnedLevelsForCategory($employee, $training->category, $existingTrainingIds);
        
        // Ambil level tertinggi yang sudah dimiliki untuk kategori ini
        $maxLevelForCategory = empty($ownedLevels) ? null : max($ownedLevels);
        
        // Logika rekomendasi berdasarkan level
        if ($training->level === 0) {
            // Pelatihan Umum (Level 0)
            if ($maxLevelForCategory === null) {
                // Belum punya sertifikasi apapun untuk kategori ini
                $reasons[] = "Pelatihan Umum disarankan sebagai langkah awal pengembangan kompetensi";
                $priority = 'High';
            } else {
                // Sudah punya sertifikasi, Umum bisa sebagai refresh
                $reasons[] = "Pelatihan Umum untuk memperkuat dasar kompetensi";
                $priority = 'Medium';
            }
        } else {
            // Pelatihan dengan level > 0
            // Cek apakah level ini sudah dimiliki
            if (in_array($training->level, $ownedLevels)) {
                return null; // Skip jika level ini sudah dimiliki
            }
            
            // Jika belum dimiliki, rekomendasikan
            if ($maxLevelForCategory === null) {
                // Belum punya sertifikasi apapun untuk kategori ini
                if ($training->level === 1) {
                    $reasons[] = "Level 1 disarankan sebagai langkah awal untuk kategori {$training->category}";
                    $priority = 'High';
                } else {
                    // Level > 1 tapi belum punya apa-apa
                    // Tetap direkomendasikan karena user minta semua yang belum dimiliki
                    $reasons[] = "Level {$training->level} untuk kategori {$training->category} yang belum Anda miliki";
                    $priority = 'Medium'; // Medium karena mungkin perlu prasyarat
                }
            } else {
                // Sudah punya sertifikasi level tertentu
                if ($training->level === $maxLevelForCategory + 1) {
                    // Level berikutnya -> High priority
                    $reasons[] = "Level " . $training->level . " adalah langkah selanjutnya setelah menyelesaikan Level " . $maxLevelForCategory;
                    $priority = 'High';
                } elseif ($training->level < $maxLevelForCategory) {
                    // Level di bawah yang sudah dimiliki -> skip (sudah punya level lebih tinggi)
                    return null;
                } else {
                    // Level lebih tinggi dari yang dimiliki (lebih dari +1)
                    // Tetap direkomendasikan karena belum dimiliki
                    $reasons[] = "Level {$training->level} untuk kategori {$training->category} yang belum Anda miliki";
                    if ($training->level === $maxLevelForCategory + 2) {
                        $priority = 'Medium'; // Medium karena butuh level sebelumnya dulu
                    } else {
                        $priority = 'Low'; // Low karena butuh beberapa level sebelumnya
                    }
                }
            }
        }
        
        // Tambahkan alasan relevansi divisi/jabatan
        if ($this->isDivisionRelevant($training, $employee->divisi)) {
            $reasons[] = "Relevan dengan divisi {$employee->divisi}";
        }
        
        if ($this->isPositionRelevant($training, $employee->jabatan)) {
            $reasons[] = "Relevan dengan jabatan {$employee->jabatan}";
        }
        
        return [
            'training' => [
                'id' => $training->id,
                'code' => $training->code,
                'name' => $training->name,
                'category' => $training->category,
                'level' => $training->level,
                'institution' => $training->institution,
                'cost' => $training->cost,
                'duration_days' => $training->duration_days,
                'duration_hours' => $training->duration_hours,
                'competencies_gained' => $training->competencies_gained,
            ],
            'priority' => $priority,
            'reasons' => $reasons,
        ];
    }

    /**
     * Ambil semua level yang sudah dimiliki karyawan untuk kategori tertentu
     */
    private function getOwnedLevelsForCategory(Employee $employee, string $category, array $existingTrainingIds): array
    {
        $ownedLevels = [];
        
        // Jika tidak ada training yang dimiliki, return empty array
        if (empty($existingTrainingIds)) {
            return [];
        }
        
        // Ambil semua pelatihan yang sudah dimiliki dengan kategori yang sama
        $categoryTrainings = $employee->trainings()
            ->where('category', $category)
            ->whereIn('trainings.id', $existingTrainingIds)
            ->get();
        
        // Jika tidak ada training dengan kategori ini, return empty array
        if ($categoryTrainings->isEmpty()) {
            return [];
        }
        
        foreach ($categoryTrainings as $training) {
            $level = (int) $training->level;
            if ($level > 0) { // Hanya hitung level > 0 (level 0 = Umum, tidak dihitung untuk progression)
                $ownedLevels[] = $level;
            }
        }
        
        return array_unique($ownedLevels);
    }
    
    /**
     * Ambil level tertinggi yang sudah dimiliki karyawan untuk kategori tertentu
     */
    private function getMaxLevelForCategory(Employee $employee, string $category, array $existingTrainingIds): ?int
    {
        $ownedLevels = $this->getOwnedLevelsForCategory($employee, $category, $existingTrainingIds);
        return empty($ownedLevels) ? null : max($ownedLevels);
    }
}
