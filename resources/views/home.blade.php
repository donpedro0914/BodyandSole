@extends('layouts.appfront')

@section('content')
    @include('global.front_topnav')
    @include('modal.joborder')
    <div class="wrapper">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <ul class="nav nav-tabs tabs-bordered nav-justified">
                            <li class="nav-item">
                                <a href="#job_order_list" data-toggle="tab" aria-expanded="true" class="nav-link">
                                    <i class="mdi mdi-view-list"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#job_order_grid" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="mdi mdi-grid-large"></i>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane" id="job_order_list">
                                <div class="card-box">
                                    <table class="table table-bordered dataTable no-footer table-striped ajax-table-joborder">
                                        <thead>
                                            <tr>
                                                <th>Job Order</th>
                                                <th>Client's Name</th>
                                                <th>Therapist</th>
                                                <th>Service</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                            @foreach($joborder as $j)
                                            <tr>
                                                <td>{{ $j->job_order }}</td>
                                                <td>{{ $j->client_fullname }}</td>
                                                <td>{{ $j->therapistname }}</td>
                                                <td>
                                                @if($j->service != '-')
                                                {{ $j->service_name }} ({{ $j->price }})
                                                @else
                                                {{ $j->addon }} ({{ $j->price }})
                                                @endif
                                                </td>
                                                <td>
                                                    @if($j->care_of)
                                                    {{ $j->payment }} - {{ $j->care_of }}
                                                    @elseif($j->gcno)
                                                    {{ $j->payment }} - {{ $j->gcno }}
                                                    @else
                                                    {{ $j->payment }}
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($j->status == 'Active')
                                                    <span class="badge badge-primary">Active</span>
                                                    @elseif($j->status == 'Done')
                                                    <span class="badge badge-success">Done</span>
                                                    @else
                                                    <span class="badge badge-danger">Cancelled</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane active" id="job_order_grid">
                                <div class="card-box" style="background: #ffe1e1;">
                                    <div class="row">
                                        <div class="col-xl-6" style="border-right:1px solid #636363">
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <h2 class="text-center" style="color: #635e5e">Rooms</h2>
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
                                                    @php
                                                        if($r->service != '-') {
                                                            $service = $r->servicename;
                                                        } else {
                                                            $service = $r->addon;
                                                        }
                                                    @endphp
                                                <div class="col-xl-3 {{ $dragclass }}">
                                                    <div class="card-box {{ $room }}" title="Job Order#:{{ $r->job_order}}<br/>Therapist:{{ $r->therapistname }}<br/>Service:{{ $service }}">
                                                        <div id="{{ $r->job_order }}" class="{{ $drag }} {{ $room }}" room="{{ $r->roomname }}">
                                                        @if($r->status == 'Active')
                                                            <p class="header-title float-left">{{ $r->roomname}}</p>
                                                            <a class="header-title float-right" onclick="javascript:jsWebClientPrint.print('id={!! $r->job_order !!}&useDefaultPrinter=checked&printerName=BIXOLON SRP-350')""><i class="mdi mdi-printer"></i></a>
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
                                                                            <div id="countdown" data-room="{{ $r->roomname }}" data-timer="{{ $r->duration }}"></div>
                                                                        @else
                                                                            <input type="text" class="col-sm-6 form-control time_in" name="time_in[]" placeholder="H"/>
                                                                            <input type="text" class="col-sm-6 form-control time_out" name="time_out[]" placeholder="M"/>
                                                                        @endif
                                                                    </div>
                                                                    @php
                                                                        if($r->duration) {
                                                                            $duration = "none";
                                                                        } else {
                                                                            $duration = "block";
                                                                        }
                                                                    @endphp
                                                                    <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="" class="btn btn-primary waves-effect btn-block waves-light start_time" style="display:{{ $duration }}" type="button">Start</button>
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
                                                    <h2 class="text-center" style="color: #635e5e">Lounges</h2>
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
                                                    @php
                                                        if($r->service != '-') {
                                                            $service = $r->servicename;
                                                        } else {
                                                            $service = $r->addon;
                                                        }
                                                    @endphp
                                                <div class="col-xl-3 {{ $dragclass }}">
                                                    <div class="card-box {{ $room }}" title="Job Order#:{{ $r->job_order}}<br/>Therapist:{{ $r->therapistname }}<br/>Service:{{ $service }}">
                                                        <div id="{{ $r->job_order }}" class="{{ $drag }} {{ $room }}" room="{{ $r->roomname }}">
                                                        @if($r->status == 'Active')
                                                            <p class="header-title float-left">{{ $r->roomname}}</p>
                                                            <a class="header-title float-right" onclick="javascript:jsWebClientPrint.print('id={!! $r->job_order !!}&useDefaultPrinter=checked&printerName=BIXOLON SRP-350')""><i class="mdi mdi-printer"></i></a>
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
                                                                            <div id="countdown" data-room="{{ $r->roomname }}" data-timer="{{ $r->duration }}"></div>
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
                                                                    <button data-room="{{ $r->roomid }}" data-id="{{ $r->job_order }}" id="" class="btn btn-primary waves-effect btn-block waves-light start_time" style="display:{{ $duration }}" type="button">Start</button>
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
                                    </div>
                                </div>
                            </div>
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
    $(document).ready(function() {
        
        var baseurl=window.location.protocol + "//" + window.location.host + "/";

        $("#jo_From").datepicker({
            autoclose: true,
            format: "yyyy-mm-dd",
            clearBtn: true,
        });
        
        $('.style_occupied').tooltip({
            position: {
                my: 'center top',
                at: 'center center',
            },
            content: function() {
                return $(this).attr('title');
            },
            show: {
                delay: 1000
            }
        });
    });
    

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
                    location.reload();
                }
            });
          } else {
            location.reload();
          }
        });
    }
</script>
{!! $wcpScript !!}
@endpush