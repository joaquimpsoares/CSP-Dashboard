  
<div class="row">
  <div class="col-md-12 mb-2">
    <label for="country">{{ucwords(trans_choice('messages.product', 1))}}</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
        </label>
      </div>
      <select name="product_sku" class="custom-select" id="country_id" required>
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
    <input type="text" id="price" name="price" class="form-control" value="{{ old('price') }}">
  </div>
  <div class="col-md-6 mb-2">
    <label for="msrp">{{ ucwords(trans_choice('messages.msrp', 1)) }}</label>
    <input type="text" id="msrp" name="msrp" class="form-control" value="{{ old('msrp') }}">
  </div>
</div>
<div class="row">
  <div class="col-md-6 mb-4">
    <label for="product_vendor" class="">{{ ucwords(trans_choice('messages.vendor', 1)) }}</label>
    <input type="text" id="product_vendor" name="product_vendor" class="form-control" value="{{ old('product_vendor') }}">
  </div>
  <div class="col-md-6 mb-2">
    <label for="currency">{{ ucwords(trans_choice('messages.currency', 1)) }}</label>
    <input type="text" id="currency" name="currency" class="form-control" value="{{ old('currency') }}">
  </div>
</div>

{{-- <label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
<input type="text" id="address_1" name="address_1" class="form-control mb-4" value="{{ old('address_1') }}" placeholder="1234 Main St">
<label for="address-2" class="">{{ucwords(trans_choice('messages.address_2', 1))}} (optional)</label>
<input type="text" id="address_2" name="address_2" class="form-control mb-4" value="{{ old('address_2') }}" placeholder="Appartment or numer">
<div class="row">
  <div class="col-lg-4 col-md-6 mb-4">
    <label for="address-2" class="">{{ucwords(trans_choice('messages.city', 1))}}</label>
    <input type="text" id="city" name="city" class="form-control mb-4" value="{{ old('city') }}">
  </div>
  <div class="col-lg-4 col-md-6 mb-4">
    <label for="zip">{{ucwords(trans_choice('messages.state', 1))}}</label>
    <input name="state" type="text" class="form-control" id="zip" placeholder="" value="{{ old('state') }}" required >
    <div class="invalid-feedback">
      Zip code required.
    </div>
  </div>
  <div class="col-lg-4 col-md-6 mb-4">
    <label for="zip">Zip</label>
    <input name="postal_code" type="text" class="form-control" id="zip" placeholder="" value="{{ old('postal_code') }}" required>
    <div class="invalid-feedback">
      Zip code required.
    </div>
  </div>

</div>
<hr>
<div class="input-group mb-4">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1">@</span>
  </div>
  <input name="email" type="text" class="form-control py-0" aria-describedby="basic-addon1" value="{{ old('email') }}" placeholder="youremail@example.com">
</div>
<div class="input-group mb-4">
  <div class="input-group-prepend">
    <span class="input-group-text" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i>
    </span>
  </div>
  <input name="username" type="text" class="form-control py-0" aria-describedby="basic-addon1" value="{{ old('username') }}" placeholder="Username (Optional)">
</div>
<div class="row">
  <div class="col-md-12">
    <label for="status">{{ ucwords(trans_choice('messages.status', 1)) }}</label>
    <div class="form-group">
      <select name="status_id" class="form-select" sf-validate="required">
        <option selected></option>
        @foreach ($statuses as $status)    
        <option value="{{$status->id}}">{{ucwords(trans_choice($status->name, 1))}}</option>
        @endforeach
      </select>
    </div>
  </div>
</div> --}}
