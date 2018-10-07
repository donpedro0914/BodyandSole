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
                        <li class="breadcrumb-item active"><a href="/services">Services</a></li>
                        <li class="breadcrumb-item">{{ $services->service_name }}</li>
                    </ol>
                    <h4 class="page-title">{{ $services->service_name }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form id="serviceFormUpdate" action="{{ URL::to('services/update', $services->id) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Service Name</label>
                                        <input type="text" class="form-control" name="service_name" id="service_name" value="{{ $services->service_name }}"/>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Labor-S</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="labor_s" id="labor_s" value="{{ $services->labor_s }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Labor-P</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="labor_p" id="labor_p" value="{{ $services->labor_p }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Charge</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="charge" id="charge" value="{{ $services->charge }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="serviceFormBtnUpdate" class="btn btn-success">
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