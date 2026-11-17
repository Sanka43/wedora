<?php

namespace App\Domains\Wedding\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeddingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'wedding_id',
        'timezone',
        'currency',
        'budget_alert_threshold_pct',
        'is_public_rsvp_enabled',
        'notification_email_on_task_due',
    ];

    protected function casts(): array
    {
        return [
            'budget_alert_threshold_pct' => 'integer',
            'is_public_rsvp_enabled' => 'boolean',
            'notification_email_on_task_due' => 'boolean',
        ];
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class);
    }
}
