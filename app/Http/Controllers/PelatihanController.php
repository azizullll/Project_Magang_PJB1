<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelatihan;
use Illuminate\Support\Facades\Validator;

class PelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelatihan = Pelatihan::all();
        return response()->json([
            'success' => true,
            'data' => $pelatihan,
            'total' => $pelatihan->count(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bidang' => 'required|string|max:255',
            'kode' => 'required|string|max:255|unique:pelatihan,kode',
            'judul' => 'required|string|max:255',
            'kompetensi_inti' => 'required|string',
            'kompetensi_pilihan' => 'nullable|string',
            'level' => 'required|integer|min:1',
            'tenggat_sertifikat' => 'nullable|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pelatihan = Pelatihan::create($request->only([
                'bidang', 'kode', 'judul', 'kompetensi_inti', 'kompetensi_pilihan', 'level', 'tenggat_sertifikat'
            ]));
            return response()->json([
                'success' => true,
                'message' => 'Data pelatihan berhasil ditambahkan',
                'data' => $pelatihan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan data pelatihan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pelatihan = Pelatihan::find($id);
        
        if (!$pelatihan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelatihan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $pelatihan
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelatihan = Pelatihan::find($id);
        
        if (!$pelatihan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelatihan tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'bidang' => 'required|string|max:255',
            'kode' => 'required|string|max:255|unique:pelatihan,kode,' . $id,
            'judul' => 'required|string|max:255',
            'kompetensi_inti' => 'required|string',
            'kompetensi_pilihan' => 'nullable|string',
            'level' => 'required|integer|min:1',
            'tenggat_sertifikat' => 'nullable|integer|min:1|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $pelatihan->update($request->only([
                'bidang', 'kode', 'judul', 'kompetensi_inti', 'kompetensi_pilihan', 'level', 'tenggat_sertifikat'
            ]));
            return response()->json([
                'success' => true,
                'message' => 'Data pelatihan berhasil diupdate',
                'data' => $pelatihan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data pelatihan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelatihan = Pelatihan::find($id);
        
        if (!$pelatihan) {
            return response()->json([
                'success' => false,
                'message' => 'Data pelatihan tidak ditemukan'
            ], 404);
        }

        try {
            $pelatihan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data pelatihan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus data pelatihan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Search pelatihan based on query
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        
        if (empty($query)) {
            $pelatihan = Pelatihan::all();
        } else {
            $pelatihan = Pelatihan::where('judul', 'like', '%' . $query . '%')
                ->orWhere('bidang', 'like', '%' . $query . '%')
                ->orWhere('kompetensi_inti', 'like', '%' . $query . '%')
                ->orWhere('kompetensi_pilihan', 'like', '%' . $query . '%')
                ->orWhere('level', $query)
                ->get();
        }

        return response()->json([
            'success' => true,
            'data' => $pelatihan,
            'total' => $pelatihan->count()
        ]);
    }
}
