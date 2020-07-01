<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>  

<div class="row">
  <div class="col-md-12 mb-2">
    <label for="country">{{ucwords(trans_choice('messages.select_product', 1))}}</label>
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <label class="input-group-text" for="country_id"><i class="fa fa-plane" aria-hidden="true"></i>
        </label>
      </div>
      <input type="hidden" name="timelimit" value="0" size="1" />
      <select name="product_sku" class="country_select" id="country_select" style="width: 95%" required>
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

<script>
  $(document).ready(function() {
    $('.country_select').select2();
});
</script>
