<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RequestTemplate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'show_title_field',
        'title_field_label',
        'title_field_placeholder',
        'title_field_required',
        'show_details_field',
        'details_field_label',
        'details_field_placeholder',
        'details_field_required',
        'show_attachments_field',
        'attachments_field_label',
        'details_field_required',
        'workflow_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'workflow_id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Get the workflow that owns the request template.
     */
    public function workflow(): BelongsTo
    {
        return $this->belongsTo(Workflow::class);
    }

    /**
     * Get the requests for the request template.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }
}
