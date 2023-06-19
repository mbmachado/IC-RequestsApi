<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, \App\Models\Request $_request): JsonResponse
    {
        $validated = $request->validate([
            'value' => 'required',
        ]);

        $comment = $_request->comments()->create([
            ...$validated,
            'user_id' => Auth::id(),
        ]);

        return response()->json($comment->load('user'));
    }
}
