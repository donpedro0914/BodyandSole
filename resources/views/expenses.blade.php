@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="{{ route('f_expenses_filter') }}" method="get">
                                <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}"/>
                                <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}"/>
                                <label>Date Range Filter</label>
                                <div class="input-group">
                                    <input class="form-control input-daterange-datepicker" id="daterange" type="text"/>
                                    <div class="input-group-append">
                                        <button class="btn btn-primary waves-effect waves-light" id="date_filter" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addf_expenses" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"> Add Expense</button>
                            @include('modal.f_expenses')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-expenses">
                                <thead>
                                    <tr>
                                        <th>Ref No</th>
                                        <th>Payee Name</th>
                                        <th>Category</th>
                                        <th>Value</th>
                                        <th>Added On</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $e)
                                    <tr>
                                        <td>{{ $e->ref_no }}</td>
                                        <td>{{ $e->therapist }}</td>
                                        <td>{{ $e->category }}</td>
                                        <td>{{ $e->value }}</td>
                                        <td>{{ $e->created_at }}</td>
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
        $('.ajax-table-expenses').DataTable({
            keys: true,
            order: [[0, 'desc']]
        });
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
</script>
@endpush