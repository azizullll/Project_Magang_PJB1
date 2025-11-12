<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Training;
use App\Models\Certification;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $today = Carbon::today();

        // Total karyawan
        $totalEmployees = Employee::count();

        // Kompetensi aktif (pelatihan aktif berdasarkan expiration_date di pivot employee_training)
        $activeCompetencies = DB::table('employee_training')
            ->whereDate('expiration_date', '>', $today)
            ->count();

        // Pelatihan selesai (total baris relasi pelatihan karyawan)
        $completedTrainings = DB::table('employee_training')->count();

        // Jumlah data pelatihan (master pelatihan)
        $totalTrainings = Training::count();

        // Hitung sertifikasi yang segera habis (7 hari ke depan) dari kedua sumber data
        $in7Days = (clone $today)->addDays(7);
        $expiringSoonTrainings = DB::table('employee_training')
            ->whereDate('expiration_date', '>=', $today->toDateString())
            ->whereDate('expiration_date', '<=', $in7Days->toDateString())
            ->count();
        $expiringSoonLegacy = DB::table('certification_employee')
            ->whereDate('expiration_date', '>=', $today->toDateString())
            ->whereDate('expiration_date', '<=', $in7Days->toDateString())
            ->count();
        $expiringSoonCount = $expiringSoonTrainings + $expiringSoonLegacy;

        // Hitung sertifikasi yang sudah kadaluarsa (expiration_date < today)
        $expiredTrainings = DB::table('employee_training')
            ->whereDate('expiration_date', '<', $today->toDateString())
            ->count();
        $expiredLegacy = DB::table('certification_employee')
            ->whereDate('expiration_date', '<', $today->toDateString())
            ->count();
        $expiredCount = $expiredTrainings + $expiredLegacy;

        // Tentukan apakah alert perlu ditampilkan (sekali saat login, atau sekali per sesi jika flash hilang)
        $justLoggedIn = (bool) $request->session()->get('just_logged_in', false);
        $alreadyShown = (bool) $request->session()->get('expiring_alert_shown', false);
        $showExpiringAlert = false;
        if (($expiringSoonCount > 0 || $expiredCount > 0) && ($justLoggedIn || !$alreadyShown)) {
            $showExpiringAlert = true;
            // Tandai sudah ditampilkan untuk sesi ini
            $request->session()->put('expiring_alert_shown', true);
        }

        // Grafik: jumlah pelatihan yang diikuti per bulan (12 bulan terakhir berdasarkan issued_date)
        $start = (clone $today)->subMonths(11)->startOfMonth();
        $end = (clone $today)->endOfMonth();

        $rows = DB::table('employee_training')
            ->select(
                DB::raw("DATE_FORMAT(issued_date, '%Y-%m') as ym"),
                DB::raw('COUNT(*) as total')
            )
            ->whereBetween('issued_date', [$start->toDateString(), $end->toDateString()])
            ->groupBy('ym')
            ->orderBy('ym')
            ->get()
            ->pluck('total', 'ym');

        // Susun label dan data untuk 12 bulan terakhir
        $labels = [];
        $data = [];
        $cursor = $start->copy();
        while ($cursor <= $end) {
            $ym = $cursor->format('Y-m');
            $labels[] = $cursor->translatedFormat('M Y');
            $data[] = (int) ($rows[$ym] ?? 0);
            $cursor->addMonth();
        }

        // Karyawan terbaru (3 terakhir)
        $latestEmployees = Employee::orderByDesc('created_at')
            ->limit(3)
            ->get(['nama', 'jabatan', 'divisi']);

        return view('dashboard', [
            'totalEmployees' => $totalEmployees,
            'activeCompetencies' => $activeCompetencies,
            'completedTrainings' => $completedTrainings,
            'totalTrainings' => $totalTrainings,
            'expiringSoonCount' => $expiringSoonCount,
            'expiredCount' => $expiredCount,
            'showExpiringAlert' => $showExpiringAlert,
            'chartLabels' => $labels,
            'chartData' => $data,
            'latestEmployees' => $latestEmployees,
        ]);
    }
}


