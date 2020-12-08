<?php

namespace App\Http\Traits;

trait UserTrait {

	public function getUser() 
	{
		$user = \Auth::user();

    	return $user;
	}

	public function getUserLevel() 
	{
		$user = \Auth::user();
    	return $user->userLevel->name;
	}
}