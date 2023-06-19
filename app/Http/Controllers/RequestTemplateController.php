<?php

namespace App\Http\Controllers;

use App\Enums\RequestTemplateStatus;
use App\Http\Requests\RequestTemplateRequest;
use App\Models\RequestTemplate;
use Illuminate\Http\JsonResponse;

class RequestTemplateController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(RequestTemplate::class, 'request-template');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $requestTemplates = RequestTemplate::query()
            ->where('status', '=', RequestTemplateStatus::Active->value)
            ->get();

        return response()->json($requestTemplates);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RequestTemplateRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $requestTemplate = RequestTemplate::create($validated);

        return response()->json($requestTemplate);
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestTemplate $requestTemplate): JsonResponse
    {
        return response()->json($requestTemplate->load('workflow.steps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestTemplateRequest $request, RequestTemplate $requestTemplate): JsonResponse
    {
        $validated = $request->validated();

        $requestTemplate->update($validated);

        return response()->json($requestTemplate);
    }
}
