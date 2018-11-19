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
                        <li class="breadcrumb-item active"><a href="/petty-expense">Petty Expense</a></li>
                        <li class="breadcrumb-item">{{ $expense->ref_no }}</li>
                    </ol>
                    <h4 class="page-title">{{ $expense->ref_no }}</h4>
    			</div>
                <div class="row">
                    <div class="col-12">
                        <div class="card-box">
                            <form action="{{ URL::to('expenses/update', $expense->id) }}" method="post">
                                @csrf
                                <div class="form-row">
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Reference No.</label>
                                        <input type="text" class="form-control" name="ref_no" value="{{ $expense->ref_no}}" />
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Payee Name</label>
                                        <input type="text" class="form-control" name="therapist" value="{{ $expense->therapist}}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <label>Category</label>
                                        @php
                                            $service = array(
                                                'Salary-wages' => 'Salary-wages',
                                                'Food Allowance' => 'Food Allowance',
                                                'Allowance' => 'Allowance',
                                                'Spa Supplies' => 'Spa Supplies',
                                                'Office Supplies' => 'Office Supplies',
                                                'BIR Permits' => 'BIR Permits',
                                                'Miscellaneous' => 'Miscellaneous',
                                                'Telephone/Internet Bill' => 'Telephone/Internet Bill',
                                                'Electric Bill' => 'Electric Bill',
                                                'Water Bill' => 'Water Bill',
                                                'Repair' => 'Repair',
                                                'Labor' => 'Labor',
                                                'Materials' => 'Materials'
                                            );
                                        @endphp
                                        {{ Form::select('category', $service, $expense->category, ['class' => 'form-control select2']) }}
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Value</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>₱</span>
                                            </div>
                                            <input type="text" class="form-control" name="value" value="{{ $expense->value}}"/>
                                            <div class="input-group-prepend">
                                                <span class='input-group-text'>.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 col-xs-12">
                                        <label>Particular</label>
                                        <input type="text" class="form-control" name="particular" value="{{ $expense->particulars}}"/>
                                    </div>
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="clearfix text-right mt-3">
                                            <button type="submit" class="btn btn-success">
                                                Update Expense
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
    		</div>
    	</div>
    </div>
@endsection