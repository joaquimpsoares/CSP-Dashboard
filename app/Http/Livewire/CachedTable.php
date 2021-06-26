<?php

namespace App\Http\Livewire;

trait CachedTable{

    protected $useCache = false;

    public function useCacheRows() {
        $this->useCache = true;
    }

    public function cache($callback){
        $cacheKey = $this->id;

        if (cache()->has($cacheKey)){
            return cache()->get($cacheKey);
        }

        $result = $callback();
        cache()->put($cacheKey, $result);
        return $result;

    }

}
