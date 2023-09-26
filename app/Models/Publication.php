<?php

namespace App\Models;

use App\Models\Scopes\UserScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Publication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'text',
        'active'
    ];

    protected static function booted(): void
    {
        static::creating(function (Publication $publication) {
            $publication->user_id = Auth::id();
        });

        static::addGlobalScope(new UserScope);
    }

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subscriptions(): belongsToMany
    {
        return $this->belongsToMany(Subscription::class)->withTimestamps();
    }
}
