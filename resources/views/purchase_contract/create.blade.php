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
                        <h4>Add Purchase Contract</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'purchase_contract.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row" style="margin-bottom:30px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Purchase Contract No *</label>
                                            <input type="text" name="contract_no" class="form-control" placeholder="Enter Purchase Contract No" required>
                                            @if($errors->has('contract_no'))
                                                <span class="text-danger">
                                                    {{ $errors->first('contract_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Master Purchase Contract No *</label>
                                            <input type="text" name="master_contract_no" class="form-control" placeholder="Enter Master Purchase Contract No" required>
                                            @if($errors->has('master_contract_no'))
                                                <span class="text-danger">
                                                    {{ $errors->first('master_contract_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Vendor Contract Date *</label>
                                            <input type="text" name="vendor_date" class="datepicker form-control" placeholder="Enter Vendor Contract Date" required>
                                            @if($errors->has('vendor_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('vendor_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Master Contract Date *</label>
                                            <input type="text" name="master_date" class="datepicker form-control" placeholder="Enter Master Contract Date" required>
                                            @if($errors->has('master_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('master_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Vendor *</label>
                                            <select required name="vendor_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select vendor or shipper..." required>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Customer *</label>
                                            <select name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Customer..." required>
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

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Account Of *</label>
                                            <select name="account_of" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select account of..." required>
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
                                            <label>Vendor Delivery Date *</label>
                                            <input type="text" name="delivery_date" class="datepicker form-control" placeholder="Enter Vendor Delivery Date" required>
                                            @if($errors->has('delivery_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('delivery_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Consignee & Notify Party *</label>
                                            <select name="notify_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Consignee & Notify Party..." required>
                                                @foreach ($notify_all as $notify)
                                                    <option value="{{ $notify->id }}">{{ $notify->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('notify_id'))
                                                <span class="text-danger">
                                                    {{ $errors->first('notify_id') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Quantity *</label>
                                            <input type="number" name="total_qty" id="total_qty" placeholder="Please enter total quantity ..." class="form-control total_qty" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Master Delivery Date *</label>
                                            <input type="text" name="delivery_date_master" class="datepicker form-control" placeholder="Enter Master Delivery Date"  required>
                                            @if($errors->has('delivery_date_master'))
                                                <span class="text-danger">
                                                   {{ $errors->first('delivery_date_master') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Amount (Vendor)*</label>
                                            <input type="number" name="total_amount" id="total_amount" placeholder="Please enter total amount for vendor ..." class="form-control total_amount" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Amount (Master)*</label>
                                            <input type="number" name="total_amount_master" id="total_amount" placeholder="Please enter total amount for master contract ..." class="form-control total_amount" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upload Mastract Contract *</label>
                                            <input type="file" name="master_doc" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Upload Purchase Contract *</label>
                                            <input type="file" name="contract_doc" class="form-control"/>
                                        </div>
                                    </div>
                                </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" id="submit-btn">{{trans('file.submit')}}</button>
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
    $("ul#order-summary #purchase-contract-menu").addClass("active");


    $(document).ready(function(){
        var max_field = 20;
        var wrapper = $("#dynamicSection");
        var x = 1;
        $("#add_description").click(function(){
            if(x < max_field){
                x++;
                $(wrapper).append('<tr>\
                                    <td width="12%"><input type="text" name="vpo[]" class="form-control" required></td>\
                                    <td width="13%"><input type="text" name="style[]" class="form-control"></td>\
                                    <td width="30%"><input type="text" name="item_description[]" class="form-control"></td>\
                                    <td width="10%"><input type="text" name="color[]" class="form-control"></td>\
                                    <td width="10%"><input type="number" name="quantity[]" id="quantity" min="0" step="any" class="form-control quantity" required></td>\
                                    <td width="12%"><input type="number" name="unit_price[]" id="unit_price" min="0" step="0.01" class="form-control unit_price" required></td>\
                                    <td width="12%"><input type="text" name="total_value[]" id="total_value" class="form-control total_value" readonly required></td>\
                                    <td><a id="remove" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a></td>\
                                </tr>');
            }else{
                alert('you can not add more than 20 field');
            }
        });

        $(document).on('click', '#remove', function(){
             $(this).parents('tr').remove();
                var sum = 0;
                var totqty = 0;
                $(".total_value").each(function(){
                    sum += +$(this).val();
                });
                $(".quantity").each(function(){
                    totqty += +$(this).val();
                });
                $("#total_qty").val(totqty);
                $("#total_amount").val(parseFloat(sum).toFixed(2));
        });
    });
$(document).ready(function () {

    $(document).on('keyup change', '#quantity, #unit_price', function() {
        var quantity = $(this).closest('tr').find('.quantity').val();
        var unit_price = $(this).closest('tr').find('.unit_price').val();
        var subtotal = parseFloat(quantity * unit_price).toFixed(2);
        $(this).closest('tr').find('.total_value').val(subtotal);
    });


    $(document).on("change keyup", "#unit_price , #quantity", function() {
        var sum = 0;
        var totqty = 0;
        $(".total_value").each(function(){
            sum += +$(this).val();
        });
        $(".quantity").each(function(){
            totqty += +$(this).val();
        });
        $("#total_qty").val(totqty);
        $("#total_amount").val(parseFloat(sum).toFixed(2));
    });
});

tinymce.init({
    selector: 'textarea',
    height: 130,
    plugins: [
    'advlist autolink lists link image charmap print preview anchor textcolor',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime media table contextmenu paste code wordcount'
    ],
    toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
    branding:false
});
</script>
@endsection
