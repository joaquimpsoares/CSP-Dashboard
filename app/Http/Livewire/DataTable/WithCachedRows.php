<?php

namespace App\Http\Livewire\DataTable;

trait WithCachedRows
{
    protected $useCache = false;

    public function useCachedRows()
    {
        $this->useCache = true;
    }

    public function cache($callback)
    {
        // Livewire v3 no longer exposes a public $id property on components.
        // Use getId() when available; otherwise fall back to spl_object_hash.
        $cacheKey = method_exists($this, 'getId')
            ? $this->getId()
            : (property_exists($this, 'id') ? $this->id : spl_object_hash($this));

        if ($this->useCache && cache()->has($cacheKey)) {
            return cache()->get($cacheKey);
        }

        $result = $callback();

        cache()->put($cacheKey, $result);

        return $result;
    }
}
