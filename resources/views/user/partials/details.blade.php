<div class="row">
    <div class="col-md-6">
        {{-- <div class="form-group">
            <label for="name">@lang('Role')</label>
            {!! Form::select('role_id', $roles, $edit ? $user->roles->first()->id : '',
            ['class' => 'form-control input-solid', 'id' => 'role_id', $profile ? 'disabled' : '']) !!}
        </div> --}}

        <div class="form-group">
            <label for="status">@lang('Status')</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" sf-validate="required">
                @if ($edit)
                <option value="{{ $edit && $user->status->id ? $user->status->id : ''}}" selected>{{ucwords(trans_choice($user->status->name, 1))}}</option>
                @endif
                @foreach ($statuses as $key => $status)
                <option value="{{$key}}">{{ucwords(trans_choice($status, 1))}}</option>
                @endforeach
            </select>
            @error('status')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        <div class="form-group">
            <label for="name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid @error('name') is-invalid @enderror" id="name" name="name" placeholder="@lang('First Name')" value="{{ $edit && $user->name ? $user->name : old('name') }}">
            @error('name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid @error('last_name') is-invalid @enderror" id="last_name" name="last_name" placeholder="@lang('Last Name')" value="{{ $edit && $user->last_name ? $user->last_name :  old('last_name')  }}">
            @error('last_name')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror

        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="socialite_id">@lang('socialite_id')</label>
            <div class="form-group">
                <input type="text"name="socialite_id" id='socialite_id'  value="{{ $edit && $user->socialite_id ? $user->socialite_id : old('socialite_id') }}" class="form-control input-solid  @error('socialite_id') is-invalid @enderror" />
                @error('socialite_id')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid @error('phone') is-invalid @enderror" id="phone_number" name="phone" placeholder="@lang('Phone')" value="{{$edit && $user->phone ? $user->phone : old('phone')   }}">
            @error('phone')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <input type="text" class="form-control input-solid @error('address') is-invalid @enderror" id="address"
            name="address" placeholder="@lang('Address')" value="{{  $edit && $user->address ? $user->address :  old('address')    }}">
            @error('address')<span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>@enderror
        </div>
        {{-- <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('country_id', $countries, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div> --}}
    </div>
    @if ($edit)
    <div class="mt-2 col-md-12">
        <button type="submit" class="btn btn-primary" id="update-details-btn">
            <i class="fa fa-refresh"></i>
            @lang('Update Details')
        </button>
    </div>
    @endif
</div>
