<?php

namespace App\Http\Controllers\Peminjaman;

use App\Models\Verification;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Ruang;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class SiswaPinjamRuangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "nama_kegiatan" => "required|string",
                "start_at" => "required|date",
                "end_at" => "required|date",
                "ruang_id" => "required",
                "siswa_id" => "required",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            $findRuang = Ruang::find($request->ruang_id);
            $findSiswa = User::find($request->siswa_id);
            if (!$findRuang) {
                return new ApiResource(false, "Ruangan tidak ditemukan", null);
            }
            if (!$findSiswa) {
                return new ApiResource(false, "Siswa tidak ditemukan", null);
            }

            $verificationStatus = Verification::where('ruang_id', $request->ruang_id)
                ->where('status', 'DISETUJUI')
                ->where(function ($query) use ($request) {
                    $query->whereBetween('start_at', [$request->start_at, $request->end_at])
                        ->orWhereBetween('end_at', [$request->start_at, $request->end_at])
                        ->orWhere(function ($subquery) use ($request) {
                            $subquery->where('start_at', '<=', $request->start_at)
                                ->where('end_at', '>=', $request->end_at);
                        });
                })
                ->exists();
            if ($verificationStatus) {
                return new ApiResource(false, "Anda tidak dapat meminjam ruangan ini!", null);
            }
            $data = Verification::create([
                "nama_kegiatan" => $request->nama_kegiatan,
                "start_at" => $request->start_at,
                "end_at" => $request->end_at,
                "status" => "MENUNGGU",
                "ruang_id" => $request->ruang_id,
                "siswa_id" => $request->siswa_id,
            ]);
            if (!$data) {
                return new ApiResource(false, "Gagal Meminjam Ruangan", null);
            }
            return new ApiResource(true, "Sukses Meminjam Ruangan", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
