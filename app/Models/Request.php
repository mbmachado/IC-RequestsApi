<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Request extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'details',
        'attachments',
        'due_date',
        'status',
        'priority',
        'user_id',
        'step_id',
        'request_template_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'attachments' => 'array',
        'due_date' => 'datetime',
        'user_id' => 'integer',
        'request_template_id' => 'integer',
    ];

    /**
     * Get the user that owns the request.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the step that owns the request.
     */
    public function step(): BelongsTo
    {
        return $this->belongsTo(Step::class);
    }

    /**
     * Get the template that owns the request.
     */
    public function requestTemplate(): BelongsTo
    {
        return $this->belongsTo(RequestTemplate::class);
    }

    /*
     * Get the comments for the request.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The users that assigned to the request.
     */
    public function assignees(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'assignees')->as('assignees');
    }

    /**
     * The users that viewed the request.
     */
    public function viewedBy(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'views')->as('viewed_by');
    }
}
