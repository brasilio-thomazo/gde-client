<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentFlag extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'flag_type',
        'comment',
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dateFormat = 'U';
}
