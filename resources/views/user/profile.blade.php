@extends('layouts.app')


@section('content')


<section class="section team-section">
    <form  method="POST" action="{{ route('user.update', $user->id) }}" class="col s12" enctype="multipart/form-data">
        @method('patch')
        @csrf
        <div class="container">
            <div class="row text-center">
                <div class="col-md-8 mb-4">
                    <div class="card card-cascade cascading-admin-card user-card">
                        <div class="admin-up d-flex justify-content-start">
                            <i class="fas fa-user fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                            <div class="data float-right">
                                <h5 class="font-weight-bold dark-grey-text">Edit Profile - <span class="text-muted">Complete your
                                    profile</span></h5>
                                </div>
                            </div>
                            <div class="card-body card-body-cascade">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="username" name="username" class="form-control form-control-sm" value="{{$user->username}}">
                                            <label for="username" class="">{{ ucwords(trans_choice('messages.username', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="email" name="email" class="form-control form-control-sm" value="{{$user->email}}">
                                            <label for="email" class="">{{ ucwords(trans_choice('messages.email', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="company_name" name="company_name" class="form-control form-control-sm" disabled value="{{$user->company}}">
                                            <label for="company_name" class="disabled">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="first_name       " name="first_name" class="form-control form-control-sm" value="{{$user->first_name}}">
                                            <label for="first_name" class="">{{ ucwords(trans_choice('messages.first_name', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="last_name" name="last_name" class="form-control form-control-sm" value="{{$user->last_name}}">
                                            <label for="last_name" class="">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="address" name="address" class="form-control form-control-sm" value="{{$user->address}}">
                                            <label for="address" class="">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="city" name="city" class="form-control form-control-sm" value="{{$user->city}}">
                                            <label for="city" class="">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="md-form">
                                            <select name='country_id' class="browser-default custom-select">
                                                
                                                <option value="{{$user->country_id ?? ' ' }}" selected>{{$user->country->name ?? ' ' }}</option>
                                                @foreach ($countries as $country)
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <div class="md-form form-sm mb-0">
                                            <input type="text" id="postal_code" name="postal_code" class="form-control form-control-sm" value="{{$user->postal_code}}">
                                            <label for="postal_code" class="">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <button type="submit" class="button is-rounded is-primary is-outlined">{{ ucwords(trans_choice('messages.update', 1)) }}</button>
                                </div>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-4 mb-4">
                        <div class="card profile-card">
                            <div class="avatar z-depth-1-half mb-4">
                                <img src=" {{$user->avatar}} " class="rounded-circle" alt="First sample avatar image" height="250" width="250">
                            </div>
                            <div class="card-body pt-0 mt-0">
                                <div class="custom-file">
                                    <input type="file" name="avatar" class="custom-file-input" id="customFileLang">
                                    <label class="custom-file-label" for="customFileLang">Select file</label>
                                </div>
                                <div class="row">
                                    <div class=" col-xs-12">
                                        <h6 class="font-weight-bold cyan-text mb-4"></h6>
                                    </div>
                                </div>
                                <label for="notificastions" class="font-weight-bold cyan-text mb-4">Notifications Settings</label>
                                <select name="notifications" class="custom-select" multiple>
                                    @foreach ($notifications as $key=> $item)
                                    <option value={{$item}}>{{$item}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>  
    
    
    @endsection
    
    
