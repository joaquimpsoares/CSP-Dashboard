
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

<section>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <h1 class="mb-4 mt-1 h5 text-center font-weight-bold"></h1>
                <div class="card-header">
                    <div class="card-title">
                        <h2>Summary for customer </h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered text-nowrap key-buttons">
                            <thead class="thead-light">
                                <tr>
                                    <td>Company Name</td>
                                    <td>Billing Start date</td>
                                    <td>Billing End date</td>
                                    <td>Pretax Total</td>
                                    <td>Tax Total</td>
                                    <td>After Total</td>
                                    <td>After Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($serviceCosts as $item)
                                @php
                                if(!empty($item)){
                                    $customer = App\MicrosoftTenantInfo::where('tenant_id',$item->customerId)->get();
                                }
                                @endphp
                                <tr>
                                    {{-- @if (!empty($customer->first()->customer)) --}}
                                    <td>{{$customer->first()->customer->company_name}}</td>
                                    <td>{{date('d-m-Y', strtotime($item->billingStartDate))}}</td>
                                    <td>{{date('d-m-Y', strtotime($item->billingEndDate))}}</td>
                                    <td>{{number_format($item->pretaxTotal, 2)}}{{$item->currencySymbol}}</td>
                                    <td>{{number_format($item->tax, 2)}}{{$item->currencySymbol}}</td>
                                    <td>{{number_format($item->afterTaxTotal, 2)}}{{$item->currencySymbol}}</td>
                                    <td>
                                        <a class="btn btn-primary" href="\customer\serviceCostsLineitems\{{$item->customerId}}">See Details</a>
                                    </td>
                                    {{-- @else --}}
                                    {{-- <td></td> --}}
                                    {{-- @endif --}}
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                @if(empty($serviceCosts))
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><strong>Total: </strong>{{$serviceCosts->sum('pretaxTotal')}}{{$item->currencySymbol}}</th>
                                    <th><strong>Total: </strong>{{$serviceCosts->sum('tax')}}{{$item->currencySymbol}}</th>
                                    <th><strong>Total: </strong>{{$serviceCosts->sum('afterTaxTotal')}}{{$item->currencySymbol}}</th>
                                    <th></th>
                                </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('js')
<!-- Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>
<!-- Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection

