@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addf_client" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"><i class="mdi mdi-account-plus"></i> Add Client</button>
                            @include('modal.f_client')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-client">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Contact #</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client as $cl)
                                    <tr>
                                        <td>{{ $cl->fullname }}</td>
                                        <td>{{ $cl->phone }}</td>
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
        $('.ajax-table-client').DataTable({
            keys: true
        });
    });
</script>
@endpush