<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roti;
use Illuminate\Http\Request;

use function Pest\Laravel\get;

class ViewKomposisiBahanBakuController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        try {
            $roti = Roti::with("bahans")->get();
            $data = $roti->map(function ($item) {
                return [
                    "Roti" => $item->name,
                    "Bahan" => $item->bahans->map(function ($itemsz) {
                        return [
                            "nama bahan" => $itemsz->name,
                            "quantity used" => $itemsz->pivot->quantity_used
                        ];
                    })
                ];
            });
            return response()->json([
                "status" => true,
                "data" => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "status" => false,
                "message" => $e->getMessage()
            ], 500);
        }
    }
}
