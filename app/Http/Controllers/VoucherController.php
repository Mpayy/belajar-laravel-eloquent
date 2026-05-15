<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function testCreateVoucher()
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->voucher_code = "CODE-123";
        $voucher->save();

        return response()->json($voucher);
    }

    public function testVoucherUUID()
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->save();

        return response()->json($voucher);
    }

    public function testSoftDelete()
    {
        $voucher = Voucher::where("name", "Sample Voucher")->first();
        $voucher->delete();

        $voucher = Voucher::where("name", "Sample Voucher")->first();

        return response()->json([
            "data" => $voucher,
            "message" => "Data is deleted"
        ]);
    }

    public function testSoftDeleteWithTrashed()
    {
        $voucher = Voucher::where("name", "Sample Voucher")->first();
        $voucher->delete();

        $voucher = Voucher::withTrashed()->where("name", "Sample Voucher")->first();

        return response()->json([
            "message" => "Data still exists",
            "data" => $voucher
        ]);
    }

    public function testLocalScope()
    {
        $voucher = new Voucher();
        $voucher->name = "Sample Voucher";
        $voucher->is_active = true;
        $voucher->save();

        $totalActive = Voucher::active()->count();
        $totalNonActive = Voucher::nonActive()->count();

        return response()->json([
            "message" => "Local Scope",
            "total_active" => $totalActive,
            "total_non_active" => $totalNonActive
        ]);
    }
}
