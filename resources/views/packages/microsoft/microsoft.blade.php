@extends('layouts.app')

@section('content')


<div class="box">
    <section class="section">
        <div class="card">
            <div class="">
                <i class="fab fa-microsoft fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                <div class="card-body">
                    <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.edit_instance', 1)) }}</a></h4>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="row">
                                <form  method="POST" action="{{ route('instances.update', $instances->id) }}" class="col s12">
                                    @method('patch')
                                    @csrf
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="name" name="name" class="form-control" value="{{ $instances->name }}">
                                                <label for="name">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                                            </div>
                                        </div>
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input disabled type="text" id="p" name="provider" class="form-control" value="{{ $instances->provider->company_name }}">
                                                <label for="provider">{{ ucwords(trans_choice('messages.belongs_to', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="md-form">
                                                <input type="text" id="tenant_id" name="tenant_id" class="form-control" value="{{$instances->tenant_id}}">
                                                <label for="tenant_id">{{ ucwords(trans_choice('messages.tenant_id', 1)) }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="defaultGroupExample1" name="direct_reseller">
                                                <label class="custom-control-label" for="defaultGroupExample1">{{ ucwords(trans_choice('messages.direct_reseller', 1)) }}</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input type="radio" class="custom-control-input" id="defaultGroupExample2" name="indirect_reseller">
                                                <label class="custom-control-label" for="defaultGroupExample2">{{ ucwords(trans_choice('messages.indirect_reseller', 1)) }}</label>
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
                                                <input type="text" name="external_url" class="form-control" id="basic-url" aria-describedby="basic-addon3" value=" {{$instances->external_url}} ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s4">
                                            <label for="basic-url">{{ ucwords(trans_choice('messages.token_expiration', 1)) }}</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                </div>
                                                @if($instances->external_token_updated_at == null)
                                                <a href=" {{('/instances/getMasterToken/'. $instances->provider_id )}} " class="text-danger">Please update token</a>
                                                @else
                                                <input disabled type="text" name="external_url" class="form-control" id="basic-url" aria-describedby="basic-addon3" value="{!! $instances->external_token_updated_at->addDays(90) !!} ">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="button is-rounded is-primary is-outlined">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                                <a href="{{url()->previous()}}" type="submit" class="button is-rounded is-danger is-outlined">{{ ucwords(trans_choice('messages.cancel', 1)) }}</a>
                                <div class="float-right">
                                    <a  target="_blank" href="https://login.microsoftonline.com/common/oauth2/authorize?client_id=66127fdf-8259-429c-9899-6ec066ff8915&response_type=code&redirect_uri=https://partnerconsent.tagydes.com/&prompt=admin_consent" class="button is-rounded is-warning is-outlined">{{ ucwords(__('messages.refresh_token')) }}</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </div>
</section>
</div>


@endsection


@section('scripts')

@endsection

