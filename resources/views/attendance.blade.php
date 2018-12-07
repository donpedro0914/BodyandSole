@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="" method="get">
                                <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}"/>
                                <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}"/>
                                <label>Date Range Filter</label>
                                <div class="input-group">
                                    <input class="form-control input-daterange-datepicker" id="daterange" type="text" value="{{ $startDate }} - {{ $endDate }}"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <table id="attendance" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                            <thead>
                                <tr>
                                    <th>Employee</th>
                                    <th>Mon</th>
                                    <th>Tue</th>
                                    <th>Wed</th>
                                    <th>Thurs</th>
                                    <th>Fri</th>
                                    <th>Sat</th>
                                    <th>Sun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendance as $a)
                                <tr>
                                    <td>{{ $a->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">

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
</script>
@endpush