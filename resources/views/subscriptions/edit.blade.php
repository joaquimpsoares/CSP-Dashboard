@extends('layouts.master')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}"  rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
<div class="row">
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ ucwords(trans_choice('messages.subscription', 1)) }}</h4>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tbody>
                            <form class="form-horizontal form-bordered" method="POST" action="{{ route('subscription.update', $subscriptions->id) }}">
                                @method('PATCH')
                                @csrf
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.subscription_name', 1)) }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ $subscriptions->name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.tenant_name', 1)) }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ $subscriptions->tenant_name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.owner', 1)) }} </span>
                                    </td>
                                    <td class="py-2 px-0">{{ $subscriptions->customer->resellers->first()->company_name }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.licenses', 1)) }} </span>
                                    </td>
                                    <td class="py-2 px-0">
                                        <div class="control">
                                            @if ($subscriptions->status == "1")
                                            <input readonly="readonly" class="input is-warning" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                            @else
                                            <input  class="input" name="amount" type="number" placeholder="Text input" value="{{ $subscriptions->amount }}">
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.billing_cycle', 1)) }} </span>
                                    </td>
                                    <td class="py-2 px-0">
                                        @if ($subscriptions->status == "1")
                                        <div  readonly="readonly">
                                            @else
                                            @endif
                                            <div  class="select is-info">
                                                <select name="billing_period" >
                                                    <option value="monthly" {{ $subscriptions->billing_period == "monthly" ? "selected":"" }}> Monthly</option>
                                                    <option value="annual" {{ $subscriptions->billing_period == "annual" ? "selected":"" }}> Annual</option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="py-2 px-0">
                                        <span class="font-weight-semibold w-50">{{ ucwords(trans_choice('messages.status', 1)) }} </span>
                                    </td>
                                    <td class="py-2 px-0">
                                        <div name="status" class="select is-info">
                                            <select name="status">
                                                <option  value="1" {{ $subscriptions->status_id == "1" ? "selected":"" }}> Active</option>
                                                <option  value="2" {{ $subscriptions->status_id == "2" ? "selected":"" }}> Suspended</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <td><button type="submit" class="btn btn-primary" type="submit">Change</button></td>
                                <td><button type="" class="btn btn-danger" type="submit">Cancel</button></td>
                            </form>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
