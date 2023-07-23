@extends('layout.main') @section('content')
    @if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
    @push('css')

    @endpush
    <section class="forms">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h4>Add Purchase Order</h4>
                        </div>
                        <div class="card-body">
                            <p class="italic">
                                <small>{{trans('file.The field labels marked with * are required input fields')}}
                                    .</small></p>
                            {!! Form::open(['route' => 'purchase_order.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>PO Number*</label>
                                                <input type="text" name="po_number" class="form-control"
                                                       placeholder="Enter PO Number">
                                                @if($errors->has('po_number'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('po_number') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Last Revised</label>
                                                <input type="text" name="rivision_no" class="datepicker form-control "
                                                       placeholder="Enter Last Revised">
                                                @if($errors->has('rivision_no'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('rivision_no') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Shipper/Vendor *</label>
                                                <select required name="vendor" class="selectpicker form-control"
                                                        data-live-search="true" data-live-search-style="begins"
                                                        title="Select vendor or shipper...">
                                                    @foreach ($lims_vendor_all as $vendor)
                                                        <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label>LC/SC No</label>-->
                                        <!--        <input type="text" name="lc_no" class="form-control" required>-->
                                        <!--        @if($errors->has('lc_no'))-->
                                        <!--            <span class="text-danger">-->
                                        <!--                {{ $errors->first('lc_no') }}-->
                                        <!--            </span>-->
                                        <!--        @endif-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ship To*</label>
                                                <select name="ship_to" class="selectpicker form-control"
                                                        data-live-search="true" data-live-search-style="begins"
                                                        title="Select Ship To...">
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Customer*</label>
                                                <select name="customer_id" class="selectpicker form-control"
                                                        data-live-search="true" data-live-search-style="begins"
                                                        title="Select Customer...">
                                                    @foreach ($lims_customer_all as $customer)
                                                        <option
                                                            value="{{ $customer->id }}">{{ $customer->name }}</option>
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

                                                <label>Invoice To*</label>
                                                <select name="invoice_to" class="form-control" data-live-search="true"
                                                        data-live-search-style="begins" title="Select Invoice To..."
                                                        required>
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
                                                <label>Season*</label>
                                                <input type="text"
                                                       placeholder="Enter Season"
                                                       name="season" class="form-control" required>
                                                @if($errors->has('season'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('season') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order date*</label>
                                                <input type="text" name="order_date" class="datepicker form-control"
                                                       placeholder="Enter Order Date" required>
                                                @if($errors->has('order_date'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('order_date') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label>Cancel date</label>-->
                                        <!--        <input type="date" name="cancel_date" class="form-control" required>-->
                                        <!--        @if($errors->has('cancel_date'))-->
                                        <!--            <span class="text-danger">-->
                                        <!--               {{ $errors->first('cancel_date') }}-->
                                        <!--            </span>-->
                                        <!--        @endif-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>X-Country Date*</label>
                                                <input type="text" name="ship_exp_date" class="datepicker form-control"
                                                       placeholder="Enter X-Country Date"
                                                       required>
                                                @if($errors->has('ship_exp_date'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('ship_exp_date') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Terms*</label>
                                                <input type="text" name="ship_terms" class="form-control"
                                                       placeholder="Enter Terms " required>
                                                @if($errors->has('ship_terms'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('ship_terms') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Payment / Draft at*</label>
                                                <input type="text" name="payment_terms" class="form-control"
                                                       placeholder="Enter Payment / Draft at " required>
                                                @if($errors->has('payment_terms'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('payment_terms') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Fabric Ref*</label>
                                                <input type="text" name="febric_ref" class="form-control"
                                                       placeholder="Enter Fabric Ref"
                                                       required>
                                                @if($errors->has('febric_ref'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('febric_ref') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Brand/Label*</label>
                                                <input type="text" name="brand" class="form-control"
                                                       placeholder="Enter Brand/Label">
                                                @if($errors->has('brand'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('brand') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Ship Via*</label>
                                                <input type="text" name="ship_via" class="form-control"
                                                       placeholder="Enter Ship Via">
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
                                                <input type="text" name="style_no" class="form-control"
                                                       placeholder="Enter Style No" required>

                                                @if($errors->has('style_no'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('style_no') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>CA/RN*</label>
                                                <input type="text" name="ca" class="form-control"
                                                       placeholder="Enter CA/RN" required>
                                                @if($errors->has('ca'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('ca') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Total Quantity*</label>
                                                <input type="text" id="total_quantity" name="total_quantity"
                                                       id="total_quantity" value="0" class="form-control total_quantity"
                                                       required readonly>
                                                @if($errors->has('total_quantity'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('total_quantity') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Total Amount*</label>
                                                <input type="text" id="total_amount" name="total_amount" value="0.00"
                                                       class="form-control total_amount" required readonly>
                                                @if($errors->has('amount'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('amount') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Item Description</label>
                                                <input type="text" name="description" class="form-control"
                                                       id="description" placeholder="Enter Description">
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
                                                <input type="text" name="fabrication" class="form-control"
                                                       id="description" placeholder="Enter Febrication">
                                                @if($errors->has('fabrication'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('fabrication') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Special Instruction</label>
                                                <textarea name="instruction_notes" class="form-control" id="ins_notes"
                                                          rows="5"></textarea>
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
                                                <textarea name="packing_instruction" class="form-control"
                                                          id="packing_instruction" rows="5"></textarea>
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
                                                        <th>Color Name <a id="add_size" class="btn btn-info btn-sm"
                                                                          style="color:white;margin-left:10px;">+</a>
                                                        </th>
                                                        <th>Code</th>
                                                        <th>Quantity</th>
                                                        <th>Unit Price</th>
                                                        <th>Sub Total</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><input type="text" name="color[]" class="form-control"
                                                                   placeholder="Enter Color Name"></td>
                                                        <td><input type="text" name="color_code[]" class="form-control"
                                                                   placeholder="Enter Color Code"></
                                                        ></td>
                                                        <td><input type="number" min="0" step="any"
                                                                   name="color_wise_quantity[]" value="0"
                                                                   id="color_wise_quantity1"
                                                                   class="form-control color_wise_quantity1 color_wise_quantity" readonly>
                                                        </td>
                                                        <td><input type="number" min="0" step="any"
                                                                   name="color_unit_price[]" id="color_unit_price1"
                                                                   class="form-control color_unit_price color_unit_price1"
                                                                   oninput="getAmount(1)"
                                                                   placeholder="Enter Unit Price "></
                                                        ></td>
                                                        <td><input type="number" min="0" step="any" name="sub_total[]"
                                                                   id="sub_total1" value="0.00"
                                                                   class="form-control sub_total1 sub_total" readonly></td>
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
                                                    <tbody id="t_body_id_1">
                                                    <tr class="row-concat1" id="row-concat_1">
                                                        <td><input type="text" name="color_1_size1" class="form-control" placeholder="Enter Size"></td>
                                                        <td><input type="text" name="color_1_prepack1" class="form-control" placeholder="Enter Prepack"></td>
                                                        <td><input type="number" min="0" step="any" name="color_1_quantity1" id="quantity1 color_wise_quantity1_qty_1" class="form-control quantity1 color_wise_quantity1_qty_1" oninput="calculateQuantity('1'), getAmount('1')" placeholder="Enter Quantity"></td>
                                                        <td><a id="remove_concat" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;" onclick="removeRow(1, 1)">-</a></td>
                                                    </tr>
                                                    {{-- <tr>
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
                                                    <tr>
                                                        <td><input type="text" name="size10[]" class="form-control"></td>
                                                        <td><input type="text" name="prepack10[]" class="form-control"></td>
                                                        <td><input type="number" min="0" step="any" name="quantity10[]" id="quantity1" class="form-control quantity1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="size11[]" class="form-control"></td>
                                                        <td><input type="text" name="prepack11[]" class="form-control"></td>
                                                        <td><input type="number" min="0" step="any" name="quantity11[]" id="quantity1" class="form-control quantity1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="size12[]" class="form-control"></td>
                                                        <td><input type="text" name="prepack12[]" class="form-control"></td>
                                                        <td><input type="number" min="0" step="any" name="quantity12[]" id="quantity1" class="form-control quantity1"></td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="text" name="size13[]" class="form-control"></td>
                                                        <td><input type="text" name="prepack13[]" class="form-control"></td>
                                                        <td><input type="number" min="0" step="any" name="quantity13[]" id="quantity1" class="form-control quantity1"></td>
                                                    </tr> --}}
                                                    <tr>
                                                        <a class="btn btn-success btn-sm" id="add_contact_1" onclick="addRow(1,1)"
                                                           style="color: white; ">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </tr>
                                                    {{-- <div class="col-12 col-sm-6 col-md-2"><br>
                                                        <a class="btn btn-success btn-sm" id="add_contact" style="width:100%;color: white; ">
                                                            <i class="fa fa-plus"></i>
                                                        </a>
                                                    </div> --}}
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary"
                                                id="submit-btn">{{trans('file.submit')}}</button>
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
        // $(".dateFormate").val(new Date().toISOString().substring(0, 10));
        $("ul#order-summary").siblings('a').attr('aria-expanded', 'true');
        $("ul#order-summary").addClass("show");
        $("ul#order-summary #purchase-order-menu").addClass("active");

        var y = 1;
        $(document).ready(function () {
            var max_field = 7;
            console.log(max_field);
            var concatMaxField = 13;
            var wrapper = $(".color_box");
            var x = 1;

            $("#add_size").click(function () {
                if (x < max_field) {
                    x++;
                    // y=1;
                    $('#color_number').val(x);
                    $(wrapper).append('<div class="row rmv'+x+'">\
                                    <div class="col-md-12" style="margin: 30px 0px;">\
                                        <table id="colorSection">\
                                             <thead>\
                                                 <tr>\
                                                     <th>Color Name <a id="" onclick="remove_size('+x+')" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a></th>\
                                                     <th>Code</th>\
                                                     <th>Quantity</th>\
                                                     <th>Unit Price</th>\
                                                     <th>Total Price</th>\
                                                     <th>\
                                                        <a class="btn btn-success btn-sm" id="add_contact_' + x + '" onclick="addRow(0,' + x + ')" style="color: white; ">\
                                                            <i class="fa fa-plus"></i>\
                                                        </a>\
                                                    </th>\
                                                 </tr>\
                                             </thead>\
                                             <tbody>\
                                                 <tr>\
                                                     <td><input type="text" name="color[]" class="form-control"></td>\
                                                     <td><input type="text" name="color_code[]" class="form-control"></td>\
                                                     <td><input type="number" min="0" step="any" name="color_wise_quantity[]" value="0" id="color_wise_quantity' + x + '" class="form-control color_wise_quantity' + x + ' color_wise_quantity" readonly></td>\
                                                     <td><input type="number" min="0" step="any" name="color_unit_price[]" id="color_unit_price' + x + '" class="form-control color_unit_price color_unit_price' + x + '" oninput="getAmount('+x+')"></td>\
                                                     <td><input type="number" min="0" step="any" name="sub_total[]" id="sub_total' + x + '" value="0.00" class="form-control sub_total' + x + ' sub_total" readonly></td>\
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
                                            <tbody id="t_body_id_' + x + '">\
                                                <tr class="row-concat' + x + '" id="row-concat_1">\
                                                    <td><input type="text" name="color_'+x+'_size1" class="form-control"></td>\
                                                    <td><input type="text" name="color_'+x+'_prepack1" class="form-control"></td>\
                                                    <td><input type="number" oninput="calculateQuantity('+x+', 1), getAmount('+x+')" min="0" step="any" name="color_'+x+'_quantity1" id="quantity1 color_wise_quantity'+x+'_qty_'+x+'" class="color_wise_quantity1_qty_'+x+' form-control quantity' + x + '"></td>\
                                                    <td><a id="remove_concat" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;" onclick="removeRow(1, ' + x + ')">-</a></td>\
                                                </tr>\
                                            </tbody>\
                                       </table>\
                                    </div>\
                                </div>');

                    // var concatCount= x-1;
                    //     $('#add_contact').hide();
                    //     $('#add_contact_'+concatCount).hide();

                    // function addRow(x){
                    //     if(y<concatMaxField){
                    //         y++;
                    //         $('#t_body_id_'+x).append('<tr><td><input type="text" name="size'+y+'[]" class="form-control" placeholder="Enter Size"></td><td><input type="text" name="prepack'+y+'[]" class="form-control" placeholder="Enter Prepack"></td><td><input type="number" min="0" step="any" name="quantity'+y+'[]" id="quantity'+y+'" class="form-control quantity1" placeholder="Enter Quantity"></td></tr>');
                    //     }
                    // }

                    // $('#add_contact_'+x).click(function(){
                    //     console.log($('#add_contact_'+x));
                    //     if(y<concatMaxField){
                    //         y++;
                    //         $('#t_body_id_'+x).append('<tr><td><input type="text" name="size'+y+'[]" class="form-control" placeholder="Enter Size"></td><td><input type="text" name="prepack'+y+'[]" class="form-control" placeholder="Enter Prepack"></td><td><input type="number" min="0" step="any" name="quantity'+y+'[]" id="quantity'+y+'" class="form-control quantity1" placeholder="Enter Quantity"></td></tr>');
                    //     }
                    // });
                } else {
                    alert('you can not add more than 7 field');
                }
            });

        });



        function getAmount(x){
            var subTotalAmount= 0;
            var totalAmount= 0;
            var qty=0;
            var price=0;

            qty = parseFloat($('#color_wise_quantity'+x).val());
            price = parseFloat($('#color_unit_price'+x).val());

            subTotalAmount= parseFloat(qty*price);


            $('#sub_total'+x).val(subTotalAmount);

            $('.sub_total').each(function(){
                totalAmount += parseFloat($(this).val());
            });

            $('#total_amount').val(totalAmount);
        }

        function calculateQuantity(id){
            var abc= 0;
            var def= 0;
            $('.color_wise_quantity1_qty_'+id).each(function(){
                abc += parseFloat($(this).val());
            })
            $('.color_wise_quantity'+id).val(abc);

            $('.color_wise_quantity').each(function(){
                def += parseFloat($(this).val());
            })
            $('#total_quantity').val(def);

        }

        function removeRow(x, counter){
            //$(this).parent().remove();
            $('#color_wise_quantity'+x+'_qty_'+counter).parent().parent().remove();
            this.calculateQuantity(x);
            this.getAmount(x);
        }


        var y = 1;
        function addRow(item,x) {
            // console.log($('.dd_'+x).length+2);
            y++;
            var counter = $('.row-concat' + x).length+x;
            var name = 1;
            $('.color_wise_quantity1_qty_'+x).each(function(){
                name++;
            });


            // if (counter - 2 < 13) {
                // y++;
                $('#t_body_id_' + x).append('<tr class="row-concat' + x + '" id="row-concat_' + counter + '"><td><input type="text" name="color_'+x+'_size' + name + '" class="form-control" placeholder="Enter Size"></td><td><input type="text" name="color_'+x+'_prepack' + name + '" class="form-control" placeholder="Enter Prepack"></td><td><input type="number" min="0" step="any" name="color_'+x+'_quantity' + name + '" id="color_wise_quantity'+x+'_qty_'+ counter + '" oninput="calculateQuantity('+x+'), getAmount('+x+')" class="form-control color_wise_quantity1_qty_'+x+' quantity'+x+'" placeholder="Enter Quantity"></td><td><a id="remove_concat" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;" onclick="removeRow('+x+','+counter+')">-</a></td></tr>');
            // } else {
            //     alert("Maximum row is 13");
            // }
        }

        function remove_size(x) {
             console.log(x);
            $('.rmv'+x).remove();
            //$('.row-concat' + x + '#row-concat_' + counter).remove();
            this.calculateQuantity(x);
            this.getAmount(x);
        }

        tinymce.init({
            selector: 'textarea',
            height: 150,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor textcolor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code wordcount'
            ],
            toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat',
            branding: false
        });



        function quantityCalc(pram){
            console.log(this.value)
        }


    </script>
@endsection
