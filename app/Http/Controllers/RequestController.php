<?php

namespace App\Http\Controllers;


use App\Enums\CommentSource;
use App\Enums\RequestPriority;
use App\Enums\RequestStatus;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class RequestController extends Controller
{
    /**
     * Create the controller instance.
     */
    public function __construct()
    {
        $this->authorizeResource(\App\Models\Request::class, 'request');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $query = QueryBuilder::for(\App\Models\Request::class)
            ->allowedFilters([
                AllowedFilter::exact('status'),
                AllowedFilter::exact('priority'),
            ])
            ->defaultSort('-created_at')
            ->with(['assignees', 'step']);

        if ($user->isAdmin()) {
            return response()->json($query->paginate(10));
        }

        return response()->json(
            $query->where('user_id', '=', $user->id)->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'details' => 'nullable|string|max:255',
            'attachments.*' => 'string',
        ]);

        return response()->json(
            Auth::user()->requests()->create([
                ...$validated,
                'due_date' => now()->addDays(2),
                'step_id' => 1,
                'request_template_id' => 1,
            ])
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $request->viewedBy()->attach($user->id);
        }

        return response()->json(
            $request->load([
                'assignees',
                'comments.user',
                'requestTemplate.workflow.steps',
                'step',
                'user',
            ])
        );
    }

    /**
     * Attach assignee.
     * @throws AuthorizationException
     */
    public function attachAssignee(\App\Models\Request $request, User $user): Response {
        $this->authorize('update', $request);

        $request->assignees()->attach([$user->id]);

        return response()->noContent();
    }

    /**
     * Detach assignee.
     * @throws AuthorizationException
     */
    public function detachAssignee(\App\Models\Request $request, User $user): Response {
        $this->authorize('update', $request);

        $request->assignees()->detach([$user->id]);

        return response()->noContent();
    }

    /**
     * Change request status.
     * @throws AuthorizationException
     */
    public function changeStatus(Request $request, \App\Models\Request $_request): Response {
        $this->authorize('update', $_request);

        $status = join(',', RequestStatus::getValues());

        $input = $request->validate([
            'status' => "required|in:$status",
            'reason' => 'required|string|max:255',
        ]);

        $_request->update($input);
        $_request->comments()->create([
            'value' => "[Status alterado para {$_request->status}] " . $input['reason'],
            'source' => CommentSource::System,
        ]);

        return response()->noContent($_request->load(['user', 'comment.user']));
    }

    /**
     * Change request priority.
     * @throws AuthorizationException
     */
    public function changePriority(Request $request, \App\Models\Request $_request): Response {
        $this->authorize('update', $_request);

        $priorities = join(',', RequestPriority::getValues());

        $input = $request->validate([
            'priority' => "required|in:$priorities",
            'reason' => 'required|string|max:255',
        ]);

        $_request->update($input);
        $_request->comments()->create([
            'value' => "[Prioridade alterada para {$_request->priority}] " . $input['reason'],
            'source' => CommentSource::System,
        ]);

        return response()->noContent($_request->load(['user', 'comment.user']));
    }
}
