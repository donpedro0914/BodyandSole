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
                        <li class="breadcrumb-item"><a href="/packages">Package</a></li>
                        <li class="breadcrumb-item active">Add Packages</li>
                    </ol>
                    <h4 class="page-title">Add Package</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form class="form-horizontal" id="addPackageForm" action="{{ URL::to('packages/store') }}" method="post">
                                @csrf
                                <input type="hidden" name="service" id="service" value=""/>
                                <input type="hidden" name="labor" id="package_labor" value=""/>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Package Name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="package_name"/>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Services</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <select id="package_services" class="select2 form-control select2-multiple" multiple="multiple" data-placeholder="Choose ...">
                                                <option value="">--Select Service(s)--</option>
                                                @foreach($service as $s)
                                                <option value="{{ $s->id }}" data-price="{{ $s->charge }}" data-name="{{ $s->service_name }}">{{ $s->service_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="input-group-append">
                                                <button type="button" id="package_servicec_btn" class="btn btn-primary waves-effect waves-light" disabled="">Add Service(s)</button>
                                            </div>
                                        </div>
                                    </div>
                                    <label class="col-sm-4 col-form-label"></label>
                                    <div class="col-sm-8">
                                        <table class="table m-t-50" id="package_inclusion">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Service Name</th>
                                                    <th>Labor</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center" colspan="3">
                                                        No Services Yet
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th class="text-right">Total</th>
                                                    <th id="package_labor_total">₱ 0.00</th>
                                                    <th id="package_total">₱ 0.00</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Package Price</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="price" />
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="addPackageFormBtn" class="btn btn-success">
                                                Add Package
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
