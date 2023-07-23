@extends('layout.main')
@section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>{{trans('file.Group Permission')}}</h4>
                    </div>
                    {!! Form::open(['route' => 'role.setPermission', 'method' => 'post']) !!}
                    <div class="card-body">
                    	<input type="hidden" name="role_id" value="{{$lims_role_data->id}}" />
						<div class="table-responsive">
						    <table class="table table-bordered permission-table">
						        <thead>
						        <tr>
						            <th colspan="5" class="text-center">{{$lims_role_data->name}} {{trans('file.Group Permission')}}</th>
						        </tr>
						        <tr>
						            <th rowspan="2" class="text-center">Module Name</th>
						            <th colspan="4" class="text-center">
						            	<div class="checkbox">
						            		<input type="checkbox" id="select_all">
						            		<label for="select_all">{{trans('file.Permissions')}}</label>
						            	</div>
						            </th>
						        </tr>
						        <tr>
						            <th class="text-center">{{trans('file.View')}}</th>
						            <th class="text-center">{{trans('file.add')}}</th>
						            <th class="text-center">{{trans('file.edit')}}</th>
						            <th class="text-center">{{trans('file.delete')}}</th>
						        </tr>
						        </thead>
						        <tbody>
						        
						        <tr>
						            <td>{{trans('Purchase Contract')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("purchase-contract-index", $all_permission))
								                <input type="checkbox" value="1" id="purchase-contract-index" name="purchase-contract-index" checked>
								                @else
								                <input type="checkbox" value="1" id="purchase-contract-index" name="purchase-contract-index">
								                @endif
								                <label for="purchase-contract-index"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("purchase-contract-add", $all_permission))
								                <input type="checkbox" value="1" id="purchase-contract-add" name="purchase-contract-add" checked>
								                @else
								                <input type="checkbox" value="1" id="purchase-contract-add" name="purchase-contract-add">
								                @endif
								                <label for="purchase-contract-add"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("purchase-contract-edit", $all_permission))
								                <input type="checkbox" value="1" id="purchase-contract-edit" name="purchase-contract-edit" checked />
								                @else
								                <input type="checkbox" value="1" id="purchase-contract-edit" name="purchase-contract-edit">
								                @endif
								                <label for="purchase-contract-edit"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("purchase-contract-delete", $all_permission))
								                <input type="checkbox" value="1" id="purchase-contract-delete" name="purchase-contract-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="purchase-contract-delete" name="purchase-contract-delete">
								                @endif
								                <label for="purchase-contract-delete"></label>
							            	</div>
						            	</div>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>{{trans('Cost Sheet')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-sheet-index", $all_permission))
								                <input type="checkbox" value="1" id="cost-sheet-index" name="cost-sheet-index" checked>
								                @else
								                <input type="checkbox" value="1" id="cost-sheet-index" name="cost-sheet-index">
								                @endif
								                <label for="cost-sheet-index"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-sheet-add", $all_permission))
								                <input type="checkbox" value="1" id="cost-sheet-add" name="cost-sheet-add" checked>
								                @else
								                <input type="checkbox" value="1" id="cost-sheet-add" name="cost-sheet-add">
								                @endif
								                <label for="cost-sheet-add"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-sheet-edit", $all_permission))
								                <input type="checkbox" value="1" id="cost-sheet-edit" name="cost-sheet-edit" checked />
								                @else
								                <input type="checkbox" value="1" id="cost-sheet-edit" name="cost-sheet-edit">
								                @endif
								                <label for="cost-sheet-edit"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-sheet-delete", $all_permission))
								                <input type="checkbox" value="1" id="cost-sheet-delete" name="cost-sheet-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="cost-sheet-delete" name="cost-sheet-delete">
								                @endif
								                <label for="cost-sheet-delete"></label>
							            	</div>
						            	</div>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>{{trans('PO')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("po-index", $all_permission))
								                <input type="checkbox" value="1" id="po-index" name="po-index" checked>
								                @else
								                <input type="checkbox" value="1" id="po-index" name="po-index">
								                @endif
								                <label for="po-index"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("po-add", $all_permission))
								                <input type="checkbox" value="1" id="po-add" name="po-add" checked>
								                @else
								                <input type="checkbox" value="1" id="po-add" name="po-add">
								                @endif
								                <label for="po-add"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("po-edit", $all_permission))
								                <input type="checkbox" value="1" id="po-edit" name="po-edit" checked />
								                @else
								                <input type="checkbox" value="1" id="po-edit" name="po-edit">
								                @endif
								                <label for="po-edit"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("po-delete", $all_permission))
								                <input type="checkbox" value="1" id="po-delete" name="po-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="po-delete" name="po-delete">
								                @endif
								                <label for="po-delete"></label>
							            	</div>
						            	</div>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>{{trans('Cost Breakdown')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-breakdown-index", $all_permission))
								                <input type="checkbox" value="1" id="cost-breakdown-index" name="cost-breakdown-index" checked>
								                @else
								                <input type="checkbox" value="1" id="cost-breakdown-index" name="cost-breakdown-index">
								                @endif
								                <label for="cost-breakdown-index"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-breakdown-add", $all_permission))
								                <input type="checkbox" value="1" id="cost-breakdown-add" name="cost-breakdown-add" checked>
								                @else
								                <input type="checkbox" value="1" id="cost-breakdown-add" name="cost-breakdown-add">
								                @endif
								                <label for="cost-breakdown-add"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-breakdown-edit", $all_permission))
								                <input type="checkbox" value="1" id="cost-breakdown-edit" name="cost-breakdown-edit" checked />
								                @else
								                <input type="checkbox" value="1" id="cost-breakdown-edit" name="cost-breakdown-edit">
								                @endif
								                <label for="cost-breakdown-edit"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("cost-breakdown-delete", $all_permission))
								                <input type="checkbox" value="1" id="cost-breakdown" name="cost-breakdown-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="cost-breakdown-delete" name="cost-breakdown-delete">
								                @endif
								                <label for="cost-breakdown-delete"></label>
							            	</div>
						            	</div>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>{{trans('Proforma Invoice')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("proforma-invoice-index", $all_permission))
								                <input type="checkbox" value="1" id="proforma-invoice-index" name="proforma-invoice-index" checked>
								                @else
								                <input type="checkbox" value="1" id="proforma-invoice-index" name="proforma-invoice-index">
								                @endif
								                <label for="proforma-invoice-index"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("proforma-invoice-add", $all_permission))
								                <input type="checkbox" value="1" id="proforma-invoice-add" name="proforma-invoice-add" checked>
								                @else
								                <input type="checkbox" value="1" id="proforma-invoice-add" name="proforma-invoice-add">
								                @endif
								                <label for="proforma-invoice-add"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("proforma-invoice-edit", $all_permission))
								                <input type="checkbox" value="1" id="proforma-invoice-edit" name="proforma-invoice-edit" checked />
								                @else
								                <input type="checkbox" value="1" id="proforma-invoice-edit" name="proforma-invoice-edit">
								                @endif
								                <label for="proforma-invoice-edit"></label>
							                </div>
							            </div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("proforma-invoice-delete", $all_permission))
								                <input type="checkbox" value="1" id="proforma-invoice-delete" name="proforma-invoice-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="proforma-invoice-delete" name="proforma-invoice-delete">
								                @endif
								                <label for="proforma-invoice-delete"></label>
							            	</div>
						            	</div>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>{{trans('file.Expense')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("expenses-index", $all_permission))
								                <input type="checkbox" value="1" id="expenses-index" name="expenses-index" checked />
								                @else
								                <input type="checkbox" value="1" id="expenses-index" name="expenses-index">
								                @endif
								                <label for="expenses-index"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("expenses-add", $all_permission))
								                <input type="checkbox" value="1" id="expenses-add" name="expenses-add" checked />
								                @else
								                <input type="checkbox" value="1" id="expenses-add" name="expenses-add">
								                @endif
								                <label for="expenses-add"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("expenses-edit", $all_permission))
								                <input type="checkbox" value="1" id="expenses-edit" name="expenses-edit" checked>
								                @else
								                <input type="checkbox" value="1" id="expenses-edit" name="expenses-edit">
								                @endif
								                <label for="expenses-edit"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("expenses-delete", $all_permission))
								                <input type="checkbox" value="1" id="expenses-delete" name="expenses-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="expenses-delete" name="expenses-delete">
								                @endif
								                <label for="expenses-delete"></label>
								            </div>
						            	</div>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>{{trans('Export')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("export-index", $all_permission))
								                <input type="checkbox" value="1" id="export-index" name="export-index" checked />
								                @else
								                <input type="checkbox" value="1" id="export-index" name="export-index">
								                @endif
								                <label for="export-index"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("export-add", $all_permission))
								                <input type="checkbox" value="1" id="export-add" name="export-add" checked />
								                @else
								                <input type="checkbox" value="1" id="export-add" name="export-add">
								                @endif
								                <label for="export-add"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("export-edit", $all_permission))
								                <input type="checkbox" value="1" id="export-edit" name="export-edit" checked>
								                @else
								                <input type="checkbox" value="1" id="export-edit" name="export-edit">
								                @endif
								                <label for="export-edit"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("export-delete", $all_permission))
								                <input type="checkbox" value="1" id="export-delete" name="export-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="export-delete" name="export-delete">
								                @endif
								                <label for="export-delete"></label>
								            </div>
						            	</div>
						            </td>
						        </tr>

						        <tr>
						            <td>{{trans('file.Employee')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("employees-index", $all_permission))
								                <input type="checkbox" value="1" id="employees-index" name="employees-index" checked>
								                @else
								                <input type="checkbox" value="1" id="employees-index" name="employees-index">
								                @endif
								                <label for="employees-index"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("employees-add", $all_permission))
								                <input type="checkbox" value="1" id="employees-add" name="employees-add" checked>
								                @else
								                <input type="checkbox" value="1" id="employees-add" name="employees-add">
								                @endif
								                <label for="employees-add"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("employees-edit", $all_permission))
								                <input type="checkbox" value="1" id="employees-edit" name="employees-edit" checked>
								                @else
								                <input type="checkbox" value="1" id="employees-edit" name="employees-edit">
								                @endif
								                <label for="employees-edit"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("employees-delete", $all_permission))
								                <input type="checkbox" value="1" id="employees-delete" name="employees-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="employees-delete" name="employees-delete">
								                @endif
								                <label for="employees-delete"></label>
								            </div>
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td>{{trans('file.User')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("users-index", $all_permission))
								                <input type="checkbox" value="1" id="users-index" name="users-index" checked>
								                @else
								                <input type="checkbox" value="1" id="users-index" name="users-index">
								                @endif
								                <label for="users-index"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("users-add", $all_permission))
								                <input type="checkbox" value="1" id="users-add" name="users-add" checked>
								                @else
								                <input type="checkbox" value="1" id="users-add" name="users-add">
								                @endif
								                <label for="users-add"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("users-edit", $all_permission))
								                <input type="checkbox" value="1" id="users-edit" name="users-edit" checked>
								                @else
								                <input type="checkbox" value="1" id="users-edit" name="users-edit">
								                @endif
								                <label for="users-edit"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("users-delete", $all_permission))
								                <input type="checkbox" value="1" id="users-delete" name="users-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="users-delete" name="users-delete">
								                @endif
								                <label for="users-delete"></label>
								            </div>
						            	</div>
						            </td>
						        </tr>
						        <tr>
						            <td>{{trans('file.customer')}}</td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("customers-index", $all_permission))
								                <input type="checkbox" value="1" id="customers-index" name="customers-index" checked>
								                @else
								                <input type="checkbox" value="1" id="customers-index" name="customers-index">
								                @endif
								                <label for="customers-index"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("customers-add", $all_permission))
								                <input type="checkbox" value="1" id="customers-add" name="customers-add" checked>
								                @else
								                <input type="checkbox" value="1" id="customers-add" name="customers-add">
								                @endif
								                <label for="customers-add"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue checked" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("customers-edit", $all_permission))
								                <input type="checkbox" value="1" id="customers-edit" name="customers-edit" checked>
								                @else
								                <input type="checkbox" value="1" id="customers-edit" name="customers-edit">
								                @endif
								                <label for="customers-edit"></label>
								            </div>
						            	</div>
						            </td>
						            <td class="text-center">
						                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false">
							                <div class="checkbox">
								                @if(in_array("customers-delete", $all_permission))
								                <input type="checkbox" value="1" id="customers-delete" name="customers-delete" checked>
								                @else
								                <input type="checkbox" value="1" id="customers-delete" name="customers-delete">
								                @endif
								                <label for="customers-delete"></label>
								            </div>
						            	</div>
						            </td>
						        </tr>


						        <tr>
						            <td>{{trans('file.Accounting')}}</td>
						            <td class="report-permissions" colspan="5">
						            	<span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("account-index", $all_permission))
							                    	<input type="checkbox" value="1" id="account-index" name="account-index" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="account-index" name="account-index">
							                    	@endif
								                    <label for="account-index" class="padding05">{{trans('file.Account')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("money-transfer", $all_permission))
							                    	<input type="checkbox" value="1" id="money-transfer" name="money-transfer" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="money-transfer" name="money-transfer">
							                    	@endif
								                    <label for="money-transfer" class="padding05">{{trans('file.Money Transfer')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("balance-sheet", $all_permission))
							                    	<input type="checkbox" value="1" id="balance-sheet" name="balance-sheet" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="balance-sheet" name="balance-sheet">
							                    	@endif
								                    <label for="balance-sheet" class="padding05">{{trans('file.Balance Sheet')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
						                    	<div class="checkbox">
							                    	@if(in_array("account-statement", $all_permission))
							                    	<input type="checkbox" value="1" id="account-statement-permission" name="account-statement" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="account-statement-permission" name="account-statement">
							                    	@endif
								                    <label for="account-statement-permission" class="padding05">{{trans('file.Account Statement')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
						                    	<div class="checkbox">
							                    	@if(in_array("account-deposit", $all_permission))
							                    	<input type="checkbox" value="1" id="account-deposit-permission" name="account-deposit" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="account-deposit-permission" name="account-deposit">
							                    	@endif
								                    <label for="account-deposit-permission" class="padding05">{{trans('Account Deposit')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
						                    	<div class="checkbox">
							                    	@if(in_array("account-withdraw", $all_permission))
							                    	<input type="checkbox" value="1" id="account-withdraw-permission" name="account-withdraw" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="account-withdraw-permission" name="account-withdraw">
							                    	@endif
								                    <label for="account-withdraw-permission" class="padding05">{{trans('Account Withdraw')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						            </td>
						        </tr>
						        
						        
						        <tr>
						            <td>HRM</td>
						            <td class="report-permissions" colspan="5">
						            	<span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("department", $all_permission))
							                    	<input type="checkbox" value="1" id="department" name="department" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="department" name="department">
							                    	@endif
								                    <label for="department" class="padding05">{{trans('file.Department')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("attendance", $all_permission))
							                    	<input type="checkbox" value="1" id="attendance" name="attendance" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="attendance" name="attendance">
							                    	@endif
								                    <label for="attendance" class="padding05">{{trans('file.Attendance')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("payroll", $all_permission))
							                    	<input type="checkbox" value="1" id="payroll" name="payroll" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="payroll" name="payroll">
							                    	@endif
								                    <label for="payroll" class="padding05">{{trans('file.Payroll')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						            </td>
						        </tr>
						        
						        <tr>
						            <td>Income</td>
						            <td class="report-permissions" colspan="5">
						            	<span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("income-source", $all_permission))
							                    	<input type="checkbox" value="1" id="income-source" name="income-source" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="income-source" name="income-source">
							                    	@endif
								                    <label for="income-source" class="padding05">{{trans('Income Source')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("income-list", $all_permission))
							                    	<input type="checkbox" value="1" id="income-list" name="income-list" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="income-list" name="income-list">
							                    	@endif
								                    <label for="income-list" class="padding05">{{trans('Income List')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                
						            </td>
						        </tr>
						        
						        <tr>
						            <td>Trimming Item</td>
						            <td class="report-permissions" colspan="5">
						            	<span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("trimming-index", $all_permission))
							                    	<input type="checkbox" value="1" id="trimming-index" name="trimming-index" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="trimming-index" name="trimming-index">
							                    	@endif
								                    <label for="trimming-index" class="padding05">{{trans('Trimming')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						            </td>
						        </tr>
						        
						  
						        <tr>
						            <td>{{trans('file.settings')}}</td>
						            <td class="report-permissions" colspan="5">
						            	
                                        <span>
								            <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("interest", $all_permission))
							                    	<input type="checkbox" value="1" id="interest" name="interest" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="interest" name="interest">
							                    	@endif
								                    <label for="interest" class="padding05">Interest &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                
						            	<span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("general_setting", $all_permission))
							                    	<input type="checkbox" value="1" id="general_setting" name="general_setting" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="general_setting" name="general_setting">
							                    	@endif
								                    <label for="general_setting" class="padding05">{{trans('file.General Setting')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                
						                <span>
						                    <div aria-checked="false" aria-disabled="false">
								                <div class="checkbox">
							                    	@if(in_array("uesr-profile", $all_permission))
							                    	<input type="checkbox" value="1" id="uesr-profile" name="uesr-profile" checked>
							                    	@else
							                    	<input type="checkbox" value="1" id="uesr-profile" name="uesr-profile">
							                    	@endif
								                    <label for="uesr-profile" class="padding05">{{trans('User Profile')}} &nbsp;&nbsp;</label>
								                </div>
								            </div>
						                </span>
						                
						            </td>
						        </tr>
						        </tbody>
						    </table>
						</div>
						<div class="form-group">
	                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
	                    </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">

	$("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting #role-menu").addClass("active");

	$("#select_all").on( "change", function() {
	    if ($(this).is(':checked')) {
	        $("tbody input[type='checkbox']").prop('checked', true);
	    }
	    else {
	        $("tbody input[type='checkbox']").prop('checked', false);
	    }
	});
</script>
@endsection
