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
                        <li class="breadcrumb-item active"><a href="/therapist">Therapist</a></li>
                        <li class="breadcrumb-item">{{ $therapist->fullname }}</li>
                    </ol>
                    <h4 class="page-title">{{ $therapist->fullname }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form id="therapistFormUpdate" action="{{ URL::to('therapist/update', $therapist->id) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Full Name</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" value="{{ $therapist->fullname }}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="{{ $therapist->address }}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Phone</label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $therapist->phone }}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Date of Birth</label>
                                        <input type="text" class="form-control" name="dob" id="dob" value="{{ $therapist->dob }}"/>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Hired</label>
                                        <input type="text" class="form-control" name="hired" placeholder="mm/dd/yyyy" id="hired_date" value="{{ $therapist->hired }}">
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Resigned</label>
                                        <input type="text" class="form-control" name="resigned" placeholder="mm/dd/yyyy" id="hired_date" value="{{ $therapist->resigned }}">
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Lodging</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="lodging" id="lodging" value="{{ $therapist->lodging }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Allowance</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="allowance" id="allowance" value="{{ $therapist->allowance }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <h4 class="header-title">Deductions</h4>
                                        <hr />
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>S.S.S</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="sss" id="sss" value="{{ $therapist->sss }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Phil Health</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="phealth" id="phealth" value="{{ $therapist->phealth }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>H.D.F</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="hdf" id="hdf" value="{{ $therapist->hdf }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Uniform</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="uniform" id="uniform" value="{{ $therapist->uniform }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Fare</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="fare" id="fare" value="{{ $therapist->fare }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 col-xs-12">
                                        <label>Others</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="others" id="others" value="{{ $therapist->others }}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Status</label>
                                        <select name="status" class="form-control" id="status">
                                            <option value="{{ $therapist->status }}">{{ $therapist->status }}</option>
                                            <option value="Active">Active</option>
                                            <option value="Not Active">Not Active</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" id="therapistFormBtnUpdate" class="btn btn-success">
                                                Update Therapist
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