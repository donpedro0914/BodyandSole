@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    @include('modal.joborder')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row">
                        @foreach($rooms as $r)
                            <div class="col-xl-4">
                                @if($r->status == 'Active')
                                    @php
                                        $room = "style_occupied";
                                    @endphp
                                @else
                                    @php
                                        $room = "room";
                                    @endphp
                                @endif
                                <div class="card-box ribbon-box {{ $room }}">
                                    @if($r->status == 'Active')
                                        <div class="float-right">
                                            <button type="button" class="btn btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                        </div>
                                    @endif
                                    <div class="clearfix"></div>
                                    <p class="header-title">{{ $r->roomname}}</p>
                                    <form class="form-horizontal" id="room_id_{{ $r->roomid }}" data-room="{{ $r->roomid }}">
                                        <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                        <div class="form-group">
                                            <label>Therapist</label>
                                            @if($r->status == 'Active')
                                            <input type="text" class="form-control" value="{{ $r->therapistname }} "readonly="" />
                                            @else
                                            <input type="text" class="form-control" readonly="" />
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label>Time</label>
                                            <div id="enter_time">
                                                <div class="input-group">
                                                @if($r->status == 'Active')
                                                    @if($r->duration)
                                                        <div id="countdown" data-room="{{ $r->roomid }}" data-timer="{{ $r->duration }}"></div>
                                                    @else
                                                        <input type="text" class="col-sm-6 form-control" id="time_in_hr" placeholder="H"/>
                                                        <input type="text" class="col-sm-6 form-control" id="time_in_min" placeholder="M"/>
                                                        <div class="input-group-append">
                                                            <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="start_timer" class="btn btn-primary waves-effect waves-light" type="button">Start</button>
                                                        </div>
                                                    @endif
                                                @else
                                                    <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                    <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary waves-effect waves-light" type="button" disabled>Start</button>
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                            <div id="show_timer" style="display: none">
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
        </div>
    </div>
@endsection
