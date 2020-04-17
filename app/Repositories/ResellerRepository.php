<?php

namespace App\Repositories;

use App\Http\Traits\UserTrait;
use App\Repositories\ResellerRepositoryInterface;
use App\Reseller;

/**
 * 
 */
class ResellerRepository implements ResellerRepositoryInterface
{
	
	use UserTrait;

	public function all()
	{

		switch ($this->getUserLevel()) {
			case config('app.super_admin'):
			$resellers = Reseller::whereNull('main_office')
			->with(['country', 'subResellers', 'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
			->get()
			->map->format();
			break;

			case config('app.admin'):
			$resellers = Reseller::whereNull('main_office')
			->with(['country', 'subResellers', 'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
			->get()
			->map->format();
			break;

			case config('app.provider'):
			$resellers = $user->provider->resellers()->whereNull('main_office')
			->with(['country', 'subResellers', 'status' => function ($query) {
				$query->where('name', 'message.active');
			}])
			->orderBy('company_name')
			->get()->map->format();
			break;

			default:
			return abort(403, __('errors.unauthorized_action'));
			break;
		}

		return $resellers;
	}



}
