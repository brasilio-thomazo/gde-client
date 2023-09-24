<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'privilege',
        'authorities',
        'types',
        'departments',
        'custom',
        'searches'
    ];

    protected $hidden = [];

    protected $casts = [
        'privilege' => 'array',
        'authorities' => 'array',
        'types' => 'array',
        'departments' => 'array',
        'custom' => 'array',
        'searches' => 'array',
    ];

    protected $dateFormat = 'U';

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public static function makeAuthorities(array $privileges): array
    {

        $authorities = [];
        foreach ($privileges as $key => $value) {
            if (!$value || !is_string($value)) continue;
            if (strlen($value) > 1) {
                $values = array_map(fn ($authority) => sprintf('%s:%s', $key, $authority), str_split($value));
                $authorities = array_merge($authorities, $values);
                continue;
            }
            $authorities[] = sprintf('%s:%s', $key, $value);
        }
        return $authorities;
    }
}
