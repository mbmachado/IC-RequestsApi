<?php

namespace App\Http\Controllers;

use App\Enums\WorkflowStatus;
use App\Http\Requests\WorkflowRequest;
use App\Models\Step;
use App\Models\Workflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class WorkflowController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(Workflow::class, 'workflow');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $workflows = Workflow::where('status', '=', WorkflowStatus::Active)->get();

        return response()->json($workflows);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkflowRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $workflow = Workflow::create(
            $validated
        );

        $workflow->steps()->createMany($validated['steps']);

        return response()->json($workflow);
    }

    /**
     * Display the specified resource.
     */
    public function show(Workflow $workflow): JsonResponse
    {
        return response()->json($workflow->load(['steps', 'requestTemplates']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkflowRequest $request, Workflow $workflow): JsonResponse
    {
        try {
            $input = $request->validated();

            DB::transaction(function () use ($workflow, $input) {
                $workflow->update($input);

                $steps = $this->splitSteps($input['steps']);
                $ids = $workflow->steps()->pluck('id')->all();

                $workflow->steps()->createMany($steps['new']);

                $this->updateSteps($steps['old']);
                $this->checkAndDeleteSteps($steps['ids'], $ids);
            });

            return response()->json($workflow);
        } catch (\Throwable) {
            return response()->json([
                'message' => 'Não foi possível atualizar Fluxo de Trabalho.'
            ], 500);
        }
    }

    /**
     * Create an array of steps from an array with all steps
     */
    public function splitSteps(array $steps): array
    {
        $ids = []; $new = []; $old = [];

        foreach($steps as $step) {
            if(empty($number['id'])) {
                $new[] = $step;
            } else {
                $old[] = $step;
                $ids[] = $step['id'];
            }
        }

        return [
            'new' => $new,
            'old' => $old,
            'ids' => $ids
        ];
    }

    /**
     * Update the specified resources in storage
     */
    public function updateSteps(array $steps)
    {
        foreach ($steps as $data) {
            $step = Step::findOrFail($data['id']);
            $step->update($data);
        }
    }

    /**
     * Check and delete the specified resources
     * in storage if necessary
     */
    public function checkAndDeleteSteps(array $actualIds, array $oldIds): void
    {
        foreach ($oldIds as $id) {
            if(!in_array($id, $actualIds)) {
                $step = Step::findOrFail($id);
                $step->delete();
            }
        }
    }
}
