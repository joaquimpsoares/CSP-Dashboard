<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('app.role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->role->id : '',
                ['class' => 'select', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="status">@lang('app.status')</label>
            {!! Form::select('status', $statuses, $edit ? $user->status : '',
                ['class' => 'select', 'id' => 'status', $profile ? 'disabled' : '']) !!}
        </div>
        <div class="form-group">
            <label for="first_name">@lang('app.first_name')</label>
            <input type="text" class="input" id="first_name"
                   name="first_name" placeholder="@lang('app.first_name')" value="{{ $edit ? $user->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('app.last_name')</label>
            <input type="text" class="input" id="last_name"
                   name="last_name" placeholder="@lang('app.last_name')" value="{{ $edit ? $user->last_name : '' }}">
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="phone">@lang('app.phone')</label>
            <input type="text" class="input" id="phone"
                   name="phone" placeholder="@lang('app.phone')" value="{{ $edit ? $user->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('app.address')</label>
            <input type="text" class="input" id="address"
                   name="address" placeholder="@lang('app.address')" value="{{ $edit ? $user->address : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('app.country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control']) !!}
        </div>
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('app.update_details')
            </button>
        </div>
    @endif
</div>
