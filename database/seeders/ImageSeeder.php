<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        {
            $images = new Image();
            $images->url = "https://www.programmerzamannow.com/image/1.jpg";
            $images->imageable_id = "PAI";
            $images->imageable_type = "customer"; //Customer::class;
            $images->save();
        }
        {
            $images = new Image();
            $images->url = "https://www.programmerzamannow.com/image/2.jpg";
            $images->imageable_id = "1";
            $images->imageable_type = "product"; //Product::class;
            $images->save();
        }
    }
}
