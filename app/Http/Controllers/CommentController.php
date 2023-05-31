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
    public function store(Request $req, \App\Models\Request $request): JsonResponse
    {
        $validated = $req->validate([
            'value' => 'required',
        ]);

        $comment = $request->comments()->create([
            $validated,
            'user_id' => Auth::id(),
        ]);

        return response()->json($comment);
    }
}
