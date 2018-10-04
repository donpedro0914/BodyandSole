<div id="addroom" class="modal fade" aria-labelledby="addTherapist">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Room</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="roomsForm" action="{{ URL::to('room/add_room') }}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Room Name</label>
							<input type="text" class="form-control" name="room_name" placeholder="Enter room name.."/>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="roomsFormBtn" class="btn btn-success">
									Add Room
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>