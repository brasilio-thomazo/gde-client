<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentImage extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'document_id',
        'filename',
        'storage_type',
    ];

    protected $hidden = [];

    protected $casts = [];

    protected $dateFormat = 'U';

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
