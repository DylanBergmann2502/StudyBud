<?php

namespace App\Models;

use App\Models\Room;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['body', 'room_id', 'user_id'];

    // Scopes
    protected static function booted(): void
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->orderBy('updated_at', 'desc')->orderBy('created_at', 'desc');
        });
    }

    public function scopeFilter($query, array $filters)
    {
        if ($filters['q'] ?? false) {
            $query->whereHas('room', function ($query) use ($filters)
            {
                $query->whereHas('topic', function ($query) use ($filters)
                {
                    $query->where('name', 'like', '%' . $filters['q'] . '%');
                })
                     ->orWhere('name', 'like', '%' . $filters['q'] . '%')
                     ->orWhere('description', 'like', '%' . $filters['q'] . '%');
            });
        }
    }



    // Relationships
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo {
        return $this->belongsTo(Room::class);
    }
}
