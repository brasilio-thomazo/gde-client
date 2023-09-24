<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Search extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'show_field',
    ];

    protected $hidden = [];

    protected $casts = [
        'show_field' => 'array'
    ];

    protected $dateFormat = 'U';
}
