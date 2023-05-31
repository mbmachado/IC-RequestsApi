<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Auth::user()->requests()->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:QUESTION,WORKLOAD_CLAIM,ENROLLMENT_PROOF,INTERNSHIP_TERM_SIGNING,',
            'details' => 'nullable|string|max:255',
            'attachments.*' => 'string',
        ]);

        return response()->json(Auth::user()->requests()->create($validated));
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Request $request): JsonResponse
    {
        return response()->json($request->load(['user', 'comments.user']));
    }
}
