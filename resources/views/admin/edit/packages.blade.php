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
                        <li class="breadcrumb-item active"><a href="/packages">Packages</a></li>
                        <li class="breadcrumb-item">{{ $packages->package_name }}</li>
                    </ol>
                    <h4 class="page-title">{{ $packages->package_name }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form id="" action="{{ URL::to('packages/update', $packages->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="service" id="services" value=""/>
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Package Name</label>
                                        <input type="text" class="form-control" name="package_name" id="package_name" value="{{ $packages->package_name }}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Services</label>
                                        {!! Form::select('', $services, '', ['multiple' => 'multiple', 'class' => 'select2 form-control select2-multiple', 'id' => 'package_services']) !!}
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Package Price</label>
                                        <input type="text" class="form-control" name="price" id="price" value="{{ $packages->price }}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Package Labor</label>
                                        <input type="text" class="form-control" name="labor" id="package_labor" value="{{ $packages->labor }}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="{{ $packages->status }}">{{ $packages->status }}</option>
                                            <option value="Active">Active</option>
                                            <option value="Not Active">Not Active</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="" class="btn btn-success">
                                                Update Service
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection
@push('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
        });
        
        var services = '{{ $packages->services }}';
        $.ajax({
            url: '/packages/getServices',
            type: 'post',
            data:{'services':services},
            success: function(data) {
                var vals = [];
                for(var i=0; i<data.length;i++){
                    vals[i] = data[i].id;
                }
                
                $('#package_services').select2('val', [vals]);                
            }
        });

        $('#package_services').on('change', function() {
            var services2 = $(this).val();

            $('#services').val(services2);

            $.ajax({
            type: 'post',
            dataType: 'json',
            url: '/package/ajaxService',
            data: {'id':services2},
            success: function(data) {
                var labor = 0;
                for(var i=0; i<data.length;i++){
                    labor += Number(data[i].labor_p);
                }
                $('#package_labor').empty();
                $('#package_labor').val(labor);
            }
        });
        })
    });
</script>
@endpush