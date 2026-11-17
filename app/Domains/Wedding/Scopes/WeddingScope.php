<?php

namespace App\Domains\Wedding\Scopes;

use App\Domains\Wedding\Services\CurrentWeddingManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class WeddingScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $manager = app(CurrentWeddingManager::class);

        if ($manager->hasWedding()) {
            $builder->where($model->getTable() . '.wedding_id', '=', $manager->getId());
        }
    }
}
