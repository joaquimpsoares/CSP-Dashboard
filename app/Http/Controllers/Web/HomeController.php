<?php

namespace App\Http\Controllers\Web;

use App\User;
use App\Status;
use App\Country;
use App\Instance;
use App\Provider;
use App\Reseller;
use App\AzureResource;
use App\OrderProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Repositories\CustomerRepositoryInterface;
use App\Repositories\ProviderRepositoryInterface;
use App\Repositories\ResellerRepositoryInterface;
use Tagydes\MicrosoftConnection\Models\Customer as TagydesCustomer;
use Tagydes\MicrosoftConnection\Models\Subscription as TagydesSubscription;
use Tagydes\MicrosoftConnection\Facades\AzureResource as FacadesAzureResource;

class HomeController extends Controller
{


    private $providerRepository;
    private $resellerRepository;
    private $customerRepository;
    private $userRepository;



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ProviderRepositoryInterface $providerRepository, ResellerRepositoryInterface $resellerRepository, CustomerRepositoryInterface $customerRepository)
    {
        $this->providerRepository = $providerRepository;
        $this->resellerRepository = $resellerRepository;
        $this->customerRepository = $customerRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Provider $provider)
    {
        $budget = cache()->remember('azure.budget', 260, function(){
            
            $customer = new TagydesCustomer([
                'id' => 'd9b842d6-aa51-44ca-a77c-f7d20411b942',
                'username' => 'bill@tagydes.com',
                'password' => 'blabla',
                'firstName' => 'Nombre',
                'lastName' => 'Apellido',
                'email' => 'bill@tagydes.com',
                ]);
            
            $subscription = new TagydesSubscription([
                'id'            => 'C01AD64D-6D65-45C4-B755-C11BD4F0DA0E',
                'orderId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
                'offerId'       => "C01AD64D-6D65-45C4-B755-C11BD4F0DA0E",
                'customerId'    => "d9b842d6-aa51-44ca-a77c-f7d20411b942",
                'name'          => "5trvfvczdfv",
                'status'        => "5trvfvczdfv",
                'quantity'      => "1",
                'currency'      => "EUR",
                'billingCycle'  => "monthly",
                'created_at'    => "5trvfvczdfv",
                ]);
                
                return (int) FacadesAzureResource::withCredentials(
                    "66127fdf-8259-429c-9899-6ec066ff8915",
                    "0.AR8Avm8sxJPBvEysW4TAgCGExd9_EmZZgpxCmJluwGb_iRUfADg.AQABAAAAAAAm-06blBE1TpVMil8KPQ41TGM2nhO8VJjR0mjT74eA5Vtiwae9puUdJV6wXOnCFBXCJaBrg9sTGV1VWMdi_N-zAvh-cM7feaHQFv3j9glW9VTjhfNpeHgBN2B_-j6jUMhrnrwtli972ZGiQGVlkvBaUm3pYnODccLh9cHQmajkSoabxl9tRwJTbu-d0HwYO9qB8KwvibTt8z7TYIwU0-96eDruYNq3CNvU3fOLajnjAq9_wRhqRSGvThIVVXbbxNF6FBK8vyCt4Dr1xzmrD0wJdWJEaJdRYlzTFgtGJnmi85AxTp99mwCL4UfMnx-eQWGCtLy9wTnYBkmsE-QiYyuFkSMUbPzaTEp2KDQKTw0BqrgVuSC9G8lhFyjY2bQZ6d1c25VqWdjtc56wp8rQUaCfIxcYXUckM1xHPeK_aJDnohL1RQIv8PkC1rZyetQ9U8pWiJNHw6ncwDn47qPDEmEWMelVokrk-zNPmIpWOQ7x38b7w06Ycn0dLb2vxNA_yOAT8N_Pp_MO_aAIkNBgm2nYYrkm1TmTH0eUnBu-lDI-IVq7VuALw5OEjsf780cVDb0tGYFRJ9JcZj105e8vYtN-JhzhwERCx6uoMrjFrIumIQC4OIRyYOBdMppmyOD0Yx-0nncRLYZGwr8AlUyeA1M7ysFyCLqE1ppy5rIwXx7PvTTB46_8vQbkX47926rydiHxphHNxIUh7DUsHBHdrp06O_Ib_crCLm9rhSIxmdrGADaF_iLG2lvruUVRMld7Eui7KY2SBlzOkv3aLHccjheF5bUEvjDRGjrI1l31RH3U-gk4BwB0FAnqE640crngFqrYS3my0bTOSs18uTMp8JyPYGhFpL9Mr4ihwxS4N5OjrFQ6hejYMg14wnY52Mcgfy1CQglQPtylU6sv7xA1Rm1cV-VJqqlN4zK8y6hPF230Mf5qSSn11hyk2wG9bISO-c44uzSOYUY81Zm2HkboUgDz4xUEJnQhRdU_7ySuS1KEOMz_I0jzZ6756aWvMNqlKlKXkGw9d4K4AWhrSKYLl8PIN-5gvaBKVl3DKekDdkhqUgW61hjWUFfuBLWOGWC-5oogAA"
                    )->budget($customer, $subscription);
                });
                $costSum = AzureResource::sum('cost');
                $increase = ($budget-$costSum);
                $average1 = ($increase/$budget)*100;
                $average = 100-$average1;
                
                
                $statuses = Status::get();
                
                
                $countries = Country::all();
                $resellers = $this->resellerRepository->resellersOfProvider($provider);
                $customers = new Collection();
                
                foreach ($resellers as $reseller){
                    $reseller = Reseller::find($reseller['id']);
                    $customers = $customers->merge($this->customerRepository->customersOfReseller($reseller));
                }

                $reseller = Reseller::get();
                $countResellers = $reseller->count();
                // dd($countCustomers);
                
                $instance = Instance::first();
                
                $order = OrderProducts::get();
                
                $users = User::where('provider_id', $provider->id)->first();
                
                $subscriptions = $this->providerRepository->getSubscriptions($provider);
                $countCustomers =  $customers->count();
                $countSubscriptions = $subscriptions->count();
                
                $countries = Country::all();
                $providers = $this->providerRepository->all();
                return view('home', compact('provider','resellers','customers','instance','users',
                'countries','subscriptions','order','statuses','countResellers',
                'countCustomers','countSubscriptions','average', 'budget','providers','countries'));
        // return view('home');
    }
    
    public function dashboard()
    {
        return view('dashboard');
    }
}
