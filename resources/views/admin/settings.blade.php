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
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                    <h4 class="page-title">Settings</h4>
    			</div>
    			<div clas="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form class="form-horizontal" method="post" action="{{ URL::to('admin/settings', $settings->id) }}" id="settingsForm">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">System Identity</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="system_title" id="system_title" value="{{ $settings->title }}"/>
                                    </div>
                                </div>
                                <div class="form-group col-md-12 col-xs-12">
                                <div class="clearfix text-right mt-3">
                                    <button type="submit" id="settingsFormBtn" class="btn btn-success">
                                        Save Settings
                                    </button>
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