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
                        <li class="breadcrumb-item active">Rooms / Lounge</li>
                    </ol>
                    <h4 class="page-title">Rooms / Lounges</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addroom" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"> Add Room / Lounge</button>
                            @include('modal.room')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-rooms">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rooms as $r)
                                    <tr>
                                        <td>{{ $r->name }}</td>
                                        <td>{{ $r->type }}</td>
                                        <td class="text-center">
                                            @if($r->status == 'Available')
                                            <span class="badge badge-success">Available</span>
                                            @else
                                            <span class="badge badge-danger">Unavailable</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a data-module="roomslounge" id="{{ $r->id }}" data-name="{{ $r->name }}" class="btn btn-xs btn-default btn-delete"><i class="mdi mdi-delete"></i></a>
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
        $('.ajax-table-rooms').DataTable({
            keys: true
        });
    });
</script>
@endpush