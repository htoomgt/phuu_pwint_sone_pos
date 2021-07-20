<script>
    $("#btnCreateProduct").on('click', function() {
        let dataToPost = $("#frmCreateProduct").serialize();
        let url = "{{ route('product.addNew') }}";


        if (frmCreateProductValidationStatus.form()) {

            axios({
                    url: url,
                    method: "POST",
                    data: dataToPost
                })
                .then((response) => {
                    if (response.data.status == "success") {
                        Swal.fire({
                                'icon': 'success',
                                'title': 'Product Creating',
                                'text': response.data.messages.request_msg,
                                'confirmButtonText': "OK"
                            })
                            .then((result) => {
                                if (result.isConfirmed) {
                                    window.location = "{{ route('product.showList') }}";
                                }
                            });
                    }
                })
                .catch((error) => {
                    console.log(error)
                });
        }


    })


    resetForm = () => {
        $("#dlCategory").val('').trigger('change');
        $("#dlProductUnit").val('').trigger('change');
    }





    frmCreateProductValidationStatus = $("#frmCreateProduct").validate({
        rules: {
            name: {
                required: true,
                minlength: 5
            },
            myanmar_name: {
                required: true,
                minlength: 3
            },
            product_code: {
                required: true,
                minlength: 3
            },
            category_id: {
                required: true
            },
            measure_unit_id: {
                required: true
            },
            reorder_level: {
                required: true,
                min: 1
            },
            ex_mill_price: {
                min: 1
            },
            transport_fee: {
                min: 1
            },
            unload_fee: {
                min: 1
            },
            unit_price: {
                min: 1
            }

        },
        messages: {
            name: {
                required: "Please enter the product name",
                minlenght: "Please enter at least 5 characters name."
            },
            myanmar_name: {
                required: "Please enter the myanmar name",
                minlength: "Plese enter at least 3 character name"
            },
            product_code: {
                required: "Please enter the product code",
                minlength: "Please enter at least 3 character name"
            },
            category_id: {
                required: "Please choose one category"
            },
            measure_unit_id: {
                required: "Please choose measure munit"
            },
            reorder_level: {
                required: "Please enter reorder level",
                min: "Please enter reorder level at least 1"
            },
            ex_mill_price: {
                min: "Please enter the ex mill price greater than  1"
            },
            transport_fee: {
                min: "Please enter transport fee greater than  1"
            },
            unload_fee: {
                min: "Please enter unload fee greater than 1"
            },
            unit_price: {
                min: "Please enter unit price greater than  1"
            }
        }
    });

    $.validator.addMethod('le', function(value, element, param) {
        return this.optional(element) || value <= $(param).val();
    }, 'Invalid value');

    $.validator.addMethod('ge', function(value, element, param) {
        return this.optional(element) || value >= $(param).val();
    }, 'Invalid value');





    $("#txtExMillPrice").on('change', function() {
        calculateProfitPerUnit();
    });

    $("#txtTransportFee").on('change', function() {
        calculateProfitPerUnit();
    });

    $("#txtUnloadFee").on('change', function() {
        calculateProfitPerUnit();
    });

    $("#txtUnitPrice").on('change', function() {
        calculateProfitPerUnit();
    });

    calculateProfitPerUnit = () => {
        let ex_mill_price = parseInt($("#txtExMillPrice").val());
        let transport_fee = parseInt($("#txtTransportFee").val());
        let unload_fee = parseInt($("#txtUnloadFee").val());
        let unit_price = parseInt($("#txtUnitPrice").val());

        let profit_per_unit = unit_price - (ex_mill_price + transport_fee + unload_fee);

        $("#txtProfitPerUnit").val(profit_per_unit);
    }
</script>
