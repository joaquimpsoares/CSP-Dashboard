<template>
    <div class="box col-xs-12">
    <h2>Company Information</h2>
    <hr>
    <div class="row"  v-for="customer in customers" >
        <div class="col-md-6">
            <div class="form-group">
                <!-- <label for="company_name" v-text="customer.company_name"></label> -->
                <label for="company_name" Company Name></label>
                <input type="text" class="input" id="company_name"
                name="company_name" required placeholder="Company Name" :value="customer.company_name" data-parsley-required="true" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="nif">NIF</label>
                <input type="text" class="input" id="nif"
                name="nif" placeholder="NIF" :value="customer.nif" data-parsley-required="true" minlength="5" >
            </div>
        </div>
    </div>
    <div>
        <h2>Address Information</h2>
    </div>
    <hr>
    <div class="row" v-for="customer in customers" >
        <div class="col-md-4">
            <div class="form-group">
                <label for="address_1">Address 1</label>
                <input type="text" class="input" id="address_1"
                name="address_1" placeholder="Address 1" :value="customer.address_1">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="address_2">Address 2</label>
                <input type="text" class="input" id="address_2"
                name="address_2" placeholder="Address 2" :value="customer.address_2">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="city">City</label>
                <input type="text" class="input" id="city"
                name="city" placeholder="City" :value="customer.city">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="postal_code">Postal Code</label>
                <input type="text" class="input" id="postal_code"
                name="postal_code" placeholder="Postal Code" :value="customer.postal_code">
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="state">State</label>
                <input type="text" class="input" id="state"
                name="state" required placeholder="State" :value="customer.state">
            </div>
        </div>
        <div class="col-md-4">
            <label for="country">Country</label>
            <select name="country" id="country"></select>
        </div>

        <div class="col-md-4">
            <label for="Tenant_name">Tenant name</label>
            <div class="form-group">
                <input type="text" class="input" id="Tenant_name"
                name="Tenant_name" disabled placeholder="Tenant name" value="Tenant name">
            </div>
        </div>
        <!-- @if(auth()->user()->getRole() != 1)
        <div class="col-md-4">
            <div class="form-group">
                <label for="country">@lang('app.branch')</label>
                <select name="branch_id" class="form-control" data-plugin="newselect2" data-option="{}" >
                    @if(!$edit)
                    <option selected value="0"> -- please select one -- </option>
                    @else
                    <option value="0"> None </option>
                    @endif
                    @foreach($branches as $branch=>$value)
                    <option value="{{$branch}}"  <?php if($edit){if($branch == $customer->branch_id) { echo "selected";}}  ?> style="color:black;"> {{$value}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        @else
        <div class="col-md-4">
            <div class="form-group">
                <label for="country">@lang('app.branch')</label>
                {{$customer->id}}
                <select name="branch_id" class="select" data-plugin="newselect2" data-option="{}"  disabled>
                    @foreach($customer->getBranches($customer->id) as $branch)
                    {{$branch->title}}
                    <option value="{{$branch->id}}"  <?php if($edit){if($branch->id == $customer->branch_id) { echo "selected";}}  ?> style="color:black;"> {{$branch->title}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-md-12">
            @if ($edit)
            <button type="submit" class="button is-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('app.update_details')
            </button>
            <a href="{{ URL::previous() }}">
                <span class="button is-warning" id="update-details-btn">
                    <i class="fa fa-refresh"></i>
                    @lang('app.cancel')
                </span>
            </a>
            @endif
            @if ($view)
            <a href="{{ route('customer.edit', $customer->id) }}">
                <span class="btn btn-info" id="update-details-btn">
                    <i class="fa fa-edit"></i>
                    @lang('app.edit_customer')
                </span>
            </a>
            @endif -->
        </div>
    </div>
</template>

<script>
export default {
    props:[
        'customers'
    ]
}
</script>
