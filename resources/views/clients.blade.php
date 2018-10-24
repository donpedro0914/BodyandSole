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
                                        <th>Job Order</th>
                                        <th>Therapist</th>
                                        <th>Last Visit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client as $cl)
                                    <tr>
                                        <td>{{ $cl->fullname }}</td>
                                        <td>{{ $cl->phone }}</td>
                                        <td>{{ $cl->job_order }}</td>
                                        <td>{{ $cl->therafullname }}</td>
                                        <td>{{ $cl->lastvisit }}</td>
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
            responsive: {
                details: {
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            return col.hidden ?
                                '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                                    '<td>'+col.title+':'+'</td> '+
                                    '<td>'+col.data+'</td>'+
                                '</tr>' :
                                '';
                        }).join('');
                        return data ?
                        $('<table/>').append( data ) :
                        false;
                    }
                }
            }
        });
    });
</script>
@endpush