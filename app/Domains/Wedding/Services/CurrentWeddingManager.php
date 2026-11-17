<?php

namespace App\Domains\Wedding\Services;

use App\Domains\Wedding\Models\Wedding;

class CurrentWeddingManager
{
    protected ?Wedding $wedding = null;

    public function set(Wedding $wedding): void
    {
        $this->wedding = $wedding;
    }

    public function get(): ?Wedding
    {
        return $this->wedding;
    }

    public function getId(): ?int
    {
        return $this->wedding?->id;
    }

    public function hasWedding(): bool
    {
        return $this->wedding !== null;
    }

    public function clear(): void
    {
        $this->wedding = null;
    }
}
