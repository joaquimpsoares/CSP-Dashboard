<?php

namespace App\Http\Livewire\Reseller;

use App\Status;
use App\Country;
use App\Reseller;
use Livewire\Component;
use App\Rules\checkvatIdRule;
use App\Rules\checkPostalCodeRule;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\ClientException;
use Tagydes\MicrosoftConnection\Facades\Customer as TagydesCustomer;

class ShowReseller extends Component
{
    public $reseller;
    public $country;
    public $countries;
    public $statuses;
    public Reseller $editing;
    public $showEditModal = false;
    public $showconfirmationModal = false;

    public function rules()
    {
        return [
            'editing.company_name'          => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            // 'editing.nif'                   => ['required', new checkvatIdRule($this->reseller->country->iso_3166_2),'min:3'],
            'editing.nif'                   => ['required', 'min:3'],
            'editing.country_id'            => ['required', 'integer', 'min:1','exists:countries,id'],
            'editing.address_1'             => ['required', 'string', 'max:255', 'min:3'],
            'editing.address_2'             => ['nullable', 'string', 'max:255', 'min:3'],
            'editing.city'                  => ['required', 'string', 'max:255', 'min:3'],
            'editing.state'                 => ['required', 'string', 'max:255', 'min:3'],
            // 'editing.postal_code'           => ['required', 'string', new checkPostalCodeRule($this->reseller->country->iso_3166_2), 'max:255', 'min:3'],
            'editing.postal_code'           => ['required', 'string', 'max:255', 'min:3'],
            'editing.status_id'             => ['required', 'exists:statuses,id'],
            'editing.markup'                => ['nullable', 'integer', 'min:3'],
            'editing.mpnid'                 => ['nullable', 'integer', 'min:3'],

        ];
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function edit(Reseller $reseller)
    {
        $this->editing = $reseller;
        $this->showEditModal = true;
    }

    public function disable(Reseller $reseller)
    {
        $this->showconfirmationModal = false;
        $reseller->status_id = 2;
        $reseller->save();
        $this->notify('Reseller ' . $reseller->company_name . ' is disabled, refresh page');
    }

    public function enable(Reseller $reseller)
    {
        $reseller->status_id = 1;
        $reseller->save();
        $this->notify('Reseller ' . $reseller->company_name . ' is enabled, refresh page');
    }

    public function save(Reseller $reseller)
    {
        $validatedData = $this->validate();

        try {
            $newCustomer = TagydesCustomer::withCredentials($reseller->provider->instances->first()->external_id, $reseller->provider->instances->first()->external_token)
            ->checkAddress([
                'AddressLine1'  => $this->editing->address_1,
                'City'          => $this->editing->city,
                'State'         => $this->editing->state,
                'PostalCode'    => $this->editing->postal_code,
                'Country'       => $this->editing->country->iso_3166_2,
            ]);

            // if($newCustomer->status === 'NotValidated'){
            //     $this->showEditModal = false;
            //     $this->notify($newCustomer->validationMessage);
            // }

            $this->editing->save();
            $this->showEditModal = false;


        } catch (ClientException $e) {
            $this->showEditModal = false;
            $this->notify('Customer ' . $e->getMessage() . ' created successfully');
            Log::info('Error saving reseller: '.$e->getMessage());
        }

    }

    public function render(Reseller $reseller)
    {
        $countries = Country::get();
        $statuses = Status::get();
        return view('livewire.reseller.show-reseller', compact('statuses','countries', 'reseller'));
    }
}
