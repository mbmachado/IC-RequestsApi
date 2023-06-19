<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'course',
        'enrollment_number',
        'role',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the requests for the user.
     */
    public function requests(): HasMany
    {
        return $this->hasMany(Request::class);
    }

    /**
     * Get the comments for the user.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The requests assigned to the user.
     */
    public function assignedToMe(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'assignees')->as('assigned_to_me');
    }

    /**
     * The requests viewed by the user.
     */
    public function viewedRequests(): BelongsToMany
    {
        return $this->belongsToMany(Request::class, 'views')->as('viewed_requests');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [
            'user' => [
                'name' => $this->name,
                'course' => $this->course,
                'type' => $this->type,
                'role' => $this->role,
            ],
        ];
    }

    public function isAdmin(): bool {
        return $this->role === UserRole::Admin->value;
    }

    public function isRequester(): bool {
        return $this->role === UserRole::Requester->value;
    }
}
