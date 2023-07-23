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
                                            <input type="text" name="contract_no" class="form-control" required>
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
                                            <input type="text" name="master_contract_no" class="form-control" required>
                                            @if($errors->has('master_contract_no'))
                                                <span class="text-danger">
                                                    {{ $errors->first('master_contract_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Consignee & Notify Party *</label>
                                            <select name="invoice_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select notify party..." required>
                                                @foreach ($lims_invoice_to_all as $invoice)
                                                    <option value="{{ $invoice->id }}">{{ $invoice->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('invoice_to'))
                                                <span class="text-danger">
                                                    {{ $errors->first('invoice_to') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Season *</label>
                                            <input type="text" name="season" class="form-control" placeholder="Please enter season ..." required>
                                            @if($errors->has('season'))
                                                <span class="text-danger">
                                                   {{ $errors->first('season') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Revised Date *</label>
                                            <input type="date" name="revised_date" class="form-control">
                                            @if($errors->has('revised_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('revised_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Delivery Date *</label>
                                            <input type="date" name="delivery_date" class="form-control" required>
                                            @if($errors->has('delivery_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('delivery_date') }}
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
