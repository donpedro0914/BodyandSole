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
                        <li class="breadcrumb-item active">Periodic Sales Report</li>
                    </ol>
                    <h4 class="page-title">Periodic Sales Report</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <div class="form-group">
                                <form action="{{ route('ps_filter') }}" method="get">
                                    <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}"/>
                                    <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}"/>
                                    <label>Date Range Filter</label>
                                    <div class="input-group">
                                        <input class="form-control input-daterange-datepicker" id="daterange" type="text"value="{{ $startDate }} - {{ $endDate }}"/>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="submit">Filter</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-sales">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Gross</th>
                                        <th>Expenses</th>
                                        <th>Net</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($periodic_sales as $j)
                                    <tr>
                                        <td>{{ $j->date }}</td>
                                        <td>{{ $j->sales }}</td>
                                        <td>{{ $j->expenses }}</td>
                                        <td>{{ $j->sales - $j->expenses}}</td>
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
            keys: true
        });

        $('.input-daterange-datepicker').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-light',
        });

        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
            var start = picker.startDate.format('YYYY-MM-DD');
            var end = picker.endDate.format('YYYY-MM-DD');

            $('#startDate').val(start);
            $('#endDate').val(end);
        });
    });
</script>
@endpush