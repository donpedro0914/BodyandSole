@extends('layouts.app')

@section('content')
    @include('global.topnav')
    @include('global.sidemenu')
    <div class="content-page">
    	<div class="content">
    		<div class="container-fluid">
    			<div class="page-title-box">
                    <ol class="breadcrumb float-right">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Body and Sole</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Reports</a></li>
                        <li class="breadcrumb-item active">Sales Report</li>
                    </ol>
                    <h4 class="page-title">Sales Report</h4>
    			</div>
                <div class="row">
                    <div class="form-group col-xl-12">
                        <form action="{{ route('ds_filter') }}" method="get">
                            <input type="hidden" name="day" id="day" value="{{ $day }}"/>
                            <label>Date Range Filter</label>
                            <div class="input-group">
                                <input class="form-control" id="jo_From" type="text"value="{{ $day }}"/>
                                <div class="input-group-append">
                                    <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="submit">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-box">
                            <h4 class="header-title">Daily Sales</h4>
                            <p class="text-muted">{{ $day }}</p>
                            <div class="mb-3 mt-4">
                                <h2 class="font-weight-light">₱{{ $dailySales - $dailyExpenses}}.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-box">
                            <h4 class="header-title">Cash Sales</h4>
                            <p class="text-muted">{{ $day }}</p>
                            <div class="mb-3 mt-4">
                                <h2 class="font-weight-light">₱{{ $dailyCashSales }}.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-box">
                            <h4 class="header-title">Gcash Sales</h4>
                            <p class="text-muted">{{ $day }}</p>
                            <div class="mb-3 mt-4">
                                <h2 class="font-weight-light">₱{{ $dailyGcashSales }}.00</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card-box">
                            <h4 class="header-title">Daily Expenses</h4>
                            <p class="text-muted">{{ $day }}</p>
                            <div class="mb-3 mt-4">
                                <h2 class="font-weight-light">₱{{ $dailyExpenses }}.00</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-sales">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job_orders as $j)
                                    <tr>
                                        <td>Job Order - {{ $j->job_order }}</td>
                                        <td>{{ $j->price }}</td>
                                        <td>{{ $j->created_at }}</td>
                                    </tr>
                                    @endforeach 
                                    @foreach($gc as $g)
                                    <tr>
                                        <td>Gift Cert - {{ $g->gc_no }}</td>
                                        <td>{{ $g->value }}</td>
                                        <td>{{ $g->created_at }}</td>
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
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $searchVal = '{{ $day }}';
        jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
            return this.flatten().reduce( function ( a, b ) {
                if ( typeof a === 'string' ) {
                    a = a.replace(/[^\d.-]/g, '') * 1;
                }
                if ( typeof b === 'string' ) {
                    b = b.replace(/[^\d.-]/g, '') * 1;
                }

                return a + b;
            }, 0 );
        } );

        var oTable = $('.ajax-table-sales').DataTable({
            paging: false,
            keys: true,
        }).columns(2).search($searchVal).draw();

        $("#jo_From").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            clearBtn: true,
        });

        $('#jo_From').on('change', function() {
            $('#day').val($(this).val());
        })
    });
</script>
@endpush