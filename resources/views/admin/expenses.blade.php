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
                        <li class="breadcrumb-item active">Petty Expenses</li>
                    </ol>
                    <h4 class="page-title">Petty Expenses</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addf_expenses" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"> Add Expense</button>
                            @include('modal.f_expenses')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <form action="{{ route('expenses_filter') }}" method="get">
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
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-expenses">
                                <thead>
                                    <tr>
                                        <th>Ref No</th>
                                        <th>Payee Name</th>
                                        <th>Category</th>
										<th>Particulars</th>
                                        <th>Value</th>
                                        <th>Added On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expenses as $e)
                                    <tr>
                                        <td>{{ $e->ref_no }}</td>
                                        <td>{{ $e->therapist }}</td>
                                        <td>{{ $e->category }}</td>
										<td>{{ $e->particulars }}</td>
                                        <td>{{ $e->value }}</td>
                                        <td>{{ $e->created_at }}</td>
                                        <td class="text-center">
                                            <a href="/expenses/edit/{{ $e->id }}" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-pencil"></i></a>
                                            <a data-module="expenses" id="{{ $e->id }}" data-name="{{ $e->ref_no }}" class="btn btn-xs btn-default btn-delete"><i class="mdi mdi-delete"></i></a>
                                        </td>
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