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
                                        $drag = "draggable";
                                        $ondragstart = "";
                                        $room = "style_occupied";
                                        $dragclass = "";
                                        $dragcontainer = "";
                                    @endphp
                                @else
                                    @php
                                        $drag = "droppable";
                                        $dragclass = "droptarget";
                                        $ondragstart = "";
                                        $room = "room";
                                        $dragcontainer = "";
                                    @endphp
                                @endif
                            <div class="col-xl-3 {{ $dragclass }}">
                                <div class="card-box {{ $room }}">
                                    <div id="{{ $r->job_order }}" class="{{ $drag }} {{ $room }}" room="{{ $r->roomname }}">
                                    @if($r->status == 'Active')
                                        <p class="header-title">{{ $r->roomname}}</p>
                                        <button type="button" class="btn btn-block btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                    @else
                                    <p class="header-title">{{ $r->roomname}}</p>
                                    <button type="button" class="btn btn-block btn-success btn-sm doneJobOrder" data-id="{{ $r->job_order }}" disabled="">Done</button>
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
                                                @else
                                                <div class="input-group">
                                                    <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                    <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                </div>
                                                <button class="btn btn-primary waves-effect waves-light btn-block" type="button" disabled>Start</button>
                                                @endif
                                            </div>
                                            <div id="show_timer" style="display: none">
                                            </div>
                                        </div>
                                    </form>
                                    </div>
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
                                        $drag = "draggable";
                                        $ondragstart = "";
                                        $room = "style_occupied";
                                        $dragclass = "";
                                        $dragcontainer = "";
                                    @endphp
                                @else
                                    @php
                                        $drag = "droppable";
                                        $dragclass = "droptarget";
                                        $ondragstart = "";
                                        $room = "room";
                                        $dragcontainer = "";
                                    @endphp
                                @endif
                            <div class="col-xl-3 {{ $dragclass }}">
                                <div class="card-box {{ $room }}">
                                    <div id="{{ $r->job_order }}" class="{{ $drag }} {{ $room }}" room="{{ $r->roomname }}">
                                    @if($r->status == 'Active')
                                        <p class="header-title">{{ $r->roomname}}</p>
                                        <button type="button" class="btn btn-success btn-sm btn-block doneJobOrder" data-id="{{ $r->job_order }}">Done</button>
                                    @else
                                    <p class="header-title">{{ $r->roomname}}</p>
                                        <button type="button" class="btn btn-success btn-sm btn-block doneJobOrder" data-id="{{ $r->job_order }}" disabled="">Done</button>
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
                                                @else
                                                <div class="input-group">
                                                    <input type="text" class="col-sm-6 form-control" placeholder="H" readonly="" />
                                                    <input type="text" class="col-sm-6 form-control" placeholder="M" readonly="" />
                                                </div>
                                                <button class="btn btn-primary waves-effect waves-light btn-block" type="button" disabled>Start</button>
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

    var baseurl=window.location.protocol + "//" + window.location.host + "/";

    $( function() {

        $('.draggable').draggable({
            revert: "invalid",
            zIndex: 2500
        });

        $('.droppable').droppable({
            accept: '.draggable',
            drop: Drop
        });
    });

    function Drop(event, ui) {
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var joborder = ui.draggable.attr("id");
        var roomid = $(this).attr("room");
        
        swal({
            title: 'Are you sure?',
            text: 'You want to transfer job order#'+joborder+' to '+roomid+'?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
          if (result.value) {
            $.ajax({
                type:'POST',
                url: baseurl + 'joborder/transfer',
                data:{'job_order':joborder,'room_no_form':roomid},
                success: function(data) {
                    swal(
                      'Done!',
                      'Job Order #' + joborder + ' is transfered!',
                      'success'
                    )
                    setTimeout(function() {
                        location.reload();
                    }, 1000)
                }
            });
          } else {
            location.reload();
          }
        });
    }
</script>
@endpush