<div id="attendance_time" class="modal fade" aria-labelledby="addGC">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Time In / Time Out</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="f_attendanceForm" action="{{ URL::to('f_attendance/store') }}" method="post">
					@csrf
					<input type="hidden" name="day" value="day{{$day}}" />
					<div class="form-row">
						<div class="form-group col-md-6 col-xs-12">
							<label>Name</label>
							<select name="therapist" class="form-control select2 select2-selection__rendered">
								@foreach($alltherapists as $a)
								<option value="{{ $a->fullname }}">{{ $a->fullname }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-6 col-xs-12">
							<label>PIN</label>
							<input type="password" name="pin" class="form-control" />
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="f_attendanceBtn" class="btn btn-success">
									Submit
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>