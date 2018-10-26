<div id="addf_expenses" class="modal fade" aria-labelledby="addGC">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Petty Expense</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="f_gcForm" action="{{ URL::to('f_gc/store') }}" method="post">
					@csrf
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Therapist</label>
							<select name="purchased_by" class="form-control select2 select2-selection__rendered">
								<option value="">--Select Therapist--</option>
								@foreach($therapist as $t)
								<option value="{{ $t->id }}">{{ $t->fullname }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Category</label>
							<select name="service" class="form-control">
								<option>--Select Category--</option>
								<option value="Salary-wages">Salary-wages</option>
								<option value="Food Allowance">Food Allowance</option>
								<option value="Allowance">Allowance</option>
								<option value="Spa Supplies">Spa Supplies</option>
								<option value="Office Supplies">Office Supplies</option>
								<option value="BIR Permits">BIR Permits</option>
								<option value="Miscellaneous">Miscellaneous</option>
								<optgroup label="Utility">
									<option value="Telephone/Internet Bill">Telephone/Internet Bill</option>
									<option value="Electric Bill">Electric Bill</option>
									<option value="Water Bill">Water Bill</option>
								</optgroup>
								<optgroup label="Maintenance">
									<option value="Repair">Repair</option>
									<option value="Labor">Labor</option>
									<option value="Materials">Materials</option>
								</optgroup>
							</select>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Value</label>
							<div class="input-group">
								<div class="input-group-prepend">
									<span class='input-group-text'>₱</span>
								</div>
								<input type="text" class="form-control" name="value" placeholder="Enter value.."/>
								<div class="input-group-prepend">
									<span class='input-group-text'>.00</span>
								</div>
							</div>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<div class="clearfix text-right mt-3">
								<button type="submit" id="f_gcFormBtn" class="btn btn-success">
									Add Gift Certificate
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>