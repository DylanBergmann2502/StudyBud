<?php

namespace App\Models;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'host_id', 'topic_id'];

    // Scopes
    protected static function booted(): void
    {
        static::addGlobalScope('order_by', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
        });
    }

    // Relationships
    public function topic(): BelongsTo {
        return $this->belongsTo(Topic::class);
    }

    public function host(): BelongsTo {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function participants(): BelongsToMany {
        return $this->belongsToMany(User::class, 'participant_room', 'room_id', 'participant_id');
    }

    public function messages(): HasMany {
        return $this->hasMany(Message::class);
    }
}
