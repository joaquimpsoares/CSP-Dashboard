<?php

namespace App\Http\Livewire\Subscription;

use App\Subscription;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\SubscriptionsExport;
use Maatwebsite\Excel\Facades\Excel;

class SubscriptionTable extends Component
{
    use WithPagination;
    public $search = '';

    public function exportSelected()
    {
        return Excel::download(new SubscriptionsExport, 'Subscriptions.xlsx');
    }

    public function render()
    {

        $query = Subscription::query();
        $subscriptions = $query
            ->where(function ($q)  {
                $q->where('name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
                $q->orWhere('billing_period', 'like', "%{$this->search}%");
                $q->orwhereHas('customer', function(Builder $q){
                    $q->where('company_name', 'like', "%{$this->search}%");
                });
            })->paginate(10);


        // $subscriptions->getCollection()->map(function(Subscription $subscription){
        //     $subscription->setRawAttributes(json_decode(json_encode($subscription->format()), true)); // Coverts to array recursively (make helper from it?)
        //     return $subscription;
        // });
        return view('livewire.subscription.subscription-table', compact('subscriptions'));
    }
}
