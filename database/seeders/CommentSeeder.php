<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = Product::find("1");
        $comment = new Comment();
        $comment->commentable_type = "product"; //Product::class;
        $comment->commentable_id = $product->id;
        $comment->title = "Title";
        $comment->comment = "Comment Product";
        $comment->email = "rifaih712@gmail.com";
        $comment->save();

        $voucher = Voucher::first("id");
        $comment = new Comment();
        $comment->commentable_type = "voucher"; //Voucher::class;
        $comment->commentable_id = $voucher->id;
        $comment->title = "Title";
        $comment->comment = "Comment Voucher";
        $comment->email = "rifaih712@gmail.com";
        $comment->save();
    }
}
