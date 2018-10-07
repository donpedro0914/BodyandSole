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
                        <li class="breadcrumb-item active">Packages</li>
                    </ol>
                    <h4 class="page-title">Packages</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <a href="/packages/add"><button type="button" class="btn btn-primary waves-effect waves-light" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"> Add Package</button></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-packages">
                                <thead>
                                    <tr>
                                        <th>Package Name</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($package as $p)
                                    <tr>
                                        <td>{{ $p->package_name }}</td>
                                        <td>{{ $p->price }}</td>
                                        <td class="text-center">
                                            @if($p->status == 'Active')
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="#" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-eye"></i></a>
                                            <a href="#" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-pencil"></i></a>
                                            <a href="#" class="btn btn-xs btn-default btn-edit"><i class="mdi mdi-delete"></i></a>
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
        $('.ajax-table-packages').DataTable({
            keys: true
        });
    });
</script>
@endpush