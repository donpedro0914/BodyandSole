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
                        <li class="breadcrumb-item active">Gift Certificate</li>
                    </ol>
                    <h4 class="page-title">Gift Certificate</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addgc" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"><i class="mdi mdi-account-plus"></i> Add Gift Certificate</button>
                            @include('modal.gc')
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
                                        <th>Action</th>
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
                                        <td class="text-center">
                                            <a href="/gc/edit/{{ $g->id }}" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-pencil"></i></a>
                                            <a data-module="gc" id="{{ $g->id }}" data-name="{{ $g->gc_no }}" class="btn btn-xs btn-default btn-delete"><i class="mdi mdi-delete"></i></a>
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