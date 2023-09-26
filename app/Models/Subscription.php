<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cost',
        'available',
        'active'
    ];

    public function users(): hasMany
    {
        return $this->hasMany(User::class);
    }

    public function publications(): belongsToMany
    {
        return $this->belongsToMany(Publication::class)->withTimestamps();
    }
}
