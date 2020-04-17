<?php

namespace App\Repositories\News;

use Carbon\Carbon;
use App\Reseller;

interface NewsRepository
{

    public function paginate($perPage, $search = null);

    public function all();

    public function create(array  $data);

    public function update($id, array $data);

    public function delete($id);

    public function find($id);

    public function status($id);

    public function countMainOffice();

}
