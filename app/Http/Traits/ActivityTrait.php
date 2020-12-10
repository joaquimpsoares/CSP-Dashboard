<?php

namespace App\Http\Traits;

use ReflectionClass;
use App\Models\Activities;
use Illuminate\Support\Facades\Auth;

trait ActivityTrait {

    protected static function boot(){

        parent::boot();

        foreach(static::getModelEvents() as $event) {

            static::$event(function($model) use ($event){

                $model->addActivity($event);

            });
        }

    }

    protected function addActivity($event){
        // dd(Auth::user()->id);
        Activities::create([
            'subject_id' => $this->id,
            'subject_type' => get_class($this),
            'name' => $this->getActivityName($this,$event),
            'user_id' =>  Auth::user()->id,
            // 'user_id' => $this->id,
        ]);
    }

    protected function getActivityName($model,$action){
        $name= strtolower((new ReflectionClass($model))->getShortName());
        return"{$action}_{$name}";
    }

    protected static function getModelEvents(){
        if (isset(static::$recordEvents)){
            return static::$recordEvents;
        }
        return ['created','deleted','updated'];
    }
}
