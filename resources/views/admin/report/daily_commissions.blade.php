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
                        <li class="breadcrumb-item active">Daily Commissions</li>
                    </ol>
                    <h4 class="page-title">Daily Commissions</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="input-group col-xl-5 m-b-30">
                                <input type="text" class="form-control" id="jo_From" value="{{ $day }}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar"></i>
                                    </span>
                                </div>
                            </div>
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-sales">
                                <thead>
                                    <tr>
                                        <th>Job Order</th>
                                        <th>Therapist</th>
                                        <th>Service/Package</th>
                                        <th>Sales</th>
                                        <th>Commission</th>
                                        <th>Date</th>
                                        <th>Total Commission</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($job_orders as $j)
                                    <tr>
                                        <td>{{ $j->job_order }}</td>
                                        <td>{{ $j->fullname }}</td>
                                        <td>{{ $j->service_name }}</td>
                                        <td>{{ $j->price }}</td>
                                        <td>{{ $j->labor }}</td>
                                        <td>{{ $j->created_at }}</td>
                                        <td id="totalLabor"></td>
                                    </tr>
                                    @endforeach 
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right">Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
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

        var groupColumn = 1;
        var oTable = $('.ajax-table-sales').DataTable({
            paging: false,
            keys: true,
            columnDefs: [{ targets:[5], visible: false, searchable: true }],
            rowsGroup: [1],
            "footerCallback": function (row,data,start,end,display) {
                var api = this.api(), data;

                var intVal = function(i) {
                    return typeof i === 'string'?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                    i:0;
                };

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

                $(api.column(3).footer()).html(pagetotal3+'.00');
                $(api.column(4).footer()).html(pagetotal4+'.00');
                $('#totalLabor').html(pagetotal4);
            }
        }).columns(5).search($searchVal).draw();

        $("#jo_From").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            clearBtn: true,
        });

        $('#jo_From').on('change', function() {
            $searchVal = $(this).val().replace(/\\/g, '');
            $('.ajax-table-sales').DataTable().columns(5).search($searchVal).draw();
        });
    });
</script>
@endpush