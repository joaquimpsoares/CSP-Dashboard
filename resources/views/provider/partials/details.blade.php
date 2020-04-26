<div class="box col-xm-12">
    <h2 class="h1-responsive f  ont-weight-bold text-center my-4">Customer Form</h2>
    <div class="row">
        <div class="col-md-9 mb-md-0 mb-5">
            <form id="contact-form" name="contact-form" action="mail.php" method="POST">
                <h2>Legal information</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input value="{{$provider->company_name}}" type="text" id="name" name="company_name" class="form-control">
                            <label for="company_name" class="">Company Name</label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input value="{{$provider->nif}}" type="text" id="nif" name="email" class="form-control">
                            <label for="nif" class="">NIF</label>
                        </div>
                    </div>
                </div>
                <h2>Address information</h2>
                <div class="row">
                    <div class="col-md-6">
                        <div class="md-form mb-0">
                            <input value="{{$provider->address_1}}" type="text" id="address1" name="address1" class="form-control">
                            <label for="address1" class="">Address 1</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="md-form mb-0">
                            <input value="{{$provider->address_2}}" type="text" id="address2" name="address2" class="form-control">
                            <label for="address2" class="">Address 2</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="md-form mb-0">
                            <input value="{{$provider->city}}" type="text" id="city" name="city" class="form-control">
                            <label for="city" class="">City</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form">
                            <input value="{{$provider->postal_code}}" type="text" id="postalcode" name="postalcode" class="form-control">
                            <label for="postalcode">Postal Code</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="md-form">
                            <select class="browser-default custom-select">
                                <option selected>{{$provider->country->name}}</option>
                                <option value="1">{{$provider->country->name}}</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-center text-md-left">
                <a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Send</a>
            </div>
            {{-- <div class="status">
            </div> --}}
        </div>
        <div class="col-md-3 text-center">
            <img src="https://media2.giphy.com/media/s9TcMBb7FfJ7y/source.gif" alt="Twitter 11" />
            <p 
            class="text-center w-responsive mx-auto mb-5">Do you have any questions? Please do not hesitate to contact us directly. Our team will come back to you within
            a matter of hours to help you.
        </p>
        </div>
    </div>
</div>
