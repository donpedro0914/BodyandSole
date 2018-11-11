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
                        <li class="breadcrumb-item active"><a href="/clients">Gift Certificate</a></li>
                        <li class="breadcrumb-item">{{ $gc->gc_no }}</li>
                    </ol>
                    <h4 class="page-title">{{ $gc->gc_no }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form action="{{ URL::to('gc/update', $gc->id) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Reference No.</label>
                                        <input type="text" class="form-control" name="ref_no" value="{{ $gc->ref_no}}" readonly="" />
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Gift Cert No</label>
                                        <input type="text" class="form-control" name="gc_no" value="{{ $gc->gc_no}}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Purchased By</label>
                                        <input type="text" class="form-control" name="purchased_by" value="{{ $gc->purchased_by}}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Service</label>
                                        {{ Form::select('service', $service, $gc->service, ['class' => 'form-control select2']) }}
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Value</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="value" value="{{ $gc->value}}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label># of use</label>
                                        <input type="text" class="form-control" name="use" value="{{ $gc->use}}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Date Issued</label>
                                        <input type="text" class="form-control date" name="date_issued" placeholder="mm/dd/yyyy" id="date_issued" value="{{ $gc->date_issued}}">
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Expiry Date</label>
                                        <input type="text" class="form-control date" name="expiry_date" placeholder="mm/dd/yyyy" id="expiry_date" value="{{ $gc->expiry_date}}">
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" class="btn btn-success">
                                                Update Gift Certificate
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