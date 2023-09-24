<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Privilege extends Model
{
    use HasFactory;

    protected $connection = "system";
    protected $table = 'privileges';

    protected $fillable = [
        'group_id',
        'group',
        'user',
        'client',
        'app',
        'authorities',
    ];

    protected $hidden = [];

    protected $casts = [
        'authorities' => 'array'
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
