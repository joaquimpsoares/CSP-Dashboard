<div class="box col-xm-12">
    <div class="row">
        @foreach ($subscriptions as $item)
        <div class="col-md-3">
            <div class="card">
                <div class="view overlay">
                    {{-- <img class="card-img-top" src="https://mdbootstrap.com/img/Mockups/Lightbox/Thumbnail/img%20(67).jpg" --}}
                    {{-- alt="Card image cap"> --}}
                    <img class="card-img-top" src="https://img.pngio.com/microsoft-corporate-logo-guidelines-trademarks-microsoft-logo-png-2008_900.jpg" alt="Card image cap">
                    <a href="#!">
                      <div class="mask rgba-white-slight"></div>
                    </a>
                  </div>
                <div class="card-body">
                    <h3 class="card-title">{{ ucwords(trans_choice('messages.subscription_name', 1)) }}</h3> 
                    <p class="card-text"><a href=" {{route('subscription.show', [$item['id']])}} ">{{$item->name}}</a></p>
                    <h3><p>{{ ucwords(trans_choice('messages.tenant_name', 1)) }}</p></h3>
                    <p class="card-text"> <a href="#"> {{$item->tenant_name}}  </a></p>
                    <hr>
                    <div class="row">
                        <div class="col-sm">
                            {{ ucwords(trans_choice('messages.licenses', 1)) }}
                            <p class="card-text"> <a href="#"> {{$item->amount}}  {{ ucwords(trans_choice('messages.licenses', 1)) }}</a></p>
                            
                        </div>
                        <div class="col-sm">
                            <p class="card-text"> {{ ucwords(trans_choice('messages.billing_cycle', 1)) }} <a href="#"> {{$item->billing_period}} </a> </p>
                        </div>
                    </div>
                    <hr>
                    {{ ucwords(trans_choice('messages.subscription_status', 1)) }}
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