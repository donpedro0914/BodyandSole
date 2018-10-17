$(document).ready(function() {

	var baseurl=window.location.protocol + "//" + window.location.host + "/";

	//Plugins
	$('#datepicker-autoclose').datepicker({
        autoclose: true,
        todayHighlight: true
    });
	$('#hired_date').datepicker({
        autoclose: true,
        todayHighlight: true
    });
	$('#resigned_date').datepicker({
        autoclose: true,
        todayHighlight: true
    });
	$('.date').datepicker({
        autoclose: true,
        todayHighlight: true
    });

    jQuery.fn.dataTable.Api.register( 'sum()', function ( ) {
        return this.flatten().reduce( function ( a, b ) {
            if ( typeof a === 'string' ) {
                a = a.replace(/[^\d.-]/g, '') * 1;
            }
            if ( typeof b === 'string' ) {
                b = b.replace(/[^\d.-]/g, '') * 1;
            }

            return a + b;
        }, 0 );
    } );

    $(".select2").select2();

	//Add Job Order
	$('[data-timer]').each(function() {
		var $this = $(this), finalDuration = $(this).data('timer');
		$this.countdown(finalDuration, function(event) {
			$(this).html(event.strftime(''
		    + '<span>%H</span> hr '
		    + '<span>%M</span> min '
		    + '<span>%S</span> sec'));
		})
	});

	$('#joborder').on('hide.bs.modal', function() {
		$('#Service').hide();
		$('#Package').hide();
		$('#Service select').removeAttr('name');
		$('#Package select').removeAttr('name');
	});


	$('.room').on('click', function() {
		$('#joborder').modal('show');
		var room_id = $(this).find('#room_no').val();

		$('#room_no_form').val(room_id);
	});

	$('#package_id').on('change', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();

		var package_id = $('#package_id').val();

		$.ajax({
			type: 'post',
			url: baseurl + 'package/getpackagedetails',
			data:{'id':package_id},
			success: function(data) {
				$('#price').empty();
				$('#price').val(data['price']);
			}
		});
	});

	$('#package_services_front').on('change', function(e){

		var package_services = $(this).val();

		if(package_services != '') {

		$('#package_servicec_btn_front').removeAttr('disabled');

		} else {

		$('#package_servicec_btn_front').attr('disabled');
		$('#package_inclusion tbody').empty();
		$('#package_labor_total').empty();
		$('#package_labor_total').html('₱0.00');
		$('#package_total').empty();
		$('#package_total').html('₱0.00');

		}

	});

	$('#package_servicec_btn_front').on('click', function(e) {

		e.preventDefault();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var services = $('#package_services_front').val();

		$('#service').val(services);

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: baseurl + 'front/ajaxService',
			data: {'id':services},
			success: function(data) {
				$('#package_inclusion tbody').empty();
				var total = 0;
				var labor = 0;
				for(var i=0; i<data.length;i++){
					$('#package_inclusion tbody').append('<tr><td>'+data[i].id+'</td><td>'+data[i].service_name+'</td><td>'+data[i].labor_s+'</td><td>'+data[i].charge+'</td></tr>');
					total += Number(data[i].charge);
					labor += Number(data[i].labor_s);
				}
				$('#package_labor_total').empty();
				$('#package_labor_total').html('₱'+labor+'.00');
				$('#commission').val(labor);
				$('#package_total').empty();
				$('#package_total').html('₱'+total+'.00');
				$('#price').val(total)
			}
		});
	});

	$('#jobOrderForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#jobOrderForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend: function() {
				$('#jobOrderFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");				
			},
			success: function(data) {
				$('#jobOrderFormBtn').html('<i class="mdi mdi-send mr-l"></i> Submit').removeAttr("disabled");
				$('#joborder').modal('hide');
				$('#jobOrderForm')[0].reset();
				swal(
	                {
	                    title: 'Done!',
	                    text: 'Job Order #: '+data['job_order']+' added!',
	                    type: 'success'
	                }
	            );
				setTimeout(function() {
					location.reload();
				}, 1000)
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});	

	});

	$('.doneJobOrder').on('click', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var job_order = $(this).attr('data-id');

		swal({
			title: 'Are you sure?',
			text: 'Job Order #' + job_order + ' is done?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
		  if (result.value) {
		  	$.ajax({
				type:'POST',
				url: baseurl + 'joborder/update',
				data:{'job_order':job_order},
				success: function(data) {
				    swal(
				      'Done!',
				      'Job Order #' + job_order + ' is done!',
				      'success'
				    )
					setTimeout(function() {
						location.reload();
					}, 1000)
				}
			});
		  }
		});
	});

	$('.cancelJobOrder').on('click', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var job_order = $(this).attr('data-id');

		swal({
			title: 'Are you sure?',
			text: 'Job Order #' + job_order + ' is cancelled?',
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes!'
		}).then((result) => {
		  if (result.value) {
		  	$.ajax({
				type:'POST',
				url: baseurl + 'joborder/cancelupdate',
				data:{'job_order':job_order},
				success: function(data) {
				    swal(
				      'Done!',
				      'Job Order #' + job_order + ' is cancelled!',
				      'success'
				    )
					setTimeout(function() {
						location.reload();
					}, 1000)
				}
			});
		  }
		});
	});

	$('#start_timer').on('click', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();

		var hr = $('#time_in_hr').val();
		var min = $('#time_in_min').val();
		var job_order = $(this).attr('data-id');
		var room_id = $(this).attr('data-room');

		$.ajax({
			type: 'POST',
			url: baseurl + 'joborder/duration',
			data:{'job_order':job_order,'hr':hr,'min':min},
			success: function(data) {
				$('#room_id_'+room_id+' #enter_time').hide();
				$('#room_id_'+room_id+' #show_timer').show();

				$('#room_id_'+room_id+' #show_timer').countdown(data['duration'], function(event) {
				  $(this).html(event.strftime(''
				    + '<span>%H</span> hr '
				    + '<span>%M</span> min '
				    + '<span>%S</span> sec'));
				});
				location.reload();
			}
		});

	});

	//Therapist
	$('#therapistForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#therapistForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#therapistFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#therapistFormBtn').html('<i class="mdi mdi-send mr-l"></i> Submit').removeAttr("disabled");
				$('#addTherapist').modal('hide');
				$('#therapistForm')[0].reset();
				swal(
	                {
	                    title: 'Done!',
	                    text: 'Therapist added!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				location.reload();
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Update Therapist
	$('#therapistFormUpdate').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#therapistFormUpdate')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#therapistFormBtnUpdate').html('<img src="/img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#therapistFormBtnUpdate').html('Update Therapist').removeAttr("disabled");
				swal(
	                {
	                    title: 'Done!',
	                    text: data['fullname']+' therapist updated!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				$('#fullname').val(data['fullname']);
				$('#address').val(data['address']);
				$('#phone').val(data['phone']);
				$('#dob').val(data['dob']);
				$('#hired').val(data['hired']);
				$('#resigned').val(data['resigned']);
				$('#lodging').val(data['lodging']);
				$('#allowance').val(data['allowance']);
				$('#sss').val(data['sss']);
				$('#phealth').val(data['phealth']);
				$('#hdf').val(data['hdf']);
				$('#uniform').val(data['uniform']);
				$('#fare').val(data['fare']);
				$('#others').val(data['others']);
				$('#status').val(data['status']);
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Add Client
	$('#clientsForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#clientsForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#clientsFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#clientsFormBtn').html('Add Client').removeAttr("disabled");
				$('#addclient').modal('hide');
				$('#clientsForm')[0].reset();
				swal(
	                {
	                    title: 'Done!',
	                    text: 'Client added!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				location.reload();
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Update Service
	$('#clientsFormUpdate').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#clientsFormUpdate')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#clientsFormBtnUpdate').html('<img src="/img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#clientsFormBtnUpdate').html('Update Client').removeAttr("disabled");
				swal(
	                {
	                    title: 'Done!',
	                    text: data['fullname']+' client updated!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				$('#fullname').val(data['fullname']);
				$('#phone').val(data['phone']);
				$('#email').val(data['email']);
				$('#dob').val(data['dob']);
				$('#occupation').val(data['occupation']);
				$('#sc_id').val(data['sc_id']);
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Settings
	$('#settingsForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#settingsForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#settingsFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#settingsFormBtn').html('Save Settings').removeAttr("disabled");
				swal(
	                {
	                    title: 'Saved!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
	            $('#system_title').val(data['title']);	            
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Services
	$('#serviceForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#serviceForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#serviceFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#serviceFormBtn').html('Add Service').removeAttr("disabled");
				$('#addservice').modal('hide');
				$('#serviceForm')[0].reset();
				swal(
	                {
	                    title: 'Done!',
	                    text: data['service_name']+' service added!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				location.reload();
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Update Service
	$('#serviceFormUpdate').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#serviceFormUpdate')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#serviceFormBtnUpdate').html('<img src="/img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#serviceFormBtnUpdate').html('Update Service').removeAttr("disabled");
				swal(
	                {
	                    title: 'Done!',
	                    text: data['service_name']+' service updated!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				$('#service_name').val(data['service_name']);
				$('#labor_s').val(data['labor_s']);
				$('#labor_p').val(data['labor_p']);
				$('#charge').val(data['charge']);
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Rooms
	$('#roomsForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#roomsForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#roomsFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#roomsFormBtn').html('Add Room').removeAttr("disabled");
				$('#addroom').modal('hide');
				$('#roomsForm')[0].reset();
				swal(
	                {
	                    title: 'Done!',
	                    text: data['room_name']+' room added!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				location.reload();
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Update Rooms
	$('#roomsFormUpdate').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#roomsFormUpdate')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#roomsFormBtnUpdate').html('<img src="/img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#roomsFormBtnUpdate').html('Update Room').removeAttr("disabled");
				swal(
	                {
	                    title: 'Done!',
	                    text: data['room_name']+' room updated!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				$('#room_name').val(data['room_name']);
				$('#status').val(data['status']);
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Package
	$('#package_services').on('change', function(e){

		var package_services = $(this).val();

		if(package_services != '') {

		$('#package_servicec_btn').removeAttr('disabled');

		} else {

		$('#package_servicec_btn').attr('disabled');
		$('#package_inclusion tbody').empty();
		$('#package_total').empty();
		$('#package_total').html('₱0.00');

		}

	});

	$('#package_servicec_btn').on('click', function(e) {

		e.preventDefault();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var services = $('#package_services').val();

		$('#service').val(services);

		$.ajax({
			type: 'post',
			dataType: 'json',
			url: baseurl + 'package/ajaxService',
			data: {'id':services},
			success: function(data) {
				$('#package_inclusion tbody').empty();
				var total = 0;
				for(var i=0; i<data.length;i++){
					$('#package_inclusion tbody').append('<tr><td>'+data[i].id+'</td><td>'+data[i].service_name+'</td><td>'+data[i].labor_s+'</td><td>'+data[i].charge+'</td></tr>');
					total += Number(data[i].charge);
				}
				$('#package_total').empty();
				$('#package_total').html('₱'+total+'.00');
			}
		});
	});

	$('#addPackageForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#addPackageForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#addPackageFormBtn').html('<img src="../img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#addPackageFormBtn').html('Add Package').removeAttr("disabled");
				$('#addPackageForm')[0].reset();
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//GC
	$('#gcForm').on('submit', function(e) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();
		var formData = new FormData($('#gcForm')[0]);
		var url = $(this).attr('action');
		var post = $(this).attr('method');

		$.ajax({
			type: post,
			url: url,
			async: true,
			data: formData,
			beforeSend:function() {
				$('#gcFormBtn').html('<img src="/img/ajax-loader.gif">').attr("disabled","disabled");
			},
			success:function(data) {
				$('#gcFormBtn').html('Add Gift Certificate').removeAttr("disabled");
				$('#addgc').modal('hide');
				$('#gcForm')[0].reset();
				swal(
	                {
	                    title: 'Done!',
	                    text: 'GC no #'+data['room_name']+' added!',
	                    type: 'success',
	                    confirmButtonClass: 'btn btn-confirm mt-2'
	                }
	            );
				location.reload();
			},
			error: function(xhr, status, error) {
				console.log(xhr);
				console.log(status);
				console.log(error);
			},
			cache: false,
			contentType: false,
			processData: false
		});

	});

	//Job Order Front
	$('input[type=radio][name=category]').on('click', function() {
		var category = $('input[type=radio][name=category]:checked').val();

		if(category == 'Single') {

			$('#Service').show();
			$('#Service select').attr('name', 'service');
			$('#Package').hide();
			$('#Package select').removeAttr('name');

		} else if(category == 'Package') {

			$('#Service').hide();
			$('#Service select').removeAttr('name');
			$('#Package').show();
			$('#Package select').attr('name', 'service');

		} else {

			$('#Service').hide();
			$('#Package').hide();
			$('#Service select').removeAttr('name');
			$('#Package select').removeAttr('name');

		}
	});

	$('input[type=radio][name=payment]').on('click', function() {
		var payment = $('input[type=radio][name=payment]:checked').val();

		if(payment == 'Care of') {
			$('#careof').show();
			$('#gc_no').hide();
			$('.gc_checker').empty();
			$('.gc_checker').html('Gift Cert');
		} else if(payment == 'Gift Cert') {
			$('#gc_no').show();
			$('#careof').hide();
		} else {
			$('#careof').hide();
			$('#gc_no').hide();
			$('.gc_checker').empty();
			$('.gc_checker').html('Gift Cert');
		}
	});

	function ifValid(data) {
		if(data) {
			$('#jobOrderFormBtn').removeAttr('disabled');
		} else {
			$('#jobOrderFormBtn').attr('disabled', 'disabled');
		}		
	}

	function checkgc(gc){

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			type: 'POST',
			url: baseurl + '/gc/checker',
			data: {'gc_no':gc},
			success:function(data) {
				if(data) {
					$('.gc_checker').empty();
					$('.gc_checker').html('Gift Cert <i class="text-success mdi mdi-check-circle"></i>');
					$('#gc_no').addClass('validuser');
					ifValid(data);
				} else {
					$('.gc_checker').empty();
					$('.gc_checker').html('Gift Cert <i class="text-danger mdi mdi-close-circle"></i>');
					$('#gc_no').removeClass('validuser');
					ifValid()
				}
			}
		});
	}

	$('#gc_no').on('blur keyup change click', function() {
		var gc = $('#gc_no').val();
		checkgc(gc);
	});


});