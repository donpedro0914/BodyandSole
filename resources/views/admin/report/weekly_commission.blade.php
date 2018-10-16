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
                        <li class="breadcrumb-item active">Weekly Commission Report</li>
                    </ol>
                    <h4 class="page-title">Weekly Commission Report</h4>
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
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-weekly-commission">
                                <thead>
                                    <tr>
                                        <th class='text-center'>Therapist</th>
                                        <th class='text-center'>Day 1</th>
                                        <th class='text-center'>Day 2</th>
                                        <th class='text-center'>Day 3</th>
                                        <th class='text-center'>Day 4</th>
                                        <th class='text-center'>Day 5</th>
                                        <th class='text-center'>Day 6</th>
                                        <th class='text-center'>Day 7</th>
                                        <th class='text-center'># of Days</th>
                                        <th class='text-center'>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($commission as $c)
                                    <tr>
                                        <td>{{ $c->fullname }}</td>
                                        <td>{{ $c->labor_s }}</td>
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

        $('.input-daterange-datepicker').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD'
            },
            buttonClasses: ['btn', 'btn-sm'],
            applyClass: 'btn-success',
            cancelClass: 'btn-light',
        }, function(start, end, label) {

            var dateStart = start.format('YYYY-MM-DD');
            var dateEnd = end.format('YYYY-MM-DD');

            $('#date_filter').on('click', function() {
                alert(dateStart);
            });
        });


        var table = $('.ajax-table-weekly-commission').DataTable();

    });
</script>
@endpush