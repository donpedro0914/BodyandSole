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
                        <li class="breadcrumb-item active"><a href="/clients">Clients</a></li>
                        <li class="breadcrumb-item">{{ $client->fullname }}</li>
                    </ol>
                    <h4 class="page-title">{{ $client->fullname }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form id="clientsFormUpdate" action="{{ URL::to('client/update', $client->id) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" value="{{ $client->fullname }}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $client->phone }}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Email</label>
                                        <input type="text" class="form-control" name="email" id="email" value="{{ $client->email }}"/>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Date of Birth</label>
                                        <input type="text" class="form-control" name="dob" id="dob" value="{{ $client->dob }}"/>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Occupation</label>
                                        <input type="text" class="form-control" name="occupation" id="occupation" value="{{ $client->occupation }}"/>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Senior Citizen ID</label>
                                        <input type="text" class="form-control" name="sc_id" id="sc_id" value="{{ $client->sc_id }}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="clientsFormBtnUpdate" class="btn btn-success">
                                                Update Client
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