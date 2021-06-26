<?php

namespace App\Http\Livewire;

trait CachedTable{

    protected $useCache = false;

    public function useCacheRows() {
        $this->useCache = true;
    }

    public function cache($callback){
        $cacheKey = $this->id;

        if ($this->useCache && cache()->has($cacheKey)){
            return cache()->get($cacheKey);
        }

        $result = $callback();
        cache()->put($cacheKey, $result);
        return $result;

    }

}
