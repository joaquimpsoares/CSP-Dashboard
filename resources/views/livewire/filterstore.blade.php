<div>
    <div class="col-md-2">
        <legend><h3>{{ ucwords(trans_choice('messages.filter', 1)) }}</h3></legend>				
        @foreach ($categories as $category)
        <div class="form-check">
            <input wire:model="filter"  class="form-check-input" type="checkbox" name="" id="">
            <label class="form-check-label" >
                {{$category->category}}
            </label>    
        </div>
        @endforeach
    </div>
</div>
