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

    $(".select2").select2();

	//Add Job Order
	$('.room').on('click', function() {
		$('#joborder').modal('show');
		var room_id = $(this).find('#room_no').val();

		$('#room_no_form').val(room_id);
	})

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

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		e.preventDefault();

		var services = $('#package_services').val();

		$('#service').val(services);

		$.ajax({
			type: 'POST',
			dataType: 'json',
			url: baseurl + '/package/ajaxService',
			data: {'id':services},
			success: function(data) {
				$('#package_inclusion tbody').empty();
				var total = 0;
				for(var i=0; i<data.length;i++){
					$('#package_inclusion tbody').append('<tr><td>'+data[i].id+'</td><td>'+data[i].service_name+'</td><td>'+data[i].charge+'</td></tr>');
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

	//Job Order Front
	$('input[type=radio][name=category]').on('click', function(e) {
		var category = $('input[type=radio][name=category]:checked').val();

		if(category == 'Service') {

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
});