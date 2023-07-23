@extends('layout.main') @section('content')
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Add Cost Breakdown</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'cost_breakdowns.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Account Of *</label>
                                            <select name="account_of" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select account of...">
                                                <option value="1">Winking</option>
                                                <option value="2">Artisan</option>
                                            </select>
                                            @if($errors->has('account_of'))
                                                <span class="text-danger">
                                                   {{ $errors->first('account_of') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Season *</label>
                                            <input type="text" name="season" class="form-control" placeholder="Enter Season" required>
                                            @if($errors->has('season'))
                                                <span class="text-danger">
                                                   {{ $errors->first('season') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer *</label>
                                            <select name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Customer">
                                                @foreach ($lims_customer_all as $customer)
                                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('customer_id'))
                                                <span class="text-danger">
                                                   {{ $errors->first('customer_id') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vendor *</label>
                                            <select required name="vendor_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select vendor ..." required>
                                                @foreach ($lims_vendor_all as $vendor)
                                                    <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('vendor_id'))
                                                <span class="text-danger">
                                                    {{ $errors->first('vendor_id') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>LC/Contract Number *</label>
                                            <input type="text" name="lc_number" class="form-control" placeholder="Enter LC/Contract Number " required>
                                            @if($errors->has('lc_number'))
                                                <span class="text-danger">
                                                    {{ $errors->first('lc_number') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Order Quantity *</label>
                                            <input type="text" name="order_qty" min="0" id="order_qty" placeholder="Enter Order Quantity"  class="form-control" required>
                                            @if($errors->has('order_qty'))
                                                <span class="text-danger">
                                                    {{ $errors->first('order_qty') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Order Value (Customer) *</label>
                                            <input type="text" name="order_value_customer" id="order_value_customer" class="form-control" placeholder="Enter Order Value (Customer)" required>
                                            @if($errors->has('order_value_customer'))
                                                <span class="text-danger">
                                                    {{ $errors->first('order_value_customer') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Order Value (Vendor) *</label>
                                            <input type="text" name="order_value_vendor" id="order_value_vendor" class="form-control" placeholder="Enter Order Value (Vendor)" required>
                                            @if($errors->has('order_value_vendor'))
                                                <span class="text-danger">
                                                    {{ $errors->first('order_value_vendor') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Order Status *</label>
                                            <select name="status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select status...">
                                                <option value="Running">Running</option>
                                                <option value="Delivered">Delivered</option>
                                                <option value="Cancelled/Hold">Cancelled/Hold</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <span class="text-danger">
                                                   {{ $errors->first('status') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Delivery Date *</label>
                                            <input type="text" name="delivery_date" class="datepicker form-control"
                                            placeholder="Enter Delivery Date " required>
                                            @if($errors->has('delivery_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('delivery_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upload Cost Breakdown *</label>
                                            <input type="file" name="document" class="form-control"/>
                                            @if($errors->has('document'))
                                                <span class="text-danger">
                                                   {{ $errors->first('document') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary" id="submit-btn">{{trans('file.submit')}}</button>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #cost-breakdown-menu").addClass("active");
</script>
@endsection
