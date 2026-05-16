<?php

namespace Database\Seeders;

use App\Models\VirtualAccount;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VirtualAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $wallet = Wallet::where("customer_id", "PAI")->firstOrFail();

        $virtualAccpunt = new VirtualAccount();
        $virtualAccpunt->bank = "BCA";
        $virtualAccpunt->va_number = "123456789";
        $virtualAccpunt->wallet_id = $wallet->id;
        $virtualAccpunt->save();
    }
}
