<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
        'topic_id',
        'user_id'
    ];
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function topic(): BelongsTo {
        return $this->belongsTo(Topic::class);
    }
}
