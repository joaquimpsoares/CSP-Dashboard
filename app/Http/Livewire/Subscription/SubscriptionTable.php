<?php

namespace App\Http\Livewire\Subscription;

use Livewire\Component;
use App\Exports\SubscriptionsExport;
use App\Subscription;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionTable extends Component
{
    public $search = '';

    public function exportSelected()
    {
        return Excel::download(new SubscriptionsExport, 'Subscriptions.xlsx');
    }

    public function render()
    {
        $search = $this->search;
        $query = Subscription::query();
        $subscriptions = $query
            ->where(function ($q)  {
                $q->where('name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
            })->
            paginate(10);


        // $subscriptions->getCollection()->map(function(Subscription $subscription){
        //     $subscription->setRawAttributes(json_decode(json_encode($subscription->format()), true)); // Coverts to array recursively (make helper from it?)
        //     return $subscription;
        // });
        return view('livewire.subscription.subscription-table', compact('subscriptions'));
    }
}
