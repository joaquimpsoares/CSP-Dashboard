@extends('layouts.app')


@section('content')


<div class="box col-xm-12">
    
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.customer', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
        </li>
    </ul>
    <div class="tab-content card pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
            <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua,
                retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica.
                Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry
                richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american
                apparel, butcher voluptate nisi qui.</p>
            </div>
            <div class="tab-pane fade" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                <div class="box col-xm-12">
                    <h2>{{ ucwords(trans_choice('messages.legal_information', 1)) }}</h2>
                    <div class="row">
                        <div class="col-md-9 mb-md-0 mb-5">
                            <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$reseller->company_name}}" type="text" id="name" name="company_name" class="form-control">
                                            <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$reseller->nif}}" type="text" id="nif" name="email" class="form-control">
                                            <label for="nif" class="">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <h2>{{ ucwords(trans_choice('messages.address_information', 1)) }}</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$reseller->address_1}}" type="text" id="address1" name="address1" class="form-control">
                                            <label for="address1" class="">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$reseller->address_2}}" type="text" id="address2" name="address2" class="form-control">
                                            <label for="address2" class="">{{ ucwords(trans_choice('messages.address_2', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$reseller->city}}" type="text" id="city" name="city" class="form-control">
                                            <label for="city" class="">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form">
                                            <input value="{{$reseller->postal_code}}" type="text" id="postalcode" name="postalcode" class="form-control">
                                            <label for="postalcode">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-form">
                                            <select class="browser-default custom-select">
                                                <option selected>{{$reseller->country->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <h2>{{ ucwords(trans_choice('messages.user_info', 1)) }}</h2>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="md-form">
                                            <input value="{{ $reseller}}" type="text" id="postalcode" name="postalcode" class="form-control">
                                            <label for="postalcode">{{ ucwords(trans_choice('messages.user_name', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="md-form">
                                            <input value="{{ $reseller}}" type="text" id="postalcode" name="postalcode" class="form-control">
                                            <label for="postalcode">{{ ucwords(trans_choice('messages.first_name', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="md-form">
                                            <input value="{{ $reseller}}" type="text" id="postalcode" name="postalcode" class="form-control">
                                            <label for="postalcode">{{ ucwords(trans_choice('messages.last_name', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="md-form">
                                            <input value="{{ $reseller}}" type="text" id="postalcode" name="postalcode" class="form-control">
                                            <label for="postalcode">{{ ucwords(trans_choice('messages.phone_number', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="text-center text-md-left">
                                <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
                            </div>
                            <div class="status"></div>
                        </div>
                        <div class="col-md-3 text-center">
                            <img src="https://media2.giphy.com/media/s9TcMBb7FfJ7y/source.gif" alt="Twitter 11" />
                            <p class="text-center w-responsive mx-auto mb-5">{{ ucwords(trans_choice('messages.do_you_have_any_question_text', 1)) }}</p>
                            </div>        
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                    <p>Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo
                        retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer,
                        iphone skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony.
                        Leggings gentrify squid 8-bit cred pitchfork. Williamsburg banh mi whatever gluten-free, carles
                        pitchfork biodiesel fixie etsy retro mlkshk vice blog. Scenester cred you probably haven't heard of
                        them, vinyl craft beer blog stumptown. Pitchfork sustainable tofu synth chambray yr.</p>
                    </div>
                </div>
            </div>
            
            
            @endsection
            
            
