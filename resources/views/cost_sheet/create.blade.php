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
                        <h4>Create Quotation</h4>
                    </div>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'cost_sheet.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Style No *</label>
                                            <input type="text" name="style_no" class="form-control" placeholder="Enter Style No" required >
                                            @if($errors->has('style_no'))
                                                <span class="text-danger">
                                                    {{ $errors->first('style_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Customer *</label>
                                            <select required name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Customer...">
                                                @foreach ($lims_customer_all as $customer)
                                                     <option value="{{$customer->id}}">{{$customer->name}}</option>
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
                                            <label>Brand/Label *</label>
                                            <input type="text" name="brand" class="form-control" placeholder="Enter Brand or Label" required>
                                            @if($errors->has('brand'))
                                                <span class="text-danger">
                                                   {{ $errors->first('brand') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Size Scale *</label>
                                            <input type="text" name="size_scale" class="form-control" placeholder="Enter Size Scale" required>
                                            @if($errors->has('size_scale'))
                                                <span class="text-danger">
                                                   {{ $errors->first('size_scale') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Item Description *</label>
                                            <input type="text" name="item_description" class="form-control" placeholder="Enter Item Description" required>
                                            @if($errors->has('item_description'))
                                                <span class="text-danger">
                                                   {{ $errors->first('item_description') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Order Quantity *</label>
                                            <input type="text" name="order_quantity" class="form-control" placeholder="Enter Order Quantity" required>
                                            @if($errors->has('order_quantity'))
                                                <span class="text-danger">
                                                   {{ $errors->first('order_quantity') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Target Price *</label>
                                            <input type="text" name="target_price" class="form-control" placeholder="Enter Target Price" required>
                                            @if($errors->has('target_price'))
                                                <span class="text-danger">
                                                   {{ $errors->first('target_price') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                            <div class="break_down">
                                <label>DESCRIPTION OF THE FABRICS</label>
                            </div>


                            <div class="description" style="margin: 10px 0px;">
                                <div class="row">
                                    <div class="col-md-12" style="margin-bottom:20px;">
                                        <table id="dynamicSection" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Fabrics*</th>
                                                    <th>Item Code</th>
                                                    <th>Fabric Description</th>
                                                    <th>Price ($)*</th>
                                                    <th>Consumption*</th>
                                                    <th>Unit</th>
                                                    <th>Wastage (%)*</th>
                                                    <th>Total Cost ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><input type="text" name="fabric[]" value="Fabric-A(Body)" class="form-control" required></td>
                                                    <td><input type="text" name="fabric_item_code[]" value="NF-2384" class="form-control"></td>
                                                    <td width="25%"><input type="text" name="fabric_item_description[]" value='Stretch Denim 57/58"' class="form-control"></td>
                                                    <td width="10%"><input type="number" name="fabric_price[]" id="fabric_price" min="0" step="0.01" class="form-control fabric_price" required></td>
                                                    <td width="10%"><input type="number" name="fabric_consumption[]" id="fabric_consumption" min="0" step="0.01" class="form-control fabric_consumption" required></td>
                                                    <td>
                                                        <select name="fabric_consump_unit[]" required class="form-control">
                                                            <option value="yds">yds</option>
                                                            <option value="kgs">kgs</option>
                                                            <option value="mtrs">mtrs</option>
                                                        </select>
                                                    </td>
                                                    <td width="10%"><input type="number" name="fabric_wastage[]" id="fabric_wastage" min="0" step="1" class="form-control fabric_wastage" required></td>
                                                    <td width="10%"><input type="number" name="fabric_total_price[]" id="fabric_total_price" min="0" class="form-control fabric_total_price" readonly required></td>
                                                    <td><a id="add_description" class="btn btn-success btn-sm" style="color:white;margin-left:10px;">+</a></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Fabric ($)</label>
                                            <input type="text" name="fabric_total_cost" id="fabric_total_cost" class="form-control fabric_total_cost" value="0.00" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Trims ($)</label>
                                            <input type="text" name="trim_total_cost" id="trim_total_cost" class="form-control trim_total_cost" value="0.00" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="break_down">
                                <label>QUOTATION BREAKDOWN</label>
                            </div>
                            <div class="description" style="margin: 10px 0px;">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="dynamicTrim" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Trimming*</th>
                                                    <th>Item Code</th>
                                                    <th>Trimming Description</th>
                                                    <th>Price ($)*</th>
                                                    <th>Consumption*</th>
                                                    <th>Unit</th>
                                                    <th>Wastage (%)*</th>
                                                    <th>Total Cost ($)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($lims_trean_data as $key => $item)
                                                <tr>
                                                    <td><input type="text" name="trimming[]" value="{{$item->trimming}}" class="form-control" required></td>
                                                    <td width="15%"><input type="text" name="trim_item_code[]" value="{{$item->code}}" class="form-control"></td>
                                                    <td><input type="text" name="trim_item_description[]" value="{{$item->description}}" class="form-control"></td>
                                                    <td width="10%"><input type="number" name="trim_price[]" id="trim_price" min="0" step="0.01" class="form-control trim_price" required></td>
                                                    <td width="10%"><input type="number" name="trim_consumption[]" id="trim_consumption" min="0" step="0.01" class="form-control trim_consumption" required></td>
                                                    <td>
                                                        <select name="trim_consump_unit[]" id="" class="form-control">
                                                            <option value="dzn">dzn</option>
                                                            <option value="yds">yds</option>
                                                            <option value="cone">cone</option>
                                                            <option value="pcs">pcs</option>
                                                        </select>
                                                    </td>
                                                    <td width="10%"><input type="number" name="trim_wastage[]" id="trim_wastage" min="0" step="1" class="form-control trim_wastage" required></td>
                                                    <td width="10%"><input type="number" name="trim_total_price[]" id="trim_total_price" min="0" class="form-control trim_total_price" readonly required></td>
                                                    <td class="d-flex">
                                                        @if($key > 0)
                                                            <a id="add_trim_{{ $key }}" class="btn btn-success btn-sm" style="color:white;margin-left:10px;" onclick="rowAppend({{ $key }})" >+</a>
                                                            <a id="remove_trim" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a>
                                                        @else
                                                             <a id="add_trim" class="btn btn-success btn-sm" style="color:white;margin-left:10px;">+</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="break_down">
                                <label></label>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <table id="dynamicTrim" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Making Cost (dzn) *</th>
                                                <th>Washing Cost (dzn) *</th>
                                                <th>Dry Process *</th>
                                                <th>Other Cost *</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="number" name="making_price" id="making_price" min="0" step="0.01" class="form-control making_price" required></td>
                                                <td><input type="number" name="washing_price" id="washing_price" min="0" step="0.01" class="form-control washing_price" required></td>
                                                <td><input type="number" name="dry_process_price" id="dry_process_price" min="0" step="1" class="form-control dry_process_price" required></td>
                                                <td><input type="number" name="other_price" id="other_price" min="0" class="form-control other_price" required></td>
                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-12">
                                    <table id="dynamicTrim" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Washing Description</th>
                                                <th>Dry Process Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><input type="text" name="washing_description" id="washing_description" class="form-control"></td>
                                                <td><input type="text" name="dry_process_description" id="dry_process_description" class="form-control"></td>

                                            </tr>
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top:50px;">
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <table id="dynamicTrim" width="100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                {{-- <th>Wastage (%)</th> --}}
                                                <th>Total Cost ($)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td width="30%"><b>CMPTW</b></td>
                                                <td><input type="number" name="cmptw_wastage" id="cmptw_wastage" min="0" step="1" class="form-control cmptw_wastage" readonly></td>
                                                <td><input type="number" name="cmptw_total_price" id="cmptw_total_price" value="0.00" class="form-control cmptw_total_price" readonly required></td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><b>NET FOB</b></td>
                                                <td><input type="number" name="fob_wastage" id="fob_wastage" min="0" step="1" class="form-control fob_wastage" readonly></td>
                                                <td><input type="number" name="fob_total_price" id="fob_total_price" value="0.00" class="form-control fob_total_price" readonly required></td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><b>TF*</b></td>
                                                <td><input type="number" name="tf_wastage" id="tf_wastage" min="0" step="1" class="form-control tf_wastage" required></td>
                                                <td><input type="number" name="tf_cost" id="tf_total_price" value="0.00" class="form-control tf_total_price" readonly required></td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><b>CTL</b></td>
                                                <td><input type="number" name="cil_wastage" id="cil_wastage" min="0" step="0.1" class="form-control cil_wastage"></td>
                                                <td><input type="number" name="cil_price" id="cil_total_price" value="0.00" class="form-control cil_total_price" readonly></td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><b>COMMERCIAL COST (%)*</b></td>
                                                <td><input type="number" name="commercial_cost" id="commercial_cost" min="0" step="0.1" class="form-control commercial_cost"></td>
                                                <td><input type="number" name="cc_amount" id="total_cc_amount" value="0.00" class="form-control total_cc_amount" readonly></td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><b>TOTAL COST</b></td>
                                                <td><input type="number" name="total_cost_wastage" id="total_cost_wastage" min="0" step="1" class="form-control total_cost_wastage" readonly></td>
                                                <td><input type="number" name="total_cost" id="total_cost_price" value="0.00" class="form-control total_cost_price" readonly required></td>
                                            </tr>
                                            <tr>
                                                <td width="30%"><b>COST PER PC</b></td>
                                                <td ><input type="number" name="wastage_per_pc" id="wastage_per_pc" min="0" step="1" class="form-control wastage_per_pc" readonly></td>
                                                <td ><input type="number" name="cost_per_pc" id="cost_per_pc" value="0.00" class="form-control cost_per_pc" readonly required></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><b>OFFERED FOB *</b></label>
                                        <input type="number" name="offered_fob" class="form-control" step="any" required>
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


<script>

    function rowAppend(id) {
        var area = $('#add_trim_'+id).parent().parent().clone();
        area.find('input').val('');
        $('#add_trim_'+id).parent().parent().after(area);
    }

</script>

<script type="text/javascript">

    $("ul#order-summary").siblings('a').attr('aria-expanded','true');
    $("ul#order-summary").addClass("show");
    $("ul#order-summary #cost-sheet-menu").addClass("active");

    var terms = <?php echo json_encode($lim_payment_terms) ?>;


    $(document).ready(function(){
        var max_field = 5;
        var wrapper = $("#dynamicSection");
        var x = 1;
        $("#add_description").click(function(){
            if(x < max_field){
                x++;
                if(x == 2){
                    fabric = "Fabric-B(Pocketing)";
                    fabric_item_description = "TC Pocketing";
                }else if(x == 3){
                    fabric = "Fabric-C(Contrast)";
                    fabric_item_description = "";
                }else if(x == 4){
                    fabric = "Fabric-D(RIB)";
                    fabric_item_description = "";
                }else{
                    fabric = "";
                    fabric_item_description = "";
                }
                $(wrapper).append('<tr>\
                    <td><input type="text" name="fabric[]" value="'+fabric+'" class="form-control" required></td>\
                    <td><input type="text" name="fabric_item_code[]" class="form-control"></td>\
                    <td><input type="text" name="fabric_item_description[]" value="'+fabric_item_description+'" class="form-control"></td>\
                    <td><input type="number" name="fabric_price[]" id="fabric_price" min="0" step="0.01" class="form-control fabric_price"></td>\
                    <td><input type="number" name="fabric_consumption[]" id="fabric_consumption" min="0" step="0.01" class="form-control fabric_consumption" required></td>\
                    <td>\
                        <select name="fabric_consump_unit[]" id="" class="form-control">\
                            <option value="yds">yds</option>\
                            <option value="kgs">kgs</option>\
                            <option value="mtrs">mtrs</option>\
                        </select>\
                    </td>\
                    <td><input type="number" name="fabric_wastage[]" id="fabric_wastage" min="0" step="1" class="form-control fabric_wastage" required></td>\
                    <td><input type="number" name="fabric_total_price[]" id="fabric_total_price" min="0" class="form-control fabric_total_price" readonly required></td>\
                    <td><a id="remove" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a></td>\
                </tr>');
            }else{
                alert('you can not add more than 5 field');
            }
        });

        $(document).on('click', '#remove', function(){
             $(this).parents('tr').remove();
                x--;
                var sum = 0;
                $(".fabric_total_price").each(function(){
                    sum += +$(this).val();
                });

                $("#fabric_total_cost").val(parseFloat(sum).toFixed(2));

                var cmptw_cost = $("#cmptw_total_price").val();
                var total_netfob = parseFloat(cmptw_cost) + parseFloat(sum);
                $('.fob_total_price').val(parseFloat(total_netfob).toFixed(2));


                var tf_wastage = $('.tf_wastage').val();
                //var total_netfob = $('.fob_total_price').val();
                var parcentage = (tf_wastage / 100);
                var subtotal = total_netfob * parcentage;
                $('.tf_total_price').val(parseFloat(subtotal).toFixed(2));

                //var total_nrtfob = $("#fob_total_price").val();
                //var tf_cost = $("#tf_total_price").val();
                var cil_cost = $('.cil_total_price').val();
                var total_cc_amount = $('.total_cc_amount').val();
                var total_cost = parseFloat(total_netfob) + parseFloat(subtotal) + parseFloat(cil_cost) + parseFloat(total_cc_amount);
                var cost_per_pc = total_cost / 12;

                $("#total_cost_price").val(parseFloat(total_cost).toFixed(2));
                $("#cost_per_pc").val(parseFloat(cost_per_pc).toFixed(2));

        });
    });

    $(document).ready(function(){
        var max_field = 50;
        var wrapper = $("#dynamicTrim");
        var x = 1;

        $("#add_trim").click(function(){
            if(x < max_field){
                x++;
                for (let index = 0; index < terms.length; ++index) {
                    if (x == (index+1)) {
                        console.log(terms[index]['payment_term']);
                        trimming = terms[index]['payment_term'];
                    }
                }
                $(wrapper).append('<tr>\
                    <td><input type="text" name="trimming[]" class="form-control" required></td>\
                    <td><input type="text" name="trim_item_code[]" class="form-control"></td>\
                    <td><input type="text" name="trim_item_description[]" class="form-control"></td>\
                    <td><input type="number" name="trim_price[]" id="trim_price" min="0" step="0.01" class="form-control trim_price" required></td>\
                    <td><input type="number" name="trim_consumption[]" id="trim_consumption" min="0" step="0.01" class="form-control trim_consumption" required></td>\
                    <td>\
                        <select name="trim_consump_unit[]" id="" class="form-control">\
                            <option value="dzn">dzn</option>\
                            <option value="yds">yds</option>\
                            <option value="cone">cone</option>\
                            <option value="pcs">pcs</option>\
                        </select>\
                    </td>\
                    <td><input type="number" name="trim_wastage[]" id="trim_wastage" min="0" step="1" class="form-control trim_wastage" required></td>\
                    <td><input type="number" name="trim_total_price[]" id="trim_total_price" min="0" class="form-control trim_total_price" readonly required></td>\
                    <td><a id="remove_trim" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a></td>\
                </tr>');
            }else{
                alert('you can not add more than 50 field');
            }
        });

        $(document).on('click', '#remove_trim', function(){
             $(this).parents('tr').remove();
             x--;
             var trimsum = 0;
            $(".trim_total_price").each(function(){
                trimsum += +$(this).val();
            });
            $("#trim_total_cost").val(parseFloat(trimsum).toFixed(2));

            var making_cost = $("#making_price").val();
            var washing_cost = $("#washing_price").val();
            var dry_process_cost = $("#dry_process_price").val();
            var other_cost = $("#other_price").val();

            var cmptw_cost = parseFloat(trimsum) + parseFloat(making_cost) + parseFloat(washing_cost)+ parseFloat(dry_process_cost)+ parseFloat(other_cost);
            $('.cmptw_total_price').val(parseFloat(cmptw_cost).toFixed(2));

            var fabric_cost = $("#fabric_total_cost").val();
            var total_netfob = parseFloat(cmptw_cost) + parseFloat(fabric_cost);
            $('.fob_total_price').val(parseFloat(total_netfob).toFixed(2));

            var tf_wastage = $('.tf_wastage').val();
            //var total_netfob = $('.fob_total_price').val();
            var parcentage = (tf_wastage / 100);
            var subtotal = total_netfob * parcentage;
            $('.tf_total_price').val(parseFloat(subtotal).toFixed(2));


            //var total_nrtfob = $("#fob_total_price").val();
            //var tf_cost = $("#tf_total_price").val();
            var cil_cost = $('.cil_total_price').val();
            var total_cc_amount = $('.total_cc_amount').val();
            var total_cost = parseFloat(total_netfob) + parseFloat(subtotal) + parseFloat(cil_cost) + parseFloat(total_cc_amount);
            var cost_per_pc = total_cost / 12;

            $("#total_cost_price").val(parseFloat(total_cost).toFixed(2));
            $("#cost_per_pc").val(parseFloat(cost_per_pc).toFixed(2));


        });
    });


$(document).ready(function () {

    $(document).on('keyup change', '#fabric_price, #fabric_consumption, #fabric_wastage', function() {
        var fabric_price = $(this).closest('tr').find('.fabric_price').val();
        var fabric_consumption = $(this).closest('tr').find('.fabric_consumption').val();
        var fabric_wastage = $(this).closest('tr').find('.fabric_wastage').val();
        var parcentage = ((fabric_price * fabric_consumption) * (fabric_wastage / 100));
        var subtotal = fabric_price * fabric_consumption;
        var tatal = subtotal+parcentage;
        $(this).closest('tr').find('.fabric_total_price').val(tatal.toFixed(2));

    });


    $(document).on("change keyup", "#fabric_price , #fabric_consumption, #fabric_wastage", function() {
        var sum = 0;
        $(".fabric_total_price").each(function(){
            sum += +$(this).val();
        });
        $("#fabric_total_cost").val(parseFloat(sum).toFixed(2));

       var cmptw_cost = $("#cmptw_total_price").val();
       var total_netfob = parseFloat(cmptw_cost) + parseFloat(sum);
       $('.fob_total_price').val(parseFloat(total_netfob).toFixed(2));

        var tf_wastage = $('.tf_wastage').val();
        //var total_netfob = $('.fob_total_price').val();
        var parcentage = (tf_wastage / 100);
        var subtotal = total_netfob * parcentage;
        $('.tf_total_price').val(parseFloat(subtotal).toFixed(2));

        //var total_nrtfob = $("#fob_total_price").val();
        //var tf_cost = $("#tf_total_price").val();
        var cil_cost = $('.cil_total_price').val();
        var total_cc_amount = $('.total_cc_amount').val();
        var total_cost = parseFloat(total_netfob) + parseFloat(subtotal) + parseFloat(cil_cost) + parseFloat(total_cc_amount);
        var cost_per_pc = total_cost / 12;

        $("#total_cost_price").val(parseFloat(total_cost).toFixed(2));
        $("#cost_per_pc").val(parseFloat(cost_per_pc).toFixed(2));

    });

    $(document).on('keyup change', '#trim_price, #trim_consumption, #trim_wastage', function() {
        //var trim_total_price = 0;
        var trim_price = $(this).closest('tr').find('.trim_price').val();
        var trim_consumption = $(this).closest('tr').find('.trim_consumption').val();
        var trim_wastage = $(this).closest('tr').find('.trim_wastage').val();
        var parcentage = ((trim_price * trim_consumption) * (trim_wastage / 100));
        var subtotal = trim_price * trim_consumption;
        var tatal = subtotal+parcentage;
        $(this).closest('tr').find('.trim_total_price').val(tatal.toFixed(2));
    });

    $(document).on("change keyup", '#trim_price, #trim_consumption, #trim_wastage', function() {
        var trimsum = 0;
        $(".trim_total_price").each(function(){
            trimsum += +$(this).val();
        });
        $("#trim_total_cost").val(parseFloat(trimsum).toFixed(2));

       var making_cost = $("#making_price").val();
       if (isNaN(making_cost)) making_cost = 0;

       var washing_cost = $("#washing_price").val();
       if (isNaN(washing_cost)) washing_cost = 0;

       var dry_process_cost = $("#dry_process_price").val();
       if (isNaN(dry_process_cost)) dry_process_cost = 0;

       var other_cost = $("#other_price").val();
       if (isNaN(other_cost)) other_cost = 0;

       var cmptw_cost = parseFloat(trimsum) + parseFloat(making_cost) + parseFloat(washing_cost) + parseFloat(dry_process_cost)+ parseFloat(other_cost);
       $('.cmptw_total_price').val(parseFloat(cmptw_cost).toFixed(2));

       var fabric_cost = $("#fabric_total_cost").val();
       var total_netfob = parseFloat(cmptw_cost) + parseFloat(fabric_cost);
       $('.fob_total_price').val(parseFloat(total_netfob).toFixed(2));


        var tf_wastage = $('.tf_wastage').val();
        //var total_netfob = $('.fob_total_price').val();
        var parcentage = (tf_wastage / 100);
        var subtotal = total_netfob * parcentage;
        $('.tf_total_price').val(parseFloat(subtotal).toFixed(2));


       var total_nrtfob = $("#fob_total_price").val();
       var tf_cost = $("#tf_total_price").val();
       var cil_cost = $('.cil_total_price').val();
       var total_cc_amount = $('.total_cc_amount').val();
       var total_cost = parseFloat(total_nrtfob) + parseFloat(tf_cost) + parseFloat(cil_cost) + parseFloat(total_cc_amount);
       var cost_per_pc = total_cost / 12;

       $("#total_cost_price").val(parseFloat(total_cost).toFixed(2));
       $("#cost_per_pc").val(parseFloat(cost_per_pc).toFixed(2));

    });


    $(document).on('keyup change', '#making_price, #washing_price, #dry_process_price, #other_price', function() {
        cmptw();
        net_fob();
        total_cost();
    });

    $(document).on('keyup change', '#tf_wastage', function() {
        var tf_wastage = $('.tf_wastage').val();
        var total_netfob = $('.fob_total_price').val();
        var parcentage = (tf_wastage / 100);
        var subtotal = total_netfob * parcentage;
        $('.tf_total_price').val(parseFloat(subtotal).toFixed(2));
        total_cost();
    });

    $(document).on('keyup change', '#cil_wastage', function() {
        var cil_wastage = $('.cil_wastage').val();
        $('.cil_total_price').val(parseFloat(cil_wastage).toFixed(2));
        total_cost();
    });

    $(document).on('keyup change', '#commercial_cost', function() {
        var commercial_cost = $('.commercial_cost').val();
        var fob_total_price = $('#fob_total_price').val();
        var totalCCAmount= (commercial_cost*fob_total_price)/100;
        // $('.total_cc_amount').val(parseFloat(commercial_cost).toFixed(2));
        $('.total_cc_amount').val(parseFloat(totalCCAmount).toFixed(2));
        total_cost();
    });

    function cmptw(){
       var total_trim = $("#trim_total_cost").val();

       var making_cost = $("#making_price").val();
       if (isNaN(making_cost)) making_cost = 0;

       var washing_cost = $("#washing_price").val();
       if (isNaN(washing_cost)) washing_cost = 0;

       var dry_process_cost = $("#dry_process_price").val();
       if (isNaN(dry_process_cost)) dry_process_cost = 0;

       var other_cost = $("#other_price").val();
       if (isNaN(other_cost)) other_cost = 0;

       var cmptw_cost = parseFloat(total_trim) + parseFloat(making_cost) + parseFloat(washing_cost)+ parseFloat(dry_process_cost)+ parseFloat(other_cost);
       console.log(cmptw_cost);

       $('.cmptw_total_price').val(parseFloat(cmptw_cost).toFixed(2));
   }
   function net_fob(){
       var cmptw_cost = $("#cmptw_total_price").val();
       var fabric_cost = $("#fabric_total_cost").val();
       var total_netfob = parseFloat(cmptw_cost) + parseFloat(fabric_cost);
       $('.fob_total_price').val(parseFloat(total_netfob).toFixed(2));
   }
   function total_cost(){
       var total_nrtfob = $("#fob_total_price").val();
       var tf_cost = $("#tf_total_price").val();
       var cil_cost = $('.cil_total_price').val();
       var total_cc_amount = $('.total_cc_amount').val();
       var total_cost = parseFloat(total_nrtfob) + parseFloat(tf_cost) + parseFloat(cil_cost) + parseFloat(total_cc_amount);
       var cost_per_pc = total_cost / 12;

       $("#total_cost_price").val(parseFloat(total_cost).toFixed(2));
       $("#cost_per_pc").val(parseFloat(cost_per_pc).toFixed(2));
   }


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
