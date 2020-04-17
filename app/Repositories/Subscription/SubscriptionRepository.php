<?php

namespace App\Repositories\Subscription;

use Carbon\Carbon;
use App\Subscription;

interface SubscriptionRepository
{

    public function paginate($perPage, $search = null, $status = null, $subscription = null, $branch_id = null);

    public function all();

    public function create(array  $data);

    public function update($id, array $data);

    public function delete($id);

    public function find($id);

    // public function status($id);

    public function getOwner($id);
    public function countsubscriptions();

}
