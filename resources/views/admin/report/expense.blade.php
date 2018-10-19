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
                        <li class="breadcrumb-item active">Payroll Report</li>
                    </ol>
                    <h4 class="page-title">Payroll Report</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="form-group">
                                <label>Date Range Filter</label>
                                <div class="input-group">
                                    <input class="form-control input-daterange-datepicker" id="daterange" type="text" name="daterange" value="{{ $startDate }} - {{ $endDate }}"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="button">Filter</button>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-expense">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>SSS</th>
                                        <th>PhilHlt</th>
                                        <th>HDMF</th>
                                        <th>Lodging</th>
                                        <th>Others</th>
                                        <th>Total Deduct</th>
                                        <th>Netpay</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expense as $e)
                                    <tr>
                                        <td>{{ $e->fullname }}</td>
                                        <td>{{ $e->sss }}.00</td>
                                        <td>{{ $e->phealth }}.00</td>
                                        <td>{{ $e->hdf }}.00</td>
                                        <td>{{ $e->lodging }}.00</td>
                                        <td>{{ $e->others }}.00</td>
                                        <td>{{ $e->sss + $e->phealth + $e->hdf + $e->lodging + $e->others }}.00</td>
                                        <td>{{ $e->total + $e->allowance - $e->sss - $e->phealth - $e->hdf-+ $e->lodging - $e->others }}.00</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                        <th class="text-center"></th>
                                    </tr>
                                </tfoot>
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
            
        $('.ajax-table-expense').dataTable({
            paging: false,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print',
                    header: true,
                    footer: true,
                    message: '<h3>Petty Expense Report</h3><strong>For the period: {{ $startDate }} - {{ $endDate }}</strong>'
                }
            ],
            "footerCallback": function (row,data,start,end,display) {
                var api = this.api(), data;

                var intVal = function(i) {
                    return typeof i === 'string'?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i:0;
                };

                pagetotal1 = api
                .column(1, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal2 = api
                .column(2, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal3 = api
                .column(3, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal4 = api
                .column(4, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal5 = api
                .column(5, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal6 = api
                .column(6, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                pagetotal7 = api
                .column(7, {page: 'current'})
                .data()
                .reduce(function(a,b) {
                    return intVal(a) + intVal(b);
                },0);

                $(api.column(1).footer()).html(pagetotal1+'.00');
                $(api.column(2).footer()).html(pagetotal2+'.00');
                $(api.column(3).footer()).html(pagetotal3+'.00');
                $(api.column(4).footer()).html(pagetotal4+'.00');
                $(api.column(5).footer()).html(pagetotal5+'.00');
                $(api.column(6).footer()).html(pagetotal6+'.00');
                $(api.column(7).footer()).html(pagetotal7+'.00');
            }
        });
    });
</script>
@endpush