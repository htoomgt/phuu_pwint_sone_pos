<script>
    let formatNum;
    dropDownRefresh();
    let currentDateTime = moment().format('yyyy-MM-DDTHH:mm');
    $("#voucher_datetime").val(currentDateTime);
    $("#btnPrint").attr('disabled', true);
    let frmSaleVoucherValidationStatus;
    $("#btnRemoveVooucher").attr('disabled', true);
    $("#btnAddItem").attr('disabled', false);
    $("#total_amount_label").html(
        '0 MMK'
        );
    let saleId = 0;

    let itemIndex = 0;

    $("body").on('click', '#btnAddItem', function(e) {
        e.preventDefault();
        itemIndex++;




        let itemRowHtml = `
        <tr id="item_row_` + itemIndex + `">
            <td>
                <select name="product_id[` + itemIndex + `]" id="product_id_` + itemIndex + `" class="select2ProductAllByName" style="width:100%;">
                    <option></option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="unit[` + itemIndex + `]" id="unit_` + itemIndex + `" readonly  />

            </td>
            <td>
                <input type="text" class="form-control" name="unit_price[` + itemIndex + `]" id="unit_price_` +
            itemIndex + `" readonly />
            </td>
            <td>
                <input type="number" class="form-control input_quantity" name="quantity[` + itemIndex +
            `]" id="quantity_` + itemIndex + `" value="" min="1"/>
            </td>
            <td>
                <input type="number"  class="form-control" name="amount[` + itemIndex + `]" id="amount_` + itemIndex + `"  value="0" readonly />

            </td>
            <td>
                <button class="btn btn-outline-danger btnRemoveItem" id="btnRemoveItem_` + itemIndex + `">
                    <i class="fas fa-times-circle"></i>
                </button>
            </td>
        </tr>
        `;



        $("#voucher_items").append(itemRowHtml);
        dropDownRefresh();
    })

    $("body").on('click', '.btnRemoveItem', function() {
        let btnRemoveItemId = $(this).attr('id');
        let itemIndex = btnRemoveItemId.substring(14);

        let selectorToRemove = "#item_row_" + itemIndex;
        $(selectorToRemove).remove();

    })

    $("#voucher_items").on('change', '.select2ProductAllByName', function() {
        let ddlProductId = $(this).attr('id');
        let itemIndex = ddlProductId.substring(11);
        $(this).valid();

        let selectedProductId = $(this).val();

        $("#unit_" + itemIndex).val("");
        $("#unit_price_" + itemIndex).val("");

        if (selectedProductId != "") {
            axios({
                    url: "{{ route('product.getDataRowById') }}",
                    method: "GET",
                    params: {
                        id: selectedProductId
                    }
                })
                .then((response) => {
                    if (response.data.status == 'success') {
                        product = response.data.data;

                        $("#unit_" + itemIndex).val(product.measure_unit.name);
                        $("#unit_price_" + itemIndex).val(parseInt(product.unit_price));

                    }
                })
                .catch((error) => {
                    console.log(error);
                })
        }


    })

    $("#voucher_items").on('keyup change', '.input_quantity', function() {
        let inputQuantityId = $(this).attr('id');
        let qty = $(this).val();

        let itemIndex = inputQuantityId.substring(9);

        let unitPrice = $("#unit_price_" + itemIndex).val();

        let amount = unitPrice * qty;

        $("#amount_" + itemIndex).val(amount);

        let totalAmount = 0;

        for (i = 0; i <= itemIndex; i++) {
            let amountToAdd = $("#amount_" + i).val();
            amountToAdd = parseInt(amountToAdd);

            totalAmount += amountToAdd;
        }

        $("#total_amount").val(totalAmount);
        let labelTotalAmount = numFormat(totalAmount);
        $("#total_amount_label").html(labelTotalAmount +
            ` MMK`
            );
        // $("#total_amount").digits();
        // console.log(formatNum(totalAmount));

    })

    $("#btnPay").on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sale.payment') }}";
        let dataToPost = $("#frmSaleVoucher").serialize();





        addValidationRules();



        if (frmSaleVoucherValidationStatus.form()) {
            axios({
                    url: url,
                    method: "POST",
                    data: dataToPost
                })
                .then((response) => {
                    if (response.data.status == 'success') {
                        $("#btnPay").attr('disabled', true);
                        $("#btnPrint").attr('disabled', false);
                        $("#btnRemoveVooucher").attr('disabled', false);
                        $("#btnAddItem").attr('disabled', true);
                        saleId = response.data.data.sale_id;

                        Swal.fire({
                            icon: 'success',
                            title: 'Sale Record and Payment',
                            text: response.data.messages.request_msg,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch((error) => {
                    console.log(response);
                })
        }





    })

    $("#btnPrint").on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sale.printSlip') }}";
        let dataToPost = $("#frmSaleVoucher").serialize();



        addValidationRules();

        if (frmSaleVoucherValidationStatus.form()) {
            axios({
                    url: url,
                    method: "POST",
                    data: dataToPost
                })
                .then((response) => {
                    if (response.data.status == 'success') {
                        $("#btnPay").attr('disabled', true);
                        $("#btnPrint").attr('disabled', false);

                        Swal.fire({
                            icon: 'success',
                            title: 'Slip Printing',
                            text: response.data.messages.request_msg,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch((error) => {
                    console.log(response);
                })
        }


    })

    frmSaleVoucherValidationStatus = $("#frmSaleVoucher").validate({
        rules: {
            sale_datetime: {
                required: true
            },
            'product_id[0]': {
                required: true
            },
            'quantity[0]': {
                required: true
            },
            customer_paid_amount: {
                required: true
            }
        },
        messages: {
            sale_datetime: {
                required: "Please enter voucher date time!"
            },
            'product_id[0]': {
                required: "Please choose a product here!"
            },
            'quantity[0]': {
                required: "Please enter a quantity"
            },
            customer_paid_amount: {
                required: "Please enter the customer paid amount"
            }

        }
    });

    function addValidationRules() {
        $('.select2ProductAllByName').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please choose a product"
                }
            });


        })




        $('.input_quantity').each(function() {
            $(this).rules("add", {
                required: true,
                messages: {
                    required: "Please enter product quantity"
                }
            });

        })
    }

    $("#btnRemoveVooucher").on('click', function(e) {
        e.preventDefault();
        let url = "{{ route('sale.delete') }}";
        let dataToPost = {
            "id": saleId
        };

        Swal.fire({
            icon: "warning",
            title: "Are you sure to delete this sale voucher?",
            confirmButtonText: "<i class='far fa-trash-alt'></i> Delete it ",
            showCancelButton: true,
            cancelButtonText: 'No, cancel'

        }).then((result) => {
            if (result.isConfirmed) {
                axios({
                    url: url,
                    method: "DELETE",
                    data: dataToPost,
                }).then((response) => {
                    if (response.data.status == 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleting sale voucher',
                            text: response.data.messages.request_msg,
                            confirmButtonText: "OK"
                        })
                    }
                }).catch((error) => {
                    console.log(error.response);
                    Swal.fire({
                        icon: 'error',
                        title: 'Deleting sale voucher',
                        text: error.response.data.messages.request_msg,
                        confirmButtonText: "OK"
                    })
                })
            }
        })




        // alert("Your voucher has been removed!");
    })

    $(document).on("click", ".copyToClipboard", function(e){
        e.preventDefault();
        console.log('copy to clipboard clicked')
        let valToCopy = $("#total_amount").val();
        $("#customer_paid_amount").val(valToCopy);
    })


    $(".copyToClipboard").tooltip();



</script>
