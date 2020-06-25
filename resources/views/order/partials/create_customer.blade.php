  
  <div class="row">
    <div class="col-md-6 mb-4">
      <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
      <input type="text" id="company_name" name="company_name" class="form-control" value="{{ old('company_name') }}">
    </div>
    <div class="col-md-6 mb-2">
      <label for="nif">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
      <input type="text" id="nif" name="nif" class="form-control" value="{{ old('nif') }}">
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 mb-2">
      <label for="country">{{ucwords(trans_choice('messages.country', 1))}}</label>
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
          </label>
        </div>
        <select name="country_id" class="custom-select" id="country_id" required>
          <option value="">Choose...</option>
          @foreach ($countries as $country)    
          <option value="{{$country->id}}">{{$country->name}}</option>
          @endforeach
        </select>
        <div class="invalid-feedback">
          {{ucwords(trans_choice('messages.Please_select_a_valid_country', 1))}}
        </div>
      </div>
    </div>
  </div>
  <label for="address" class="">{{ucwords(trans_choice('messages.address_1', 1))}}</label>
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
  </div>
