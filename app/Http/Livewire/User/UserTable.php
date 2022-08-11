<?php

namespace App\Http\Livewire\User;

use App\User;
use App\Country;
use Livewire\Component;
use App\Exports\UserExport;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use GuzzleHttp\Exception\ClientException;

class UserTable extends Component
{
    use WithPagination;
    public User $editing;

    public $search = '';
    public $showuserCreateModal = false;
    public $showEditModal = false;

    public function rules()
    {
        return [
            'editing.name'         => ['required', 'string', 'regex:/^[.@&]?[a-zA-Z0-9 ]+[ !.@&()]?[ a-zA-Z0-9!()]+/', 'max:255'],
            'editing.last_name'    => ['required', 'min:3'],
            'editing.socialite_id' => ['required', 'integer', 'min:1','exists:countries,id'],
            'editing.email'        => ['required', 'email', 'unique:users', 'max:255', 'min:3'],
            'editing.phone'        => ['required', 'string', 'max:255', 'min:3'],
            'editing.username'     => ['required', 'string', 'max:255', 'min:3'],
            'editing.address'      => ['required', 'string', 'max:255', 'min:3'],
            'editing.state'        => ['required', 'string', 'max:255', 'min:3'],
            'editing.status_id'    => ['required', 'exists:statuses,id'],
            'editing.country_id'   => ['required', 'exists:countries,id'],
            'editing.locale'       => ['required', 'string', 'max:255', 'min:3'],
            // 'password'                      => ['same:password_confirmation', 'required', 'min:6'],
            // 'password_confirmation'         => ['same:password', 'required', 'min:6'],
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new UserExport, 'Users.xlsx');
    }

    public function edit(User $user){
        $this->showuserCreateModal = false;
        $this->editing = $user;
        $this->showEditModal = true;
    }


    public function save(User $user)
    {
        try {
            $this->editing->save();
            $this->showEditModal = false;

        } catch (ClientException $e) {
            $this->showEditModal = false;
            $this->notify('Customer ' . $e->getMessage() . ' created successfully');
            Log::info('Error saving reseller: '.$e->getMessage());
        }

    }

    public function render(Country $countries)
    {
        $search = $this->search;

        $query = User::query();

        $users = $query
            ->where(function ($q)  {
                $q->where('name', "like", "%{$this->search}%");
                $q->orWhere('id', 'like', "%{$this->search}%");
            })->
            with(['country', 'status'])->paginate(10);

        $users->getCollection()->map(function(User $user){
            $user->setRawAttributes(json_decode(json_encode($user->format()), true)); // Coverts to array recursively (make helper from it?)
            return $user;
        });
        $countries = Country::get();

        return view('livewire.user.user-table', compact('users','countries'));
    }
}
