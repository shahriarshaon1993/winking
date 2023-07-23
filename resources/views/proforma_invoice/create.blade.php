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
                        <h4>Add Proforma Invoice</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => 'proforma_invoice.store', 'method' => 'post', 'files' => true, 'id' => 'purchase-form']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice No *</label>
                                            <input type="text" name="invoice_no" class="form-control" placeholder="Enter Invoice No" required>
                                            @if($errors->has('invoice_no'))
                                                <span class="text-danger">
                                                    {{ $errors->first('invoice_no') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date *</label>
                                            <input type="text" name="date" class="datepicker form-control" placeholder="Enter Date" required>
                                            @if($errors->has('date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Invoice To *</label>
                                            <select name="invoice_to_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select invoice to...">
                                                @foreach ($lims_invoice_to_all as $invoice)
                                                    <option value="{{ $invoice->id }}">{{ $invoice->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('invoice_to_id'))
                                                <span class="text-danger">
                                                    {{ $errors->first('invoice_to_id') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Revised Date</label>
                                            <input type="text"
                                            placeholder="Enter Revised Date"name="revised_date" class="datepicker form-control">
                                            @if($errors->has('revised_date'))
                                                <span class="text-danger">
                                                   {{ $errors->first('revised_date') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6">
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
                                            <label>Customer *</label>
                                            <select name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select invoice to...">
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
                                            <label>Season</label>
                                            <input type="text" name="season" class="form-control" placeholder="Enter Season">
                                            @if($errors->has('season'))
                                                <span class="text-danger">
                                                   {{ $errors->first('season') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Delivery Date *</label>
                                            <input type="text" name="delivery_date" class="datepicker form-control"
                                            placeholder="Enter Delivery Date" required>
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
                                            <input type="number" name="total_qty" min="0" id="total_qty" class="form-control total_qty" placeholder="Enter Total Quantity" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Total Amount *</label>
                                            <input type="number" name="total_amount" id="total_amount"

                                            placeholder="Enter Total Amount" class="form-control total_amount" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Order Status *</label>
                                            <select name="status" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select status...">
                                                <option value="Running">Running</option>
                                                <option value="Delivered">Delivered</option>
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
                                            <label>Upload Proforma Invoice *</label>
                                            <input type="file" name="document" class="form-control" required/>
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
    $("ul#order-summary #proforma-invoice-menu").addClass("active");


    $(document).ready(function(){
        var max_field = 5;
        var wrapper = $("#table_body2");
        var x = 1;
        $("#add_instruction").click(function(){
            if(x < max_field){
                x++;
                $(wrapper).append('<tr>\
                            <td width="98%"><input type="text" name="instruction[]" class="form-control"></td>\
                            <td><a id="remove_ins" class="btn btn-danger btn-sm" style="color:white;margin-left:10px;">-</a></td>\
                        </tr>');
            }else{
                alert('you can not add more than 5 field');
            }
        });
        $(document).on('click', '#remove_ins', function(){
             $(this).parents('tr').remove();
        });
    });
    $(document).ready(function(){
        var max_field = 20;
        var wrapper = $("#table_body");
        var x = 1;
        $("#add_description").click(function(){
            if(x < max_field){
                x++;
                $(wrapper).append('<tr>\
                            <td width="12%"><input type="text" name="po[]" class="form-control" required></td>\
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
                var sum_client = 0;
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
        //$(".total").val(sum);
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
