@extends('layouts.app')


@section('content')


<div class="box col-xm-12">
    <ul class="nav nav-pills md-tabs" id="myTabMD" role="tablist">
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light active" id="home-tab-md" data-toggle="tab" href="#home-md" role="tab" aria-controls="home-md"
            aria-selected="true">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.subscription', 2)) }}</a>
        </li>
        <li class="nav-item">
            <a class="nav-link btn rgba-blue-light" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md"
            aria-selected="false">{{ ucwords(trans_choice('messages.account', 1)) }}</a>
        </li>
    </ul>
    <div class="tab-content card pt-5" id="myTabContentMD">
        <div class="tab-pane fade show active" id="home-md" role="tabpanel" aria-labelledby="home-tab-md">
            <div class="section">
                <div class="columns">
                    <main class="column">
                        <div class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <div class="title">Dashboard</div>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    <button type="button" class="button is-small">
                                        March 8, 2017 - April 6, 2017
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="columns is-multiline">
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Top Seller Total</div>
                                    <div class="title">56,950</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Sales $</div>
                                                <div class="title is-5">250,000</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Overall $</div>
                                                <div class="title is-5">750,000</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Sales %</div>
                                                <div class="title is-5">25%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Revenue / Expenses</div>
                                    <div class="title">55% / 45%</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Rev Prod $</div>
                                                <div class="title is-5">30%</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Rev Serv $</div>
                                                <div class="title is-5">25%</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Exp %</div>
                                                <div class="title is-5">45%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Feedback Activity</div>
                                    <div class="title">78% &uarr;</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Positive</div>
                                                <div class="title is-5">1560</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Negative</div>
                                                <div class="title is-5">368</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Pos/Neg %</div>
                                                <div class="title is-5">77% / 23%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column">
                                <div class="box">
                                    <div class="heading">Orders / Returns</div>
                                    <div class="title">75% / 25%</div>
                                    <div class="level">
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Orders $</div>
                                                <div class="title is-5">425,000</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Returns $</div>
                                                <div class="title is-5">106,250</div>
                                            </div>
                                        </div>
                                        <div class="level-item">
                                            <div class="">
                                                <div class="heading">Success %</div>
                                                <div class="title is-5">+ 28,5%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                                            <input value="{{$customer->company_name}}" type="text" id="name" name="company_name" class="form-control">
                                            <label for="company_name" class="">{{ ucwords(trans_choice('messages.company_name', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$customer->nif}}" type="text" id="nif" name="email" class="form-control">
                                            <label for="nif" class="">{{ ucwords(trans_choice('messages.nif', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <h2>{{ ucwords(trans_choice('messages.address_information', 1)) }}</h2>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$customer->address_1}}" type="text" id="address1" name="address1" class="form-control">
                                            <label for="address1" class="">{{ ucwords(trans_choice('messages.address_1', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$customer->address_2}}" type="text" id="address2" name="address2" class="form-control">
                                            <label for="address2" class="">{{ ucwords(trans_choice('messages.address_2', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form mb-0">
                                            <input value="{{$customer->city}}" type="text" id="city" name="city" class="form-control">
                                            <label for="city" class="">{{ ucwords(trans_choice('messages.city', 1)) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="md-form">
                                            <input value="{{$customer->postal_code}}" type="text" id="postalcode" name="postalcode" class="form-control">
                                            <label for="postalcode">{{ ucwords(trans_choice('messages.postal_code', 1)) }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-form">
                                            <select class="browser-default custom-select">
                                                <option selected>{{$customer->country->name}}</option>
                                                @foreach ($countries as $item)
                                                <option>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="md-form">
                                            <hr>
                                            <p>{{ ucwords(trans_choice('messages.user_info', 1)) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="">
                                        <i class="fas fa-user fa-lg primary-color z-depth-2 p-4 ml-2 mt-n3 rounded text-white"></i>
                                        <div class="card-body">
                                            <h4 class="card-title"><a>{{ ucwords(trans_choice('messages.user_table', 1)) }}</a></h4>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="md-form">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered" id="customers">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{{ ucwords(trans_choice('messages.username', 1)) }}</th>
                                                                        <th>{{ ucwords(trans_choice('messages.first_name', 1)) }}</th>
                                                                        <th>{{ ucwords(trans_choice('messages.last_name', 1)) }}</th>
                                                                        <th>{{ ucwords(trans_choice('messages.status', 1)) }}</th>
                                                                        {{-- <th>{{ ucwords(trans_choice('messages.action', 1)) }}</th> --}}
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($customer->users as $user)
                                                                    <tr>
                                                                        <td>
                                                                            <a href="/user/{{$user->id }}">    {{ $user['username'] }}</a>
                                                                        </td>
                                                                        <td>{{ $user['first_name'] }}</td>
                                                                        <td>{{ $user['last_name'] }}</td>
                                                                        <td>{{ ucwords(trans_choice($user->status->name, 1)) }}</td>
                                                                        {{-- <td style="width: 150px">
                                                                            @include('partials.actions', ['model' => $customer, 'modelo' => 'customer'])
                                                                        </td> --}}
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                <div class="row">
                    @foreach ($subscriptions as $item)
                    <div class="col-md-3">
                        <div class="card">
                            <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
                            <div class="card-body">
                                <h2 class="card-title">
                                    <a href="#">{{ ucwords(trans_choice('messages.name', 1)) }}: {{$item->name}}</a>  </h2> 
                                    <p class="card-text"> <a href="#"> {{$item->amount}}  {{ ucwords(trans_choice('messages.licenses', 1)) }}</a> </p>
                                    status:
                                    <p class="card-text">
                                        {{ ucwords(trans_choice( $item->status->name, 1)) }} 
                                    </p>
                                    
                                    {{-- <h2 class="card-title"> <strong>{{ ucwords(trans_choice('messages.name', 1)) }}:</strong> {{$instance['name']}}</h2>
                                    <p class="card-text"></p>
                                    <a href=" {{ route('instances.edit', $instance->id) }}" class="button is-info is-outlined"> {{ ucwords(trans_choice('messages.edit', 1)) }}</a> --}}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>



@endsection


