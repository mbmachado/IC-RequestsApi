<?php

namespace App\Http\Controllers;

use App\Http\Requests\FileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class MediaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(FileRequest $request): JsonResponse
    {
        try {
            $name = $request->file('content')->getClientOriginalName();

            $path = $request->file('content')->storeAs(Auth::id(), $name);

            return response()->json([ $path ]);
        } catch(\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
