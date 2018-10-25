@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    @include('modal.joborder')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-6" style="border-right:1px solid #ccc">
                        <div class="row">
                            <div class="col-xl-12">
                                <h2 class="text-center">Rooms</h2>
                            </div>
                        @foreach($rooms as $r)
                                @if($r->status == 'Active')
                                    @php
                                        $drag = "draggable=true";
                                        $ondragstart = "ondragstart=dragStart(event)";
                                        $room = "style_occupied";
                                        $dragclass = "";
                                        $dragcontainer = "";
                                    @endphp
                                @else
                                    @php
                                        $drag = "";
                                        $dragclass = "droptarget";
                                        $ondragstart = "";
                                        $room = "room";
                                        $dragcontainer = "ondrop=drop(event) ondragover=allowDrop(event)";
                                    @endphp
                                @endif
                                <div class="col-xl-3 {{ $dragclass }}" {{ $dragcontainer }}>
                                <div class="card-box {{ $room }}" {{ $drag }} {{ $ondragstart }}>
                                    @if($r->status == 'Active')
                                        <p class="header-title float-left">{{ $r->roomname}}</p>
                                        <div class="float-right">
                                            <button type="button" class="btn btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                        </div>
                                    @else
                                    <p class="header-title float-left">{{ $r->roomname}}</p>
                                    @endif
                                    <div class="clearfix"></div>
                                    <form class="form-horizontal" id="room_id_{{ $r->roomid }}" data-room="{{ $r->roomid }}">
                                        <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                        <div class="form-group">
                                            <label>Time</label>
                                            <div id="enter_time">
                                                @if($r->status == 'Active')
                                                <div class="input-group">
                                                    @if($r->duration)
                                                        <div id="countdown" data-room="{{ $r->roomid }}" data-timer="{{ $r->duration }}"></div>
                                                    @else
                                                        <input type="text" class="col-sm-6 form-control" id="time_in_hr" placeholder="H"/>
                                                        <input type="text" class="col-sm-6 form-control" id="time_in_min" placeholder="M"/>
                                                    @endif
                                                </div>
                                                @php
                                                    if($r->duration) {
                                                        $duration = "none";
                                                    } else {
                                                        $duration = "block";
                                                    }
                                                @endphp
                                                <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="start_timer" class="btn btn-primary waves-effect btn-block waves-light" style="display:{{ $duration }}" type="button">Start</button>
                                                <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="transfer" class="btn btn-xs btn-warning btn-block waves-effect waves-light" style="display:{{ $duration }}" type="button">Transfer</button>
                                                @else
                                                <div class="input-group">
                                                    <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                    <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                </div>
                                                <button class="btn btn-primary waves-effect waves-light btn-block" type="button" disabled>Start</button>
                                                <button class="btn btn-xs btn-warning btn-block waves-effect waves-light" type="button" disabled>Transfer</button>
                                                @endif
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
                    <div class="col-xl-6">
                        <div class="row">
                            <div class="col-xl-12">
                                <h2 class="text-center">Lounges</h2>
                            </div>
                        @foreach($lounge as $r)
                                @if($r->status == 'Active')
                                    @php
                                        $drag = "draggable=true";
                                        $ondragstart = "ondragstart=dragStart(event)";
                                        $room = "style_occupied";
                                        $dragclass = "";
                                    @endphp
                                @else
                                    @php
                                        $drag = "";
                                        $dragclass = "droptarget";
                                        $ondragstart = "";
                                        $room = "room";
                                    @endphp
                                @endif
                                <div class="col-xl-3 {{ $dragclass }}">
                                    <div class="card-box {{ $room }}" {{ $drag }} {{ $ondragstart }}>
                                    @if($r->status == 'Active')
                                        <p class="header-title float-left">{{ $r->roomname}}</p>
                                        <div class="float-right">
                                            <button type="button" class="btn btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                        </div>
                                    @else
                                    <p class="header-title float-left">{{ $r->roomname}}</p>
                                    @endif
                                    <div class="clearfix"></div>
                                    <form class="form-horizontal" id="room_id_{{ $r->roomid }}" data-room="{{ $r->roomid }}">
                                        <input type="hidden" id="room_no" value="{{ $r->roomid }}" />
                                        <div class="form-group">
                                            <label>Time</label>
                                            <div id="enter_time">
                                                @if($r->status == 'Active')
                                                <div class="input-group">
                                                    @if($r->duration)
                                                        <div id="countdown" data-room="{{ $r->roomid }}" data-timer="{{ $r->duration }}"></div>
                                                    @else
                                                        <input type="text" class="col-sm-6 form-control" id="time_in_hr" placeholder="H"/>
                                                        <input type="text" class="col-sm-6 form-control" id="time_in_min" placeholder="M"/>
                                                    @endif
                                                </div>
                                                @php
                                                    if($r->duration) {
                                                        $duration = "none";
                                                    } else {
                                                        $duration = "block";
                                                    }
                                                @endphp
                                                <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="start_timer" class="btn btn-primary waves-effect btn-block waves-light" style="display:{{ $duration }}" type="button">Start</button>
                                                <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="transfer" class="btn btn-xs btn-warning btn-block waves-effect waves-light" style="display:{{ $duration }}" type="button">Transfer</button>
                                                @else
                                                <div class="input-group">
                                                    <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                    <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                </div>
                                                <button class="btn btn-primary waves-effect waves-light btn-block" type="button" disabled>Start</button>
                                                <button class="btn btn-xs btn-warning btn-block waves-effect waves-light" type="button" disabled>Transfer</button>
                                                @endif
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
@push('scripts')
<script type="text/javascript">
    function dragStart(event) {
    }
</script>
@endpush