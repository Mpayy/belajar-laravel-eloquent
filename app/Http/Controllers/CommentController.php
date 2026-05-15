<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function testCreateComment()
    {
        $comment = new Comment();
        $comment->email = "rifaih712@gmail.com";
        $comment->title = "Sample Title";
        $comment->comment = "Sample Comment";
        $comment->save();

        return response()->json([
            'message' => 'Comment created successfully',
            'data' => $comment
        ]);
    }

    public function testDefaultAttributesValues()
    {
        $comment = new Comment();
        $comment->email = "rifaih712@gmail.com";
        $comment->save();

        return response()->json([
            'message' => 'Comment with defaul attributes created successfully',
            'data' => $comment
        ]);
    }
}
