<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="name">@lang('Role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->roles->first()->id : '',
            ['class' => 'form-control input-solid', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="status">@lang('Status')</label>
            {!! Form::select('status', $statuses, $edit ? $user->status : '',
            ['class' => 'form-control input-solid', 'id' => 'status', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid" id="name"
            name="name" placeholder="@lang('First Name')" value="{{ $edit ? $user->name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid" id="last_name"
            name="last_name" placeholder="@lang('Last Name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="socialite_id">@lang('socialite_id')</label>
            <div class="form-group">
                <input type="text"
                name="socialite_id"
                id='socialite_id'
                value="{{ $edit && $user->socialite_id ? $user->socialite_id : '' }}"
                class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone_number"
            name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid" id="address"
            name="address" placeholder="@lang('Address')" value="{{ $edit ? $user->address : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div>
    </div>
    @if ($edit)
    <div class="col-md-12 mt-2">
        <button type="submit" class="btn btn-primary" id="update-details-btn">
            <i class="fa fa-refresh"></i>
            @lang('Update Details')
        </button>
    </div>
    @endif
</div>
