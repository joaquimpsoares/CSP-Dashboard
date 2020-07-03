@if (!empty($priceList))
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-lg-12">
                <form  method="POST" action="{{ route('priceList.update', $priceList->id) }}" class="col s12">
                    @method('POST')
                    @csrf        
                    <h1>{{ ucwords(trans_choice('messages.edit_pricelist', 1)) }}</h1>
                    @if (Auth::user()->userLevel->name == 'Reseller')
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name"  class="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                            <input type="text" disabled id="name" name="name" class="form-control" value="{{$priceList->name}}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="description">{{ ucwords(trans_choice('messages.description', 1)) }}</label>
                            <input type="text" disabled id="description" name="description   " class="form-control" value="{{$priceList->description}}">
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="name" class="">{{ ucwords(trans_choice('messages.name', 1)) }}</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$priceList->name}}">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="description">{{ ucwords(trans_choice('messages.description', 1)) }}</label>
                            <input type="text" id="description" name="description" class="form-control" value="{{$priceList->description}}">
                        </div>
                    </div>
                    @endif
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-4">
        <div class="text-center text-md-left">
            @if (Auth::user()->userLevel->name == 'Reseller')
            @else
            <a data-toggle="modal" data-target="#centralModalInfo" class="genric-btn primary">{{ ucwords(trans_choice('messages.update', 1)) }}</a>
            @endif
            <div class="modal fade" id="centralModalInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"aria-hidden="true" data-backdrop="false">
                <div class="modal-dialog modal-notify modal-info" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <p class="heading lead">{{ ucwords(trans_choice('messages.are_you_sure', 1)) }}</p>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true" class="white-text">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center">
                                <i class="fas fa-check fa-4x mb-3 animated rotateIn"></i>
                                {{-- <p>You are about to update customer {{$customer->company_name}}</p> --}}
                                <p>Are you sure?</p>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="submit" class="btn submit_btn">yes </button>
                            <a type="button" class="genric-btn primary" data-dismiss="modal">No, thanks</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endif