<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;
    const maxLengthText = 65535;
    const maxLengthTitle = 80;

    protected $fillable = [
        'title',
        'topic_text',
        'user_id'
    ];
    // Todos los topics que pertenezcan a este usuario
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    // Todos los comentarios que pertenezcan al topic
    public function comments():HasMany {
        return $this->hasMany(Comment::class);
    }
}
