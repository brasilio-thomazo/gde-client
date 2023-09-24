<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Group extends Model
{
    use HasFactory;

    protected $connection = "system";
    protected $table = 'groups';

    protected $fillable = [
        'name',
    ];

    protected $hidden = [];

    protected $casts = [];

    public function privilege(): HasOne
    {
        return $this->hasOne(Privilege::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
