<?php

namespace App\Http\Livewire;

use App\Product;
use App\PriceList;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

abstract class SearchDropdown extends Component
{
    public $results;
    public $search;
    public $selected;
    public $showDropdown;

    abstract public function query();

    public function mount()
    {
        $this->showDropdown = false;
        $this->results = collect();
    }

    public function updatedSelected()
    {
        $this->emitSelf('valueSelected', $this->selected);
    }

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = collect();
            $this->showDropdown = false;
            return;
        }

        if ($this->query()) {
            $this->results = $this->query()->get();
        } else {
            $this->results = collect();
        }

        $this->selected = '';
        $this->showDropdown = true;
    }

    public function render()
    {
        return view('livewire.search-dropdown');
    }
}
