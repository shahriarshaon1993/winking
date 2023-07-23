@extends('layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Commercial Invoice Edit</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        {!! Form::open(['route' => ['commercial-invoice.update', $data->id ], 'method' => 'post']) !!}
                        @csrf
                        @method('put')
                        <input type="hidden" id="id" name="id">
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label>Date *</label>
                                    <input type="date" name="date" value="{{$data->date}}" class="form-control" required>
                                     @error('date')
                                        <p style="color: red">{{ $message }}</p>
                                     @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label>Invoice Number *</label>
                                    <select name="export_id" id="export-id" class="form-control" required>
                                        <option value="">Select Invoice Number</option>
                                        @foreach ($exports as $export)
                                            <option  @if($data->export_id == $export->id ) selected @endif value="{{ $export->id }}">{{ $export->invoice_no }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('export_id')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Invoice amount *</label>
                                    <input type="number" name="value" id="value" value="{{$data->export->invoice_value}}" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Lc No *</label>
                                    <input type="text" value="{{$data->export->lc_number}}" name="invoice_no" id="invoice-no" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Invoice Date *</label>
                                    <input type="date" name="invoice_date" value="{{$data->export->date}}" id="invoice-date" class="form-control" readonly>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Exp No *</label>
                                    <input type="text" name="exp_no" id="exp_no" class="form-control" value="{{ $data->exp_no }}" placeholder="Enter exp no.">
                                    @error('exp_no')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Shipment Terms *</label>
                                    <input type="text" name="shipment_terms" id="shipment_terms" class="form-control" value="{{$data->shipment_terms}}" placeholder="Enter shipment terms">
                                    @error('shipment_terms')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Payment Terms *</label>
                                    <input type="text" name="payment_terms" id="payment_terms" class="form-control" value="{{$data->payment_terms}}" placeholder="Enter payment terms">
                                    @error('payment_terms')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Port Of Loading *</label>
                                    <input type="text" name="port_loading" id="port_loading" value="{{ $data->port_loading }}" class="form-control" placeholder="Enter port of loading">
                                    @error('port_loading')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-md-4 form-group">
                                    <label>Port Of Destination *</label>
                                    <input type="text" name="port_destination" id="port_destination" value="{{$data->port_destination}}"  class="form-control" placeholder="Enter port of destination">
                                    @error('port_destination')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label> Notify Party *</label>
                                    <select name="notify_party" id="notify_party" class="form-control" required>
                                        <option value="">Select Party</option>
                                        @foreach ($party as $value)
                                            <option  @if($data->notify_party == $value->id ) selected @endif value="{{ $value->id }}">{{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('notify_party')
                                        <p style="color: red">{{ $message }}</p>
                                     @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label> Bank *</label>
                                    <select name="bank_id" id="bank_id" class="form-control" required>
                                        <option value="">Select Bank</option>
                                        @foreach ($banks as $bank)
                                            <option  @if($data->bank_id == $bank->id ) selected @endif value="{{ $bank->id }}">{{ $bank->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <p style="color: red">{{ $message }}</p>
                                     @enderror
                                </div>

                                <div class="col-md-4 form-group">
                                    <label> Bank Branch *</label>
                                    <select name="branch_id" id="branch_id" class="form-control selectpicker" required>
                                        <option value="">Select Branch</option>
                                        @foreach ($branches as $branch)

                                        <option  @if($data->branch_id == $branch->id ) selected @endif value="{{ $branch->id }}">
                                            {{ $branch->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('branch_id')
                                        <p style="color: red">{{ $message }}</p>
                                     @enderror
                                </div>
                            </div>

                            @php
                                $description_good = json_decode($data->description_good, true);
                                $ctn_qty = json_decode($data->ctn_qty, true);
                                $quantity_pcs = json_decode($data->quantity_pcs, true);
                                $unit_price = json_decode($data->unit_price, true);
                                $total_price = json_decode($data->total_price, true);
                            @endphp

                            @foreach( $description_good as $key => $value )
                                <div class="row" id="row_del">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="description_good">Description Of Goods *</label>
                                            <textarea name="description_good[]" id="description_good" rows="2">{{$description_good[$key]}}</textarea>
                                            @error('description_good')
                                             <p style="color: red">{{ $message }}</p>
                                            @enderror

                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="ctn_qty">CTN QTY *</label>
                                            <input type="number" name="ctn_qty[]" id="ctn_qty" value="{{ $ctn_qty[$key] }}" class="form-control" placeholder="Enter ctn quantity " >
                                            @error('ctn_qty')
                                             <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="quantity_pcs">Quantity in Pcs *</label>
                                            <input type="number" oninput="QuantityPcs({{ $key }})" name="quantity_pcs[]" id="quantity_pcs{{ $key }}" value="{{ $quantity_pcs[$key] }}" class="form-control quantity_pcs" placeholder="Enter quantity" >
                                            @error('quantity_pcs')
                                             <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="unit_price">Unit Price in US $ *</label>
                                            <input type="number" oninput="CalculatePrice({{ $key }})" name="unit_price[]" id="unit_price{{ $key }}" value="{{ $unit_price[$key] }}" class="form-control unit_price" placeholder="Enter unit price" >
                                            @error('unit_price')
                                             <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-sm-2">
                                        <div class="form-group">
                                            <label for="total_price">Total Price In US $ *</label>
                                            <input type="text" name="total_price[]" id="total_price{{ $key }}" value="{{ $total_price[$key] }}" class="form-control total_price" readonly>
                                            @error('total_price')
                                             <p style="color: red">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>

                                    @if ($key == 0)
                                    <div class="col-sm-1">
                                        <div class="form-group">
                                            <button style="margin-top: 31px" type="button" name="add" id="add" class="btn btn-success">+</button>
                                        </div>
                                    </div>

                                    @else

                                    <div class="col-sm-1">
                                    <div class="form-group">
                                        <button style="margin-top: 31px" type="button" name="row_remove" id="row_remove" class="btn btn-danger row_remove btn_remove">-</button>
                                    </div>
                                </div>
                                    @endif
                                </div>
                                @endforeach

                                <section id="AddField">

                                </section>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{trans('file.update')}}</button>
                                </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>

    $(document).ready(function(){
        $('#export-id').on('change', function(){
            var exportId= $('#export-id').val();
            var url = '{{ route("get-export") }}';
            if(exportId){
                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    data: {
                        exportId: exportId
                    },

                    success: function(data){
                        $('#value').val(data.invoiceAmount);
                        $('#invoice-no').val(data.lcNumber);
                        $('#invoice-date').val(data.invoiceDate);
                    }
                });
            }
        });

        $('#bank_id').on('change', function(){
        $('#branch_id').empty();
        var bank_id = $("#bank_id").val();
        var url = "{{route('all.bank.branches')}}";
            $.ajax({
                type: "get",
                url: url,
                data: {
                    bank_id: bank_id
                },
                success: function(data){
                 $('#branch_id').append("<option value=''> Select Branch </option>");
                $.each(data, function(key, value){
                    $('#branch_id').append("<option value="+value.id+">"+value.name+"</option>");
                });
                $('.selectpicker').selectpicker('refresh');
            },
        });
    });

        var i = 1;
        $("#add").click(function () {
            if( i < 5 ){
            ++i;
            $("#AddField").append('<div class="row remove">\
    <div class="col-sm-3">\
        <div class="form-group">\
            <label for="description_good">Description Of Goods *</label>\
            <textarea name="description_good[]" id="description_good" rows="2"></textarea>\
            @error('description_good')\
             <p style="color: red">{{ $message }}</p>\
            @enderror\
        </div>\
    </div>\
    <div class="col-sm-2">\
        <div class="form-group">\
            <label for="ctn_qty">CTN QTY *</label>\
            <input type="number" name="ctn_qty[]" id="ctn_qty'+i+'" value="{{ old('ctn_qty') }}" class="form-control" placeholder="Enter ctn quantity " >\
            @error('ctn_qty')\
             <p style="color: red">{{ $message }}</p>\
            @enderror\
        </div>\
    </div>\
    <div class="col-sm-2">\
        <div class="form-group">\
            <label for="quantity_pcs">Quantity in Pcs *</label>\
            <input type="number" oninput="QuantityInPcs('+i+')" name="quantity_pcs[]" id="quantity_pcs'+i+'" value="{{ old('quantity_pcs') }}" class="form-control" placeholder="Enter quantity" >\
            @error('quantity_pcs')\
             <p style="color: red">{{ $message }}</p>\
            @enderror\
        </div>\
    </div>\
    <div class="col-sm-2">\
        <div class="form-group">\
            <label for="unit_price">Unit Price in US $ *</label>\
            <input type="number" oninput="CalculateUnitPrice('+i+')" name="unit_price[]" id="unit_price'+i+'" value="{{ old('unit_price') }}" class="form-control" placeholder="Enter unit price" >\
            @error('unit_price')\
             <p style="color: red">{{ $message }}</p>\
            @enderror\
        </div>\
    </div>\
    <div class="col-sm-2">\
        <div class="form-group">\
            <label for="total_price">Total Price In US $ *</label>\
            <input type="text" name="total_price[]" id="total_price'+i+'" value="{{ old('total_price') }}" class="form-control" readonly>\
            @error('total_price')\
             <p style="color: red">{{ $message }}</p>\
            @enderror\
        </div>\
        </div>\
        <div class="col-sm-1">\
            <div class="form-group">\
                <button style="margin-top: 31px" type="button" id="btnRemove" class="btn btn-danger btnRemove">-</button>\
            </div>\
        </div>\
    </div>\
    ');
        }else{
            alert("You've exhausted all of your options");
        }
        // calculation
    });

    $(document).on('click', '#btnRemove', function() {
        $(this).parents('.remove').remove();
        i--;
    });

    });

                $('.row_remove').on('click', function() {
                    var data = confirm("Are you sure want to remove. ");

                    if (data == true) {
                        $(this).parents('#row_del').remove();
                    }
                    else {
                        return false;
                    }
                });

    function CalculatePrice(value){
            var quantity_pcs = $('#quantity_pcs'+value).val();
            var unit_price = $('#unit_price'+value).val();
            var sum = parseFloat(quantity_pcs) * parseFloat(unit_price);
            $('#total_price'+value).val(sum);
        }

        function QuantityPcs(value){
            var quantity_pcs = $('#quantity_pcs'+value).val();
            var unit_price = $('#unit_price'+value).val();
            var sum = parseFloat(quantity_pcs) * parseFloat(unit_price);
            $('#total_price'+value).val(sum);
        }

        function CalculateUnitPrice(value){
            var quantity_pcs = $('#quantity_pcs'+value).val();
            var unit_price = $('#unit_price'+value).val();
            var sum = parseFloat(quantity_pcs) * parseFloat(unit_price);
            $('#total_price'+value).val(sum);
        }

        function QuantityInPcs(value){
            var quantity_pcs = $('#quantity_pcs'+value).val();
            var unit_price = $('#unit_price'+value).val();
            var sum = parseFloat(quantity_pcs) * parseFloat(unit_price);
            $('#total_price'+value).val(sum);
        }

</script>

@endsection
