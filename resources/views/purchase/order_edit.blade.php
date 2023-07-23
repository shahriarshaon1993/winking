@extends('layout.main') @section('content')
    @if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
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
                            <p class="italic">
                                <small>{{trans('file.The field labels marked with * are required input fields')}}
                                    .</small></p>
                            {!! Form::open(['route' => ['purchase_order.update',$lim_order_data->id], 'method' => 'put', 'files' => true, 'id' => 'purchase-form']) !!}
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>PO Number</label>
                                                <input type="text" name="po_number" class="form-control"
                                                       placeholder="Enter PO Number"
                                                       value="{{$lim_order_data->po_number}}">
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
                                                <input type="text" name="rivision_no" class="datepicker form-control"
                                                       placeholder="Enter Last Revised"
                                                       value="{{ date('d-M-Y',strtotime($lim_order_data->rivision_no)) }}">
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
                                                        <option
                                                            value="{{ $vendor->id }}" <?php echo ($vendor->id == $lim_order_data->vendor) ? 'selected' : '' ?>>{{ $vendor->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!--<div class="col-md-6">-->
                                        <!--    <div class="form-group">-->
                                        <!--        <label>LC/SC No</label>-->
                                        <!--        <input type="text" name="lc_no" class="form-control" required value={{$lim_order_data->lc_no}} >-->
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
                                                        title="Select ship to...">
                                                    @foreach ($lims_ship_to_all as $ship)
                                                        <option
                                                            value="{{ $ship->id }}" <?php echo ($ship->id == $lim_order_data->ship_to) ? 'selected' : '' ?>>{{ $ship->name }}</option>
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
                                                        title="Select customer...">
                                                    @foreach ($lims_customer_all as $customer)
                                                        <option
                                                            value="{{ $customer->id }}" <?php echo ($customer->id == $lim_order_data->customer_id) ? 'selected' : '' ?>>{{ $customer->name }}</option>
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
                                                <div class="input-group">
                                                    <label>Invoice To*</label>
                                                    <select name="invoice_to" class="form-control"
                                                            data-live-search="true" data-live-search-style="begins"
                                                            title="Select invoice to..." required>
                                                        @foreach ($lims_invoice_to_all as $invoice)
                                                            <option
                                                                value="{{ $invoice->id }}" <?php echo ($invoice->id == $lim_order_data->invoice_to) ? 'selected' : '' ?>>{{ $invoice->name }}</option>
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
                                                <label>Season*</label>
                                                <input type="text" name="season" class="form-control"
                                                       placeholder="Enter Season"
                                                       value="{{$lim_order_data->season}}" required>
                                                @if($errors->has('season'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('season') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Order Date*</label>
                                                <input type="text" name="order_date" class="datepicker form-control"
                                                       placeholder="Enter Order Date"
                                                       value="{{ date('d-M-Y',strtotime($lim_order_data->order_date)) }}"
                                                       required>
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
                                        <!--        <input type="date" name="cancel_date" class="form-control" value={{$lim_order_data->cancel_date}} required>-->
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
                                                       value="{{ date('d-M-Y',strtotime($lim_order_data->ship_exp_date)) }}"
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
                                                       placeholder="Enter Terms"
                                                       value="{{$lim_order_data->ship_terms}}" required>
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
                                                       placeholder="Enter Payment / Draft at"
                                                       value="{{$lim_order_data->payment_terms}}" required>
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
                                                       value="{{$lim_order_data->febric_ref}}" required>
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
                                                       placeholder="Brand/Label"
                                                       value="{{$lim_order_data->brand}}">
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
                                                       placeholder="Enter Ship Via"
                                                       value="{{$lim_order_data->ship_via}}">
                                                @if($errors->has('ship_via'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('ship_via') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Style No*</label>
                                                <input type="text" name="style_no" class="form-control"
                                                       placeholder="Enter Style No"
                                                       required value="{{$lim_order_data->style_no}}">
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
                                                <input type="text"
                                                       placeholder="Enter CA/RN"
                                                       name="ca" class="form-control" value="{{$lim_order_data->ca}}"
                                                       required>
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
                                                       id="total_quantity"
                                                       placeholder="Enter Total Quantity"
                                                       value="{{$lim_order_data->total_quantity}}"
                                                       class="form-control total_quantity" required readonly>
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
                                                <input type="text" id="total_amount" name="total_amount"
                                                       placeholder="Enter Total Amount"
                                                       value="{{$lim_order_data->total_amount}}"
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
                                                <label>Item Description*</label>
                                                <input type="text" name="description" class="form-control"
                                                       id="description"
                                                       placeholder="Enter Item Description"
                                                       value="{{$lim_order_data->description}}">
                                                @if($errors->has('description'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('description') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Fabrication*</label>
                                                <input type="text" name="fabrication" class="form-control"
                                                       id="description" placeholder="Enter Fabrication"
                                                       value="{{$lim_order_data->fabrication}}">
                                                @if($errors->has('fabrication'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('fabrication') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Special Instruction*</label>
                                                <textarea name="instruction_notes" class="form-control" id="ins_notes"
                                                          rows="5">{!! $lim_order_data->instruction_notes !!}</textarea>
                                                @if($errors->has('ins_notes'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('ins_notes') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Packing Instruction*</label>
                                                <textarea name="packing_instruction" class="form-control"
                                                          id="packing_instruction"
                                                          rows="5">{!! $lim_order_data->packing_instruction !!}</textarea>
                                                @if($errors->has('packing_instruction'))
                                                    <span class="text-danger">
                                                   {{ $errors->first('packing_instruction') }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                    <div class="break_down">
                                        <label>BREAK DOWN</label>
                                        {{-- <a id="add_size" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">Add Color</a> --}}
                                    </div>


                                    <div class="color_box">
                                        @foreach($lim_details as $key => $value)
                                            {{-- {{ dd($value) }} --}}
                                            <div class="row rmv{{$key+1}}">
                                                <div class="col-md-12" style="margin:30px 0px;">
                                                    <table id="colorSection" width="100%">
                                                        <thead>
                                                        <tr>
                                                            @if($key == 0)
                                                                <th>Color Name <a id="add_size"
                                                                                  class="btn btn-danger btn-sm"
                                                                                  style="color:white;margin-left:10px;">+</a>
                                                                </th>
                                                            @else
                                                                <th>Color Name <a id="remove_size"
                                                                                  onclick="remove_size({{$key+1}})"
                                                                                  class="btn btn-danger btn-sm"
                                                                                  style="color:white;margin-left:10px;">-</a>
                                                                </th>
                                                            @endif
                                                            <th>Code</th>
                                                            <th>Quantity</th>
                                                            <th>Unit Price</th>
                                                            <th>Sub Total</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                            <td><input type="text" name="color[]" class="form-control"
                                                                       value="{{$value->color}}"
                                                                       placeholder="Enter Color Name"></td>
                                                            <td><input type="text" name="color_code[]"
                                                                       class="form-control"
                                                                       placeholder="Enter Color Code "
                                                                       value="{{$value->color_code}}"></td>
                                                            <td><input type="number" min="0" step="any"
                                                                       name="color_wise_quantity[]"
                                                                       value="{{$value->color_wise_quantity}}"
                                                                       id="color_wise_quantity{{ $key+1 }}"
                                                                       class="color_wise_quantity form-control color_wise_quantity{{ $key+1 }}"
                                                                       readonly></td>
                                                            <td><input type="number" min="0" step="any"
                                                                       name="color_unit_price[]"
                                                                       id="color_unit_price{{ $key+1 }}"
                                                                       value="{{$value->color_unit_price}}"
                                                                       class="form-control color_unit_price color_unit_price{{ $key+1 }}"
                                                                       oninput="getAmount({{ $key+1 }})"></td>
                                                            <td><input type="number" min="0" step="any"
                                                                       name="sub_total[]" id="sub_total{{ $key+1 }}"
                                                                       value="{{$value->sub_total}}"
                                                                       class="form-control sub_total{{ $key+1 }} sub_total"
                                                                       readonly></td>
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
                                                        <tbody class="rowcount" id="t_body_id_{{ $key }}">
                                                        @for ($i=1; $i<=$sizeCount; $i++)
                                                            @if($value['size'.$i] != null)
                                                                <tr class="row-concat{{ $key }}"
                                                                    id="row-concat_{{ $i }}">
                                                                    <td><input type="text"
                                                                               name="color_{{$key+1}}_size{{ $i }}"
                                                                               class="form-control size{{$key+1}}"
                                                                               value="{{$value['size'.$i]}}"
                                                                               placeholder="Enter Size"></td>
                                                                    <td><input type="text"
                                                                               name="color_{{$key+1}}_prepack{{ $i }}"
                                                                               class="form-control"
                                                                               value="{{$value['prepack'.$i]}}"
                                                                               placeholder="Enter prepack"></td>
                                                                    <td><input type="number" min="0" step="any"
                                                                               name="color_{{$key+1}}_quantity{{ $i }}"
                                                                               value="{{$value['quantity'.$i]}}"
                                                                               id="color_wise_quantity{{ $key+1 }}_qty_{{ $i }}"
                                                                               class="form-control quantity{{ $key+1 }} color_wise_quantity1_qty_{{ $key+1  }}"
                                                                               oninput="calculateQuantity({{ $key+1 }}), getAmount({{ $key+1 }})"
                                                                               placeholder="Enter quantity"></td>
                                                                    <td><a id="remove_concat"
                                                                           class="btn btn-danger btn-sm"
                                                                           style="color:white;margin-left:10px;"
                                                                           onclick="removeRowStatic({{ $key+1 }}, {{ $i }})">-</a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endfor
                                                            <?php
                                                            $rowCount = 0;
                                                            for ($j = 1; $j <= 13; $j++) {
                                                                if ($value['size' . $j] != null) {
                                                                    $rowCount++;
                                                                }
                                                            }
                                                            ?>
                                                        <tr>
                                                            <a class="btn btn-success btn-sm"
                                                               id="add_contact_{{ $key }}" style="color: white; "
                                                               onclick="addRow(0,{{ $key }})">
                                                                <i class="fa fa-plus"></i>
                                                            </a>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
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

        $("ul#order-summary").siblings('a').attr('aria-expanded', 'true');
        $("ul#order-summary").addClass("show");
        $("ul#order-summary #purchase-order-menu-list").addClass("active");

        var y = "{{$rowCount}}";

        $(document).ready(function () {
            var max_field = 4;
            var concatMaxField = 13;
            var wrapper = $(".color_box");
            var x = "{{$lim_details->count()}}";

            $("#add_size").click(function () {
                console.log(85);
                if (x < max_field) {
                    x++;
                    $('#color_number').val(x);
                    $(wrapper).append(`
                    <div class="row rmv${x}">
                        <div class="col-md-12" style="margin: 30px 0px;">
                            <table id="colorSection">
                                 <thead>
                                     <tr>
                                         <th>
                                            Color Name
                                            <a id="" onclick="remove_size(${x})" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">
                                                -
                                            </a>
                                        </th>
                                         <th>Code</th>
                                         <th>Quantity</th>
                                         <th>Unit Price</th>
                                         <th>Total Price</th>
                                         <th>
                                            <a class="btn btn-success btn-sm" id="add_contact_${x}" onclick="addRow(1,${x})" style="color: white; ">
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </th>
                                     </tr>
                                 </thead>
                                 <tbody class="rowcount">
                                     <tr>
                                         <td><input type="text" name="color[]" class="form-control"></td>
                                         <td><input type="text" name="color_code[]" class="form-control"></td>
                                         <td><input type="number" min="0" step="any" name="color_wise_quantity[]" value="0" id="color_wise_quantity${x}" class="color_wise_quantity form-control color_wise_quantity${x}" readonly></td>
                                         <td><input type="number" min="0" step="any" name="color_unit_price[]" id="color_unit_price${x}" class="form-control color_unit_price color_unit_price${x}" oninput="getAmount(${x})"></td>
                                         <td><input type="number" min="0" step="any" name="sub_total[]" id="sub_total${x}" value="0.00" class="form-control sub_total${x} sub_total" readonly></td>
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
                                <tbody id="t_body_id_${x}">
                                    <tr class="row-concat${x}" id="row-concat_1">
                                        <td><input type="text" name="size1[]" class="form-control"></td>
                                        <td><input type="text" name="prepack1[]" class="form-control"></td>
                                        <td><input type="number" min="0" step="any" name="quantity1[]" id="quantity1 color_wise_quantity${x}_qty_${x}" class="color_wise_quantity1_qty_${x} form-control quantity${x}" oninput="calculateQuantity(${x}, 1), getAmount(${x})"></td>
                                        <td><a id="remove_concat" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;" onclick="removeRow(1, ${x})">-</a></td>
                                    </tr>
                                </tbody>
                           </table>
                        </div>
                    </div>
                    `);
                } else {
                    alert('you can not add more than 4 field');
                }
            });
        });

        function addRow(val, x) {
            console.log(val, x)
            var c = x + 1;
            var item;
            val == 0 ? item = x + 1 : item = x;
            y++;
            var counter = $('.row-concat' + x).length + x;
            //console.log(counter);
            var cl = $('.size' + c).length + 1;
            console.log(cl);
            $('#t_body_id_' + x).append(`
                <tr class="row-concat${item}" id="row-concat_${counter}">
                    <td>
                        <input type="text" name="color_${item}_size${cl}" class="form-control size${c}" placeholder="Enter Size">
                    </td>
                    <td>
                        <input type="text" name="color_${item}_prepack${cl}" class="form-control" placeholder="Enter Prepack">
                    </td>
                    <td>
                        <input type="number" min="0" step="any"
                                name="color_${item}_quantity${cl}"
                                id="color_wise_quantity${item}_qty_${counter}"
                                oninput="calculateQuantity(${item}),
                                getAmount(${item})"
                                class="form-control quantity${item} color_wise_quantity1_qty_${item}"
                                placeholder="Enter Quantity">
                    </td>
                    <td>
                        <a id="remove_concat" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;" onclick="removeRow(${item},${counter})">
                            -
                        </a>
                    </td>
                </tr>
            `);

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


        function getAmount(x) {
            var subTotalAmount = 0;
            var totalAmount = 0;
            var qty = 0;
            var price = 0;

            qty = parseFloat($('#color_wise_quantity' + x).val());
            price = parseFloat($('#color_unit_price' + x).val());

            subTotalAmount = parseFloat(qty * price);


            $('#sub_total' + x).val(subTotalAmount);

            $('.sub_total').each(function () {
                totalAmount += parseFloat($(this).val());
            });

            $('#total_amount').val(totalAmount);
        }

        function calculateQuantity(id) {
            var abc = 0;
            var def = 0;
            $('.color_wise_quantity1_qty_' + id).each(function () {
                abc += parseFloat($(this).val());
            })
            console.log(abc);
            $('.color_wise_quantity' + id).val(abc);

            $('.color_wise_quantity').each(function () {
                def += parseFloat($(this).val());
            })
            $('#total_quantity').val(def);

        }

        function removeRow(x, counter) {
            $('#color_wise_quantity' + x + '_qty_' + counter).parent().parent().remove();
            this.calculateQuantity(x);
            this.getAmount(x);
        }

        function removeRowStatic(x, counter) {
            $('#color_wise_quantity' + x + '_qty_' + counter).parent().parent().remove();
            this.calculateQuantity(x);
            this.getAmount(x);
        }

        function remove_size(x) {
            console.log(x);
            $('.rmv' + x).remove();
            //$('.row-concat' + x + '#row-concat_' + counter).remove();
            this.calculateQuantity(x);
            this.getAmount(x);
        }
    </script>
@endsection
