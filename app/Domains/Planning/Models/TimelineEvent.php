<?php

namespace App\Domains\Planning\Models;

use App\Domains\Platform\Traits\HasUuid;
use App\Domains\Wedding\Traits\BelongsToWedding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimelineEvent extends Model
{
    use HasFactory, HasUuid, BelongsToWedding;

    protected $fillable = [
        'uuid',
        'wedding_id',
        'title',
        'description',
        'event_date',
        'start_time',
        'end_time',
        'location',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'sort_order' => 'integer',
        ];
    }
}
