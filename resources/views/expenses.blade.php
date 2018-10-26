@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
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
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-expenses">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact #</th>
                                        <th>Job Order</th>
                                        <th>Therapist</th>
                                        <th>Last Visit</th>
                                    </tr>
                                </thead>
                                <tbody>
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
        $('.ajax-table-expenses').DataTable();
    });
</script>
@endpush