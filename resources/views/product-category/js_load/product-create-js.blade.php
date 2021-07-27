<script>
    let productCategoryCreateValidationStatus;

    $("#btnAddNew").on('click', function(){
        $("#frmCreateProductCategory").trigger('reset');
    })


    $("#btnProductCategoryCreate").on('click', function(e) {
        if (productCategoryCreateValidationStatus.form()) {
            let dataToPost = $("#frmCreateProductCategory").serialize();
            let url = "{{ route('productCategory.addNew') }}";
            axios({
                url: url,
                method: 'POST',
                data: dataToPost,
                type: 'json'
            }).then(function(response) {
                if (response.data.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Create a product category',
                        text: response.data.messages.request_msg,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        $("#mdlCreateProductCategory").modal('hide');
                    });

                    $("#dtProductCategory").DataTable().ajax.reload();
                }
            })

        }

    })

    productCategoryCreateValidationStatus = $("#frmCreateProductCategory").validate({
        rules: {
            name: {
                required: true,
                minlength: 5,
            }
        },
        messages: {
            name: {
                required: "Please enter the product category",
                minlength: "Please enter at least 5 character"
            }
        }
    });
</script>
