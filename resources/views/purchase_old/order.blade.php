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
                        <h4>Add Purchase Order</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'purchase_order.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>P.O. Number</label>
                                            <input type="text" name="po_number" class="form-control">
                                            @if($errors->has('po_number'))
                                                <span class="text-danger">
                                                   {{ $errors->first('po_number') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Rivision No</label>
                                            <input type="date" name="rivision_no" class="form-control">
                                            @if($errors->has('rivision_no'))
                                                <span class="text-danger">
                                                   {{ $errors->first('rivision_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Shipper/Vendor *</label>
                                            <select required name="vendor" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select vendor or shipper...">
                                                  @foreach ($lims_vendor_all as $vendor)
                                                      <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                  @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>LC/SC No</label>
                                            <input type="text" name="lc_no" class="form-control" required>
                                            @if($errors->has('lc_no'))
                                                <span class="text-danger">
                                                    {{ $errors->first('lc_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ship To</label>
                                            <select name="ship_to" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select ship to...">
                                                @foreach ($lims_ship_to_all as $ship)
                                                     <option value="{{ $ship->id }}">{{ $ship->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('ship_to'))
                                                <span class="text-danger">
                                                    {{ $errors->first('ship_to') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <label>Invoice To</label>
                                                <select name="invoice_to" class="form-control" data-live-search="true" data-live-search-style="begins" title="Select invoice to..." required>
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
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Season</label>
                                            <input type="text" name="season" class="form-control" required>
                                            @if($errors->has('season'))
                                                <span class="text-danger">
                                                   {{ $errors->first('season') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Order date</label>
                                            <input type="date" name="order_date" class="form-control" required>
                                            @if($errors->has('order_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('order_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Cancel date</label>
                                            <input type="date" name="cancel_date" class="form-control" required>
                                            @if($errors->has('cancel_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('cancel_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Exp ship date</label>
                                            <input type="date" name="ship_exp_date" class="form-control" required>
                                            @if($errors->has('ship_exp_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('ship_exp_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ship Terms</label>
                                            <input type="text" name="ship_terms" class="form-control" required>
                                            @if($errors->has('ship_terms'))
                                                <span class="text-danger">
                                                   {{ $errors->first('ship_terms') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Payment Terms</label>
                                            <input type="text" name="payment_terms" class="form-control" required>
                                            @if($errors->has('payment_terms'))
                                                <span class="text-danger">
                                                   {{ $errors->first('payment_terms') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Fabric Ref</label>
                                            <input type="text" name="febric_ref" class="form-control" required>
                                            @if($errors->has('febric_ref'))
                                                <span class="text-danger">
                                                   {{ $errors->first('febric_ref') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Brand/Label</label>
                                            <input type="text" name="brand" class="form-control">
                                            @if($errors->has('brand'))
                                                <span class="text-danger">
                                                   {{ $errors->first('brand') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Ship Via</label>
                                            <input type="text" name="ship_via" class="form-control">
                                            @if($errors->has('ship_via'))
                                                <span class="text-danger">
                                                   {{ $errors->first('ship_via') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Style No</label>
                                            <input type="text" name="style_no" class="form-control" required>
                                            @if($errors->has('style_no'))
                                                <span class="text-danger">
                                                   {{ $errors->first('style_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>CA/RN</label>
                                            <input type="text" name="ca" class="form-control" required>
                                            @if($errors->has('ca'))
                                                <span class="text-danger">
                                                   {{ $errors->first('ca') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Quantity</label>
                                            <input type="text" id="total_quantity" name="total_quantity" id="total_quantity" value="0" class="form-control total_quantity" required readonly>
                                            @if($errors->has('total_quantity'))
                                                <span class="text-danger">
                                                   {{ $errors->first('total_quantity') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Amount</label>
                                            <input type="text" id="total_amount" name="total_amount" value="0.00" class="form-control total_amount" required readonly>
                                            @if($errors->has('amount'))
                                                <span class="text-danger">
                                                   {{ $errors->first('amount') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Description</label>
                                            <input type="text" name="description" class="form-control" id="description">
                                            @if($errors->has('description'))
                                                <span class="text-danger">
                                                   {{ $errors->first('description') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Fabrication</label>
                                            <input type="text" name="fabrication" class="form-control" id="description">
                                            @if($errors->has('fabrication'))
                                                <span class="text-danger">
                                                   {{ $errors->first('fabrication') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Instruction Notes</label>
                                            <textarea name="instruction_notes" class="form-control" id="ins_notes" rows="5"></textarea>
                                            @if($errors->has('ins_notes'))
                                                <span class="text-danger">
                                                   {{ $errors->first('ins_notes') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Packing Instruction</label>
                                            <textarea name="packing_instruction" class="form-control" id="packing_instruction" rows="5"></textarea>
                                            @if($errors->has('packing_instruction'))
                                                <span class="text-danger">
                                                   {{ $errors->first('packing_instruction') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <div class="break_down">
                                    <label>BREAK DOOWN</label>
                                    {{-- <a id="add_size" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">Add Color</a> --}}
                                </div>


                            <div class="color_box">
                                <div class="row">
                                    <div class="col-md-12" style="margin:30px 0px;">
                                        <table id="colorSection" width="100%">
                                             <thead>
                                                 <tr>
                                                     <th>Color Name <a id="add_size" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">+</a></th>
                                                     <th>Code</th>
                                                     <th>Quantity</th>
                                                     <th>Unit Price</th>
                                                     <th>Sub Total</th>
                                                 </tr>
                                             </thead>
                                             <tbody>
                                                 <tr>
                                                     <td><input type="text" name="color[]" class="form-control"></td>
                                                     <td><input type="text" name="color_code[]" class="form-control"></td>
                                                     <td><input type="number" min="0" step="any" name="color_wise_quantity[]" value="0" id="color_wise_quantity1" class="form-control color_wise_quantity1" readonly></td>
                                                     <td><input type="number" min="0" step="any" name="color_unit_price[]" id="color_unit_price1" class="form-control color_unit_price1"></td>
                                                     <td><input type="number" min="0" step="any" name="sub_total[]" id="sub_total1" value="0.00" class="form-control sub_total1" readonly></td>
                                                 </tr>
                                             </tbody>
                                        </table>

                                        <table id="sizeSection" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Size</th>
                                                    <th>Prepack</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="size1[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack1[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity1[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size2[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack2[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity2[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size3[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack3[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity3[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size4[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack4[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity4[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size5[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack5[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity5[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size6[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack6[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity6[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size7[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack7[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity7[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size8[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack8[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity8[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                                <tr>
                                                    <td><input type="text" name="size9[]" class="form-control"></td>
                                                    <td><input type="text" name="prepack9[]" class="form-control"></td>
                                                    <td><input type="number" min="0" step="any" name="quantity9[]" id="quantity1" class="form-control quantity1"></td>
                                                </tr>
                                            </tbody>
                                       </table>
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
    $("ul#order-summary #purchase-order-menu").addClass("active");


    $(document).ready(function(){
        var max_field = 4;
        var wrapper = $(".color_box");
        var x = 1;
        $("#add_size").click(function(){
            if(x < max_field){
                x++;
                $('#color_number').val(x);
                $(wrapper).append('<div class="row">\
                                    <div class="col-md-12" style="margin: 30px 0px;">\
                                        <table id="colorSection">\
                                             <thead>\
                                                 <tr>\
                                                     <th>Color Name <a id="remove_size" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a></th>\
                                                     <th>Code</th>\
                                                     <th>Quantity</th>\
                                                     <th>Unit Price</th>\
                                                     <th>Total Price</th>\
                                                 </tr>\
                                             </thead>\
                                             <tbody>\
                                                 <tr>\
                                                     <td><input type="text" name="color[]" class="form-control"></td>\
                                                     <td><input type="text" name="color_code[]" class="form-control"></td>\
                                                     <td><input type="number" min="0" step="any" name="color_wise_quantity[]" value="0" id="color_wise_quantity'+x+'" class="form-control color_wise_quantity'+x+'" readonly></td>\
                                                     <td><input type="number" min="0" step="any" name="color_unit_price[]" id="color_unit_price'+x+'" class="form-control color_unit_price'+x+'"></td>\
                                                     <td><input type="number" min="0" step="any" name="sub_total[]" id="sub_total'+x+'" value="0.00" class="form-control sub_total'+x+'" readonly></td>\
                                                 </tr>\
                                             </tbody>\
                                        </table>\
                                        <table id="sizeSection" width="100%">\
                                            <thead>\
                                                <tr>\
                                                    <th>Size</th>\
                                                    <th>Prepack</th>\
                                                    <th>Quantity</th>\
                                                </tr>\
                                            </thead>\
                                            <tbody>\
                                                <tr>\
                                                    <td><input type="text" name="size1[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack1[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity1[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size2[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack2[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity2[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size3[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack3[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity3[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size4[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack4[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity4[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size5[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack5[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity5[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size6[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack6[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity6[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size7[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack7[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity7[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size8[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack8[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity8[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                                <tr>\
                                                    <td><input type="text" name="size9[]" class="form-control"></td>\
                                                    <td><input type="text" name="prepack9[]" class="form-control"></td>\
                                                    <td><input type="number" min="0" step="any" name="quantity9[]" id="quantity'+x+'" class="form-control quantity'+x+'"></td>\
                                                </tr>\
                                            </tbody>\
                                       </table>\
                                    </div>\
                                </div>');
            }else{
                alert('you can not add more than 4 field');
            }
        });

    $(wrapper).on("click","#remove_size", function(e){ //user click on remove text
	     e.preventDefault();
	     $(this).parent('th').parent('tr').parent('thead').parent('table').parent('div').parent('div').remove(); x--;
         calculate_total_quantity();
         calculate_total_amount();
    });


    $(document).on('keyup change', '#quantity1', function() {
        var sum = 0;
        $(".quantity1").each(function(){
                sum += +$(this).val();
        });
        $('.color_wise_quantity1').val(sum);

        var quantity = $('.color_wise_quantity1').val();
        var unitprice = $('.color_unit_price1').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total1').val(total_price);

        calculate_total_quantity();
        calculate_total_amount();
    });

    $(document).on('keyup change', '#quantity2', function() {
        var sum = 0;
        $(".quantity2").each(function(){
                sum += +$(this).val();
        });
        $('.color_wise_quantity2').val(sum);

        var quantity = $('.color_wise_quantity2').val();
        var unitprice = $('.color_unit_price2').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total2').val(total_price);
        calculate_total_quantity();
        calculate_total_amount();
    });

    $(document).on('keyup change', '#quantity3', function() {
        var sum = 0;
        $(".quantity3").each(function(){
                sum += +$(this).val();
        });
        $('.color_wise_quantity3').val(sum);

        var quantity = $('.color_wise_quantity3').val();
        var unitprice = $('.color_unit_price3').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total3').val(total_price);
        calculate_total_quantity();
        calculate_total_amount();
    });

    $(document).on('keyup change', '#quantity4', function() {
        var sum = 0;
        $(".quantity4").each(function(){
                sum += +$(this).val();
        });
        $('.color_wise_quantity4').val(sum);

        var quantity = $('.color_wise_quantity4').val();
        var unitprice = $('.color_unit_price4').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total4').val(total_price);
        calculate_total_quantity();
        calculate_total_amount();
    });

    $(document).on('keyup change', '#color_unit_price1', function() {

        var quantity = $('.color_wise_quantity1').val();
        var unitprice = $('.color_unit_price1').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total1').val(total_price);
        calculate_total_amount();
    });

    $(document).on('keyup change', '#color_unit_price2', function() {

        var quantity = $('.color_wise_quantity2').val();
        var unitprice = $('.color_unit_price2').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total2').val(total_price);
        calculate_total_amount();
    });

    $(document).on('keyup change', '#color_unit_price3', function() {

        var quantity = $('.color_wise_quantity3').val();
        var unitprice = $('.color_unit_price3').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total3').val(total_price);
        calculate_total_amount();
    });

    $(document).on('keyup change', '#color_unit_price4', function() {

        var quantity = $('.color_wise_quantity4').val();
        var unitprice = $('.color_unit_price4').val();
        var total_price = parseFloat(quantity*unitprice).toFixed(2);
        $('.sub_total4').val(total_price);
        calculate_total_amount();
    });


    function calculate_total_quantity(){
        var quantity1 = $('.color_wise_quantity1').val();
        if (isNaN(quantity1)) quantity1 = 0;
        var quantity2 = $('.color_wise_quantity2').val();
        if (isNaN(quantity2)) quantity2 = 0;
        var quantity3 = $('.color_wise_quantity3').val();
        if (isNaN(quantity3)) quantity3 = 0;

        var total = parseInt(quantity1) + parseInt(quantity2) + parseInt(quantity3);
        if (isNaN(total)) total = 0;
        $('.total_quantity').val(total);
    }

    function calculate_total_amount(){
        var sub1 = $('.sub_total1').val();
        if (isNaN(sub1)) sub1 = 0;
        var sub2 = $('.sub_total2').val();
        if (isNaN(sub2)) sub2 = 0;
        var sub3 = $('.sub_total3').val();
        if (isNaN(sub3)) sub3 = 0;

        var total_amount = parseFloat(sub1) + parseFloat(sub2) + parseFloat(sub3);
        if (isNaN(total_amount)) total_amount = 0;
        $('.total_amount').val(parseFloat(total_amount).toFixed(2));
    }

    });

    tinymce.init({
      selector: 'textarea',
      height: 150,
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
