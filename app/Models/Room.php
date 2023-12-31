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
    public function scopeFilter($query, array $filters)
    {
        if ($filters['q'] ?? false) {
            $query->whereHas('topic', function ($query) use ($filters)
            {
                $query->where('name', 'like', '%' . $filters['q'] . '%');
            })
                 ->orWhere('name', 'like', '%' . $filters['q'] . '%')
                 ->orWhere('description', 'like', '%' . $filters['q'] . '%');
        }
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
