<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>  


{{-- {{dd($priceList)}} --}}
{{-- <livewire:price.addprice :priceList="$priceList"/> --}}

<div>
  <div class="row">
    <div class="col-md-12 mb-2">
      <label for="country">{{ucwords(trans_choice('messages.select_product', 1))}}</label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
          </label>
        </div>
        <select  name="product_sku" class="country_select" id="country_select" style="width: 95%" required>
          <option value="">Choose...</option>
          @foreach ($products as $product) 
          <option value="{{$product->sku}}">{{$product->id}} {{$product->name}}</option>
          @endforeach
        </select>
        <div class="invalid-feedback">
          {{ucwords(trans_choice('messages.Please_select_a_valid_country', 1))}}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-4">

      <label for="price" class="">{{ ucwords(trans_choice('messages.price', 1)) }}</label>
      <input type="text" id="price" wire:model="price" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}">
      @error('price')
      <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
      </span>
      @enderror
    </div>
    <div class="col-md-6 mb-2">
      <label for="msrp">{{ ucwords(trans_choice('messages.msrp', 1)) }}</label>
      <input type="text" wire:model="msrp" id="msrp" name="msrp" class="form-control" value="{{ old('msrp') }}">
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 mb-4">
      <label for="product_vendor" class="">{{ ucwords(trans_choice('messages.vendor', 1)) }}</label>
      <input type="text" wire:model="product_vendor" id="product_vendor" name="product_vendor" class="form-control">
    </div>
    <div class="col-md-6 mb-2">
      <label for="currency">{{ ucwords(trans_choice('messages.currency', 1)) }}</label>
      <input type="text" wire:model="currency" id="currency" name="currency" class="form-control" value="{{ old('currency') }}">
    </div>
  </div>
  <div class="col-lg-1 col-md-4 mb-4">
    <a type="button" wire:click="addPrice" class="btn btn-primary">+</a>
  </div>
  <div class="card-footer">        
    <a href="#"  id="bt" onclick="toggle(this)">{{ucwords(trans_choice('messages.tier_price', 2))}}</a>
    <!--The DIV element to toggle visibility. Its "display" property is set as "none". -->
    <div style="padding:10px; display:none;" id="cont">
      <div class="row">
        <div class="col-lg-3 col-md-6 mb-4">
          <label for="name">{{ucwords(trans_choice('messages.tier_name', 1))}}</label>
          <input name="name" type="text" class="form-control" id="name" wire:model="name" placeholder="" value="{{ old('name') }}" required>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <label for="product_sku">{{ucwords(trans_choice('messages.sku', 1))}}</label>
          <input name="product_sku" wire:model="tier_product_sku" type="text" class="form-control" id="product_sku" placeholder="" required>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <label for="min_quantity">{{ucwords(trans_choice('messages.min_quantity', 1))}}</label>
          <input name="min_quantity"  wire:model="tier_min_quantity"  type="number" class="form-control" id="min_quantity" placeholder="" value="{{ old('min_quantity') }}" required>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <label for="max_quantity">{{ucwords(trans_choice('messages.max_quantity', 1))}}</label>
          <input name="max_quantity"  wire:model="tier_max_quantity"  type="number" class="form-control" id="max_quantity" placeholder="" value="{{ old('max_quantity') }}" required>
        </div>
        <div class="col-lg-1 col-md-4 mb-4">
          <label for="price">{{ucwords(trans_choice('messages.price', 1))}}</label>
          <input name="price" wire:model="tier_price" type="number" class="form-control" id="price" placeholder="" value="{{ old('price') }}" required>
        </div>
        <div class="col-lg-1 col-md-4 mb-4">
          <label for="msrp">{{ucwords(trans_choice('messages.msrp', 1))}}</label>
          <input name="msrp" wire:model="tier_msrp" type="number" class="form-control" id="msrp" placeholder="" value="{{ old('msrp') }}" required>
        </div>
        <div class="col-lg-1 col-md-4 mb-4">
          <a type="button" wire:click="addpriceTier" class="btn btn-primary">+</a>
        </div>
        <hr>
        <hr>
        @foreach ($prices as $item)
        @foreach ($item->tiers as $price)
        <div class="col-lg-3 col-md-6 mb-4">
          <label for="tier_name">{{ucwords(trans_choice('messages.tier_name', 1))}}</label>
          <input name="tier_name" type="text"  class="form-control" id="tier_name" placeholder="" value="{{ $price->name }}" required>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <label for="product_sku">{{ucwords(trans_choice('messages.sku', 1))}}</label>
          <input name="product_sku" type="text" class="form-control" id="product_sku" placeholder="" value="{{ $price->sku }}" required>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <label for="min_quantity">{{ucwords(trans_choice('messages.min_quantity', 1))}}</label>
          <input name="min_quantity" type="number" class="form-control" id="min_quantity" placeholder="" value="{{ $price->min_quantity }}" required>
        </div>
        <div class="col-lg-2 col-md-4 mb-4">
          <label for="max_quantity">{{ucwords(trans_choice('messages.max_quantity', 1))}}</label>
          <input name="max_quantity" type="number" class="form-control" id="max_quantity" placeholder="" value="{{ $price->max_quantity }}" required>
        </div>
        <div class="col-lg-1 col-md-4 mb-4">
          <label for="price">{{ucwords(trans_choice('messages.price', 1))}}</label>
          <input name="price"type="number" class="form-control" id="price" placeholder="" value="{{ $price->price }}" required>
        </div>
        <div class="col-lg-1 col-md-4 mb-4">
          <label for="msrp">{{ucwords(trans_choice('messages.msrp', 1))}}</label>
          <input name="msrp" type="number" class="form-control" id="msrp" placeholder="" value="{{ $price->msrp }}" required>
        </div>
        <button wire:click="destroy({{ $price->id }})" class="px-2 py-1 bg-red-200 text-red-500 hover:bg-red-500 hover:text-white rounded">Borrar</button>
        @endforeach
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- 
<script>
  $(document).ready(function() {
    $('.country_select').select2();
  });
</script>


<script>
  function toggle(ele) {
    var cont = document.getElementById('cont');
    if (cont.style.display == 'block') {
      cont.style.display = 'none';
      
      document.getElementById(ele.id).value = 'Show DIV';
    }
    else {
      cont.style.display = 'block';
      document.getElementById(ele.id).value = 'Hide DIV';
    }
  }
</script> --}}
