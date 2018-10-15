@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    @include('modal.joborder')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    @foreach($rooms as $r)
                    <div class="col-xl-4">
                        @if($r->status == 'Active')
                        <div class="card-box ribbon-box">
                        @else
                        <div class="card-box ribbon-box room">
                        @endif
                            @if($r->status == 'Active')
                            <div class="ribbon ribbon-danger">Occupied</div>
                            <div class="float-right">
                                <button type="button" class="btn btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button> <button type="button" class="btn btn-danger btn-sm cancelJobOrder" data-id="{{ $r->job_order }}">Canceled</button>
                            </div>
                            @else
                            <div class="ribbon ribbon-success">Available</div>
                            @endif
                            <div class="clearfix"></div>
                            <p class="header-title">{{ $r->roomname}}</p>
                            <form class="form-horizontal" id="room_id_{{ $r->roomid }}" data-room="{{ $r->roomid }}">
                                <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Job Order #</label>
                                    <div class="col-sm-8">
                                        @if($r->status == 'Active')
                                        <input type="text" class="form-control" value="{{ $r->job_order }}" readonly />
                                        @else
                                        <input type="text" class="form-control" readonly />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Client's Name</label>
                                    <div class="col-sm-8">
                                        @if($r->status == 'Active')
                                        <input type="text" class="form-control" value="{{ $r->client_fullname }}" readonly="" />
                                        @else
                                        <input type="text" class="form-control" readonly="" />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Therapist</label>
                                    <div class="col-sm-8">
                                        @if($r->status == 'Active')
                                        <input type="text" class="form-control" value="{{ $r->therapistname }} "readonly="" />
                                        @else
                                        <input type="text" class="form-control" readonly="" />
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Time</label>
                                    <div class="col-sm-8" id="enter_time">
                                        <div class="input-group">
                                        @if($r->status == 'Active')
                                            @if($r->duration)
                                                <div id="countdown" data-timer="{{ $r->duration }}"></div>
                                            @else
                                                <input type="text" class="col-sm-6 form-control" id="time_in_hr" placeholder="Hour"/>
                                                <input type="text" class="col-sm-6 form-control" id="time_in_min" placeholder="Minute"/>
                                                <div class="input-group-append">
                                                    <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="start_timer" class="btn btn-primary waves-effect waves-light" type="button">Start</button>
                                                </div>
                                            @endif
                                        @else
                                            <input type="text" class="col-sm-6 form-control" placeholder="Hour" readonly="" />
                                            <input type="text" class="col-sm-6 form-control" placeholder="Minute" readonly="" />
                                            <div class="input-group-append">
                                                <button class="btn btn-primary waves-effect waves-light" type="button" disabled>Start</button>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-8" id="show_timer" style="display: none">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
