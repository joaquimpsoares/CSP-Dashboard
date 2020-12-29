<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
	public function all();

    public function create($user = null, $type = null, $model = null);

    public function paginate($perPage, $search = null, $status = null);
}
