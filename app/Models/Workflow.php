<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workflow extends Model
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
    ];

    /**
     * Get the templates for the workflow.
     */
    public function requestTemplates(): HasMany
    {
        return $this->hasMany(RequestTemplate::class);
    }

    /**
     * Get the steps for the workflow.
     */
    public function steps(): HasMany
    {
        return $this->hasMany(Step::class);
    }
}
