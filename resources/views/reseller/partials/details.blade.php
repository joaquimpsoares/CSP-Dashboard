    <form  method="POST" action="{{ "update/" . $reseller->id }}" class="col s12">
        @method('patch')
        @csrf
        <div class="box col-xm-12">
            <h2 class="h1-responsive f  ont-weight-bold text-center my-4">Customer Form</h2>
            <div class="row">
                <div class="col-md-9 mb-md-0 mb-5">
                    <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                        <h2>Legal information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input value="{{$reseller->company_name}}" type="text" id="name" name="company_name" class="form-control">
                                    <label for="company_name" class="">Company Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input value="{{$reseller->nif}}" type="text" id="nif" name="nif" class="form-control">
                                    <label for="nif" class="">NIF</label>
                                </div>
                            </div>
                        </div>
                        <h2>Address information</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input value="{{$reseller->address_1}}" type="text" id="address_1" name="address_1" class="form-control">
                                    <label for="address_1" class="">Address 1</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="md-form mb-0">
                                    <input value="{{$reseller->address_2}}" type="text" id="address_2" name="address_2" class="form-control">
                                    <label for="address_2" class="">Address 2</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="md-form mb-0">
                                    <input value="{{$reseller->city}}" type="text" id="city" name="city" class="form-control">
                                    <label for="city" class="">City</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form mb-0">
                                    <input value="{{$reseller->state}}" type="text" id="state" name="state" class="form-control">
                                    <label for="state" class="">state</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="md-form">
                                    <input value="{{$reseller->postal_code}}" type="text" id="postal_code" name="postal_code" class="form-control">
                                    <label for="postal_code">Postal Code</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="md-form">
                                    <select name='country_id' class="browser-default custom-select">
                                        <option value="{{$reseller->country->id}}" selected>{{$reseller->country->name}}</option>
                                        @foreach ($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center text-md-left">
                        <a data-toggle="modal" data-target="#centralModalInfo" class="button is-rounded is-primary is-outlined">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
                        <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true" data-backdrop="false">
                        <div class="modal-dialog modal-notify modal-info" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <p class="heading lead">Modal Info</p>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true" class="white-text">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                        <p>You are about to update provider {{$reseller->company_name}}</p>
                                        <p>Are you sure?</p>
                                    </div>
                                </div>
                                <div class="modal-footer justify-content-center">
                                    <button type="submit" type="button" class="btn btn-primary">yes </button>
                                    <a type="button" class="btn btn-outline-primary waves-effect" data-dismiss="modal">No, thanks</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <img src="https://media2.giphy.com/media/s9TcMBb7FfJ7y/source.gif" alt="Twitter 11" />
                <p 
                class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
                a matter of hours to help you.
            </p>
        </div>
    </div>
