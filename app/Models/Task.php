<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done',
        'scheduled_at',
        'due_at',
    ];

    protected $casts = [
        'is_done' => 'boolean',
    ];


    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }


    public function project(): BelongsTo
    {
        return $this->belongsTo(project::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopeScheduledBetween(Builder $query, string $fromDate, string $toDate)
    {
        $query->whereBetween('scheduled_at', [$fromDate, $toDate]);
    }

    public function scopeDueBetween(Builder $query, string $fromDate, string $toDate)
    {
        $query->whereBetween('due_at', [$fromDate, $toDate]);
    }

    public function scopeDue(Builder $query, string $filter)
    {
        if ($filter === 'today')
        {
            $query = $query->whereDate('due_at', '>=', now());
        }
        else if ($filter === 'past')
        {
            $query = $query->whereDate('due_at', '<', now());
        }
        $query->whereBetween('due_at', [$fromDate, $toDate]);
    }

    protected static function booted(): void
    {
        static::addGlobalScope('member',function(Builder $builder) {
            $builder->where('creator_id', Auth::id())
                ->orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
        });
    }

}
