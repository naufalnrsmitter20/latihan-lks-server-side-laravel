<?php

namespace App\Http\Controllers\Peminjaman;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\ApiResource;
use App\Http\Controllers\Controller;
use App\Models\Verification;
use Illuminate\Support\Facades\Validator;

class AdminVerifikasiRuangController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "status" => "required|string",
                "admin_id" => "required",
            ]);
            if ($validator->fails()) {
                return new ApiResource(false, $validator->errors(), null);
            }
            if ($request->status !== "DISETUJUI" && $request->status !== "DITOLAK") {
                return new ApiResource(false, "format status tidak valid!", null);
            }
            $findAdmin = User::find($request->admin_id);
            if (!$findAdmin) {
                return new ApiResource(false, "Admin tidak ditemukan", null);
            }
            if ($findAdmin->role !== "ADMIN") {
                return new ApiResource(false, "User ini adalah bukan Admin!", null);
            }
            $data = Verification::find($id)->update([
                [
                    "status" => $request->status,
                    "admin_id" => $request->admin_id,
                ]
            ]);
            if (!$data) {
                return new ApiResource(false, "Gagal verifikasi ruangan", null);
            }
            return new ApiResource(true, "Sukses verifikasi ruangan", $data);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
