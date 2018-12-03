<div id="addf_expenses" class="modal fade" aria-labelledby="addGC">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Add Petty Expense</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
			</div>
			<div class="modal-body">
				<form id="f_expenseForm" action="{{ URL::to('f_expense/store') }}" method="post">
					@csrf
					@php
						$expenseCount = $expenseCount + 1;
						$expenseCount = sprintf("%05d", $expenseCount);
					@endphp
					<div class="form-row">
						<div class="form-group col-md-12 col-xs-12">
							<label>Reference No.</label>
							<input type="text" name="ref_no" class="form-control" value="{!! $expenseCount !!}" readonly="" />
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Date</label>
							<div class="col-sm-12">
								<div class="input-group m-b-30">
                                <input type="text" class="form-control" placeholder="mm/dd/yyyy" name="date" id="datepicker-autoclose" value="{!! date('Y-m-d') !!}">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="mdi mdi-calendar"></i>
                                    </span>
                                </div>
                            </div>
							</div>
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Payee Name</label>
							<input type="text" name="therapist" class="form-control" />
						</div>
						<div class="form-group col-md-12 col-xs-12">
							<label>Category</label>
							<select name="category" class="form-control">
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
							<label>Particulars</label>
							<input type="text" name="particulars" class="form-control" />
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
								<button type="submit" id="f_expenseBtn" class="btn btn-success">
									Add Expense
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>