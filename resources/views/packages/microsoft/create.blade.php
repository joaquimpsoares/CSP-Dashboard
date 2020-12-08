@extends('layouts.master')
@section('css')

@endsection
@section('content')



<div class="card">
    <div class="">
        <i class="fab fa-microsoft fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
        <div class="card-body">
            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.add_instance', 1)) }}</a></h4>
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="row">
                        <form  method="POST" action="{{ route('instances.store') }}" class="col s12">
                            @csrf
                            <div class="row">
                                <div class="input-field col s4">
                                    <div class="md-form">
                                        <label for="name">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="input-field col s4">
                                    <div class="md-form">
                                        <label for="provider">{{ ucwords(trans_choice('messages.belongs_to', 1)) }}</label>
                                        <input type="hidden" name="provider_id" value="{{$provider->id}}">
                                        <input disabled type="text" id="p" name="provider" class="form-control" value="{{$provider->company_name}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s4">
                                    <div class="md-form">
                                        <label for="tenant_id">{{ ucwords(trans_choice('messages.tenant_id', 1)) }}</label>
                                        <input type="text" id="tenant_id" name="tenant_id" class="form-control" value="{{old('tenant_id')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s4">
                                    <div class="form-group ">
                                        <div class="form-label">Radios</div>
                                        <div class="custom-controls-stacked">
                                            <label class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="external_type" value="direct_reseller" checked>
                                                <span class="custom-control-label">{{ ucwords(trans_choice('messages.direct_reseller', 1)) }}</span>
                                            </label>
                                            <label class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" name="external_type" value="indirect_reseller">
                                                <span class="custom-control-label">{{ ucwords(trans_choice('messages.indirect_reseller', 1)) }}</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="input-field col s4">
                                    <label for="basic-url">{{ ucwords(trans_choice('messages.invitation_uri', 1)) }}</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                        </div>
                                        <input type="text" name="external_url" class="form-control" id="basic-url" aria-describedby="basic-addon3" value=" {{old('external_url')}} ">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-info">{{ ucwords(trans_choice('messages.create', 1)) }}</button>
                        <a href="{{url()->previous()}}" type="submit" class="btn btn-secondary">{{ ucwords(trans_choice('messages.cancel', 1)) }}</a>
                        <div class="float-right">
                            <a class="btn btn-outline-info" target="_blank" href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=66127fdf-8259-429c-9899-6ec066ff8915&response_type=code&redirect_uri=https://partnerconsent.tagydes.com/&prompt=admin_consent" >{{ ucwords(__('messages.refresh_token')) }}</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')

@endsection

