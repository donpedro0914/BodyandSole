$(document).ready(function() {

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

	//Add Job Order
	$('.room').on('click', function() {
		$('#joborder').modal('show');
		var room_id = $(this).find('#room_no').val();

		$('#room_no_form').val(room_id);
	})

	//Add Therapist
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
				$('#settingsForm')[0].reset();
				swal(
	                {
	                    title: 'Saved!',
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

});