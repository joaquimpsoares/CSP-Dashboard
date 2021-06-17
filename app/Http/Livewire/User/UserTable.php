<?php

namespace App\Http\Livewire\User;

use App\User;
use Livewire\Component;
use App\Exports\UserExport;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class UserTable extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function exportSelected()
    {
        return Excel::download(new UserExport, 'Users.xlsx');
    }

    public function render()
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

        return view('livewire.user.user-table', compact('users'));
    }
}
