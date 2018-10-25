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
                        <li class="breadcrumb-item active">Services</li>
                    </ol>
                    <h4 class="page-title">Services</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addservice" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"> Add Service</button>
                            @include('modal.service')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-service">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Labor(S)</th>
                                        <th>Labor(P)</th>
                                        <th>Charge</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($services as $s)
                                    <tr>
                                        <td>{{ $s->service_name }}</td>
                                        <td class="text-center">₱{{ $s->labor_s }}.00</td>
                                        <td class="text-center">₱{{ $s->labor_p }}.00</td>
                                        <td class="text-center">₱{{ $s->charge }}.00</td>
                                        <td class="text-center">
                                            @if($s->status == 'Active')
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Not Active</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="/services/edit/{{ $s->id }}" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-pencil"></i></a>
                                            <a data-module="services" id="{{ $s->id }}" data-name="{{ $s->service_name }}" class="btn btn-xs btn-default btn-delete"><i class="mdi mdi-delete"></i></a>
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
        $('.ajax-table-service').DataTable({
            keys: true
        });
    });
</script>
@endpush