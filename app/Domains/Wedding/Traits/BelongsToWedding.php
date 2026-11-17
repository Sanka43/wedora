<?php

namespace App\Domains\Wedding\Traits;

use App\Domains\Wedding\Models\Wedding;
use App\Domains\Wedding\Scopes\WeddingScope;
use App\Domains\Wedding\Services\CurrentWeddingManager;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToWedding
{
    public static function bootBelongsToWedding(): void
    {
        static::addGlobalScope(new WeddingScope());

        static::creating(function ($model) {
            $manager = app(CurrentWeddingManager::class);

            if ($manager->hasWedding() && empty($model->wedding_id)) {
                $model->wedding_id = $manager->getId();
            }
        });
    }

    public function wedding(): BelongsTo
    {
        return $this->belongsTo(Wedding::class, 'wedding_id');
    }
}
