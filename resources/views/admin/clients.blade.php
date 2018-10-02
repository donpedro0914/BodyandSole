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
                        <li class="breadcrumb-item active">Clients</li>
                    </ol>
                    <h4 class="page-title">Clients</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#addclient" data-animation="blur" data-overlayspeed="100" data-overlaycolor="#36404a"><i class="mdi mdi-account-plus"></i> Add Client</button>
                            @include('modal.client')
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <table class="table table-bordered dataTable no-footer table-striped ajax-table-client">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Address</th>
                                        <th>Contact #</th>
                                        <th>Last Visit</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection
@push('scripts')

<script type="text/javascript">
    function getDate(date) {
    var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    var date = new Date(date);
    var year = date.getFullYear();
    var month = (date.getMonth()).toString();
    //month = month.length > 1 ? month : '0' + month;
    var day = date.getDate().toString();
    day = day.length > 1 ? day : '0' + day;
    return months[month] + ' ' + day + ', ' + year;
    }

    var BaseTableDatatables = function() {

        var initDataTableCampaigns = function() {

            $('.ajax-table-client').DataTable({
                pagingType: "full_numbers",
                columnDefs: [ { orderable: false, targets: [ 0 ] } ],
                pageLength: 20,
                bSort: false,
                lengthMenu: [[5, 10, 15, 20, 50, 100], [5, 10, 15, 20, 50, 100]],
                processing: true,
                serverSide: true,
                language: {
                    processing: "<img src='../img/ajax-loader.gif'>",
                    emptyTable: "No positions yet."
                },
                ajax: "{{ route('position.position_list') }}",
                columns: [
                    { data : "position_name" },
                    { data : "action" }
                ],
                columnDefs: [
                    { className: "text-center", targets: [ 0 ], 
                        render: function(data,type,full,meta){
                            return "<a href= '" + document.location.origin + "/position/info/" + full["id"] + "'>" + data + "</a>";
                        }
                    },
                    { 
                        className: "text-center",  
                        targets: [ 1 ], //action column
                        render: function(data,type,full,meta){
                            var result = "";
                            var view ="<a href= '" + document.location.origin + "/position/info/" + full["id"] + "' class='btn btn-xs btn-default btn-edit' data-toggle='tooltip' data-original-title='View Information'>" + 
                                "<i class='fa fa-eye'></i>" + 
                            "</a>";
                            var edit = "<a href= '" + document.location.origin + "/position/info/" + full["id"] + "' class='btn btn-xs btn-default btn-edit' data-toggle='tooltip' data-original-title='Edit Information'>" + 
                                "<i class='fa fa-pencil'></i>" + 
                            "</a>";
                            var del = "<button data-module='position' data-name='"+ full['position_name'] +"' class='btn btn-xs btn-default btn-delete js-swal-confirm' data-toggle='tooltip' data-original-title='Delete Information' id ='" + full['id'] + "'>" + 
                                "<i class='fa fa-close'></i>" + 
                            "</button>";
                            // if( $('body').attr('id').charAt(6) == '0'){
                            //     result = result + view;
                            // }else{
                            //     result = result + edit; 
                            // }

                            // if( $('body').attr('id').charAt(7) != '0'){
                            //     result = result + del;
                            // }

                            // return result;

                            result = result + edit + del;
                            return result;
                        }
                    }

                ]
            });
        }

        var bsDataTables = function() {
            var $DataTable = jQuery.fn.dataTable;
            jQuery.extend( true, $DataTable.defaults, {
                dom:
                    "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6'p>>",
                renderer: 'bootstrap',
                oLanguage: {
                    sLengthMenu: "_MENU_",
                    sInfo: "Showing <strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
                    oPaginate: {
                        sPrevious: '<i class="fa fa-angle-left"></i>',
                        sNext: '<i class="fa fa-angle-right"></i>'
                    }
                }
            });

            jQuery.extend($DataTable.ext.classes, {
                sWrapper: "dataTables_wrapper form-inline dt-bootstrap",
                sFilterInput: "form-control",
                sLengthSelect: "form-control"
            });

            $DataTable.ext.renderer.pageButton.bootstrap = function (settings, host, idx, buttons, page, pages) {
                var api     = new $DataTable.Api(settings);
                var classes = settings.oClasses;
                var lang    = settings.oLanguage.oPaginate;
                var btnDisplay, btnClass;

                var attach = function (container, buttons) {
                    var i, ien, node, button;
                    var clickHandler = function (e) {
                        e.preventDefault();
                        if (!jQuery(e.currentTarget).hasClass('disabled')) {
                            api.page(e.data.action).draw(false);
                        }
                    };

                    for (i = 0, ien = buttons.length; i < ien; i++) {
                        button = buttons[i];

                        if (jQuery.isArray(button)) {
                            attach(container, button);
                        }
                        else {
                            btnDisplay = '';
                            btnClass = '';

                            switch (button) {
                                case 'ellipsis':
                                    btnDisplay = '&hellip;';
                                    btnClass = 'disabled';
                                    break;

                                case 'first':
                                    btnDisplay = lang.sFirst;
                                    btnClass = button + (page > 0 ? '' : ' disabled');
                                    break;

                                case 'previous':
                                    btnDisplay = lang.sPrevious;
                                    btnClass = button + (page > 0 ? '' : ' disabled');
                                    break;

                                case 'next':
                                    btnDisplay = lang.sNext;
                                    btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                    break;

                                case 'last':
                                    btnDisplay = lang.sLast;
                                    btnClass = button + (page < pages - 1 ? '' : ' disabled');
                                    break;

                                default:
                                    btnDisplay = button + 1;
                                    btnClass = page === button ?
                                            'active' : '';
                                    break;
                            }

                            if (btnDisplay) {
                                node = jQuery('<li>', {
                                    'class': classes.sPageButton + ' ' + btnClass,
                                    'aria-controls': settings.sTableId,
                                    'tabindex': settings.iTabIndex,
                                    'id': idx === 0 && typeof button === 'string' ?
                                            settings.sTableId + '_' + button :
                                            null
                                })
                                .append(jQuery('<a>', {
                                        'href': '#'
                                    })
                                    .html(btnDisplay)
                                )
                                .appendTo(container);

                                settings.oApi._fnBindAction(
                                    node, {action: button}, clickHandler
                                );
                            }
                        }
                    }
                };

                attach(
                    jQuery(host).empty().html('<ul class="pagination"/>').children('ul'),
                    buttons
                );
            }

            if ($DataTable.TableTools) {
                // Set the classes that TableTools uses to something suitable for Bootstrap
                jQuery.extend(true, $DataTable.TableTools.classes, {
                    "container": "DTTT btn-group",
                    "buttons": {
                        "normal": "btn btn-default",
                        "disabled": "disabled"
                    },
                    "collection": {
                        "container": "DTTT_dropdown dropdown-menu",
                        "buttons": {
                            "normal": "",
                            "disabled": "disabled"
                        }
                    },
                    "print": {
                        "info": "DTTT_print_info"
                    },
                    "select": {
                        "row": "active"
                    }
                });

                // Have the collection use a bootstrap compatible drop down
                jQuery.extend(true, $DataTable.TableTools.DEFAULTS.oTags, {
                    "collection": {
                        "container": "ul",
                        "button": "li",
                        "liner": "a"
                    }
                });
            }
        };

        return {
            init: function() {
                // Init Datatables
                bsDataTables();
                initDataTableCampaigns();
            }
        };

    }();
    jQuery(function(){ BaseTableDatatables.init(); });
</script>
@endpush