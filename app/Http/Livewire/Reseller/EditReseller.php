<?php

namespace App\Http\Livewire\Reseller;

use App\Status;
use App\Country;
use App\Reseller;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class EditReseller extends Component
{
    public $reseller;
    public $company_name;
    public $nif;
    public $messageText = '';
    public $country_id;
    public $address_1;
    public $address_2;
    public $city;
    public $state;
    public $postal_code;
    public $mpnid;
    public $status;
    public $markup;

    protected $rules = [
        'company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
        'nif'                   => ['required', 'min:3'],
        'country_id'            => ['required', 'integer', 'min:1'],
        'address_1'             => ['required', 'string', 'max:255', 'min:3'],
        'address_2'             => ['nullable', 'string', 'max:255', 'min:3'],
        'city'                  => ['required', 'string', 'max:255', 'min:3'],
        'state'                 => ['required', 'string', 'max:255', 'min:3'],
        'postal_code'           => ['required', 'string', 'regex:/^[0-9A-Za-z.\-]+$/', 'max:255', 'min:3'],
        'status'                => ['required', 'exists:statuses,id'],
        'markup'                => ['nullable', 'integer', 'min:3'],
        'mpnid'                 => ['nullable', 'integer', 'min:3'],
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }


    public function mount(Reseller $reseller)
    {
        $this->company_name = $reseller->company_name;
        $this->nif          = $reseller->nif;
        $this->country_id   = $reseller->country_id;
        $this->address_1    = $reseller->address_1;
        $this->address_2    = $reseller->address_2;
        $this->city         = $reseller->city;
        $this->state        = $reseller->state;
        $this->postal_code  = $reseller->postal_code;
        $this->status       = $reseller->status->id;
        $this->markup       = $reseller->markup;
        $this->mpnid        = $reseller->mpnid;

    }




    public function save()
    {
        $this->validate();
    try {
        DB::beginTransaction();


            $this->reseller->company_name  = $this->company_name;
            $this->reseller->nif           = $this->nif;
            $this->reseller->country_id    = $this->country_id;
            $this->reseller->address_1     = $this->address_1;
            $this->reseller->address_2     = $this->address_2;
            $this->reseller->city          = $this->city;
            $this->reseller->state         = $this->state;
            $this->reseller->postal_code   = $this->postal_code;
            $this->reseller->status_id     = $this->status;
            $this->reseller->mpnid         = $this->mpnid;
            $this->reseller->save();

            DB::commit();
        } catch (\PDOException $e) {
            DB::rollBack();
            if ($e->errorInfo[1] == 1062) {
                $e = "errors.user_already_exists";
            } else {
                $this->messageText = $e->getMessage();
                session()->flash('danger', $this->messageText );
                return redirect()->back();
            }
        }

        session()->flash('success','Reseller ' . $this->company_name . ' Updated Successfully');
        return redirect()->back();

        }


    public function render()
    {
        // $reseller = $this->reseller;
        // $company_name = $reseller->company_name;

        $countries  = Country::pluck( 'name','id');
        $statuses   = Status::pluck( 'name','id');
        return view('livewire.reseller.edit-reseller', compact('countries','statuses'));
    }
}
