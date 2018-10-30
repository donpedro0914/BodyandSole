<div id="addTherapist" class="modal fade" aria-labelledby="addTherapist">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Therapist</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            </div>
            <div class="modal-body">
                <form id="therapistForm" action="{{ URL::to('therapist/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12 col-xs-12">
                            <label>Full Name</label>
                            <input type="text" class="form-control" name="fullname" placeholder="Enter full name.."/>
                        </div>
                        <div class="form-group col-md-12 col-xs-12">
                            <label>Address</label>
                            <input type="text" class="form-control" name="address" placeholder="Enter address.." />
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label>Phone</label>
                            <input type="text" class="form-control" name="phone" placeholder="Enter valid phone number.."/>
                        </div>
                        <div class="form-group col-md-6 col-xs-12">
                            <label>Date of Birth</label>
                            <input type="text" class="form-control" name="dob" placeholder="mm/dd/yyyy" id="datepicker-autoclose">
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Hired</label>
                            <input type="text" class="form-control" name="hired" placeholder="mm/dd/yyyy" id="hired_date">
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Resigned</label>
                            <input type="text" class="form-control" name="resigned" placeholder="mm/dd/yyyy" id="resigned_date">
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>PIN</label>
                            <input type="password" class="form-control" name="pin">
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Basic Pay</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="basic" id="basic"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Lodging</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="lodging" id="lodging"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Allowance</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="allowance" id="allowance"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-xs-12">
                            <h4 class="header-title">Deductions</h4>
                            <hr />
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>S.S.S</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="sss" id="sss"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Phil Health</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="phealth" id="phealth"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>H.D.F</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="hdf" id="hdf"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Uniform</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="uniform" id="uniform"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Fare</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="fare" id="fare"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4 col-xs-12">
                            <label>Others</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>₱</span>
                                </div>
                                <input type="text" class="form-control" name="others" id="others"/>
                                <div class="input-group-prepend">
                                    <span class='input-group-text'>.00</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12 col-xs-12">
                            <div class="clearfix text-right mt-3">
                                <button type="submit" id="therapistFormBtn" class="btn btn-success">
                                    Add Therapist
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>