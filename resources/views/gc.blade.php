@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#f_addgc" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"><i class="mdi mdi-account-plus"></i> Add Gift Certificate</button>
                            @include('modal.f_gc')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-gc">
                                <thead>
                                    <tr>
                                        <th>Gift Cert No</th>
                                        <th>Purchased by</th>
                                        <th>Value</th>
                                        <th>Service</th>
                                        <th># of use</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($gc as $g)
                                    <tr>
                                        <td>{{ $g->gc_no }}</td>
                                        <td>{{ $g->purchased_by }}</td>
                                        <td>{{ $g->value }}</td>
                                        <td>{{ $g->service_name }}</td>
                                        <td>{!! $g->gcounts !!} / {{ $g->use }}</td>
                                        <td class="text-center">
                                            @if($g->status == 'Active')
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Not Active</span>
                                            @endif
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
        $('.ajax-table-gc').DataTable({
            keys: true
        });
    });
</script>
@endpush