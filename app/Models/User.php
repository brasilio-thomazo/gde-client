<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, HasUuids, SoftDeletes, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'department_id',
        'identity',
        'phone',
        'email',
        'username',
        'password',
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
        'password' => 'hashed',
    ];

    protected $dateFormat = 'U';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        $authorities = [];
        foreach ($this->groups as $group) {
            $authorities = array_merge($authorities, $group->authorities);
        }
        return ['authorities' => $authorities];
    }

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function documentTypes(): array
    {
        $groups = $this->groups;
        $types = [];
        foreach ($groups as $group) {
            if (in_array('0', $group->types)) {
                $types = [];
                break;
            }
            $types = array_merge($types, $group->types);
        }
        return $types;
    }

    public function departments(): array
    {
        $groups = $this->groups;
        $departments = [];
        foreach ($groups as $group) {
            if (in_array(0, $group->departments)) {
                $departments = [];
                break;
            }
            $departments = array_merge($departments, $group->departments);
        }
        return $departments;
    }

    public function searches(): array
    {
        $groups = $this->groups;
        $searches = [];
        foreach ($groups as $group) {
            if (in_array(0, $group->searches)) {
                $searches = [];
                break;
            }
            $searches = array_merge($searches, $group->searches);
        }
        return $searches;
    }

    public function restrictions(): array
    {
        $groups = $this->groups;
        $searches = [];
        $departments = [];
        $types = [];

        $types_all = false;
        $departments_all = false;
        $searches_all = false;

        foreach ($groups as $group) {
            if (in_array(0, $group->searches) && !$searches_all) {
                $searches = [];
                $searches_all = true;
            } else {
                $searches = array_merge($searches, $group->searches);
            }

            if (in_array(0, $group->departments) && !$departments_all) {
                $departments = [];
                $departments_all = true;
            } else {
                $departments = array_merge($departments, $group->departments);
            }

            if (in_array(0, $group->types) && !$types_all) {
                $types = [];
                $types_all = true;
            } else {
                $types = array_merge($types, $group->types);
            }
        }
        return ['searches' => $searches, 'departments' => $departments, 'types' => $types];
    }
}
