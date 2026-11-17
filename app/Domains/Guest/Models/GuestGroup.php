<?php

namespace App\Domains\Guest\Models;

use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuestGroup extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'name',
    ];

    public function guests(): HasMany
    {
        return $this->hasMany(Guest::class);
    }
}
