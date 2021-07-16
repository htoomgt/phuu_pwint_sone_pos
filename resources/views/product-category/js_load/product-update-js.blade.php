<script>
    productCategoryEdit = async (id=0) => {
        console.log(id);

        // Modal Show
        $("#mdlUpdateProductCategory").modal('show');

        // Form reset
        $("#frmUpdateProductCategory").trigger('reset');


        // Get data by Id and load to form
        let productCategory = null;


        let resp = await axios.get("{{route('productCategory.getDataRowById')}}", { params : {id : id}});

        productCategory = resp.data.data;

        $("#txtProductCategoryNameUpdate").val(productCategory.name);
        $("#h_product_category_update_id").val(productCategory.id);



    }

    $("#btnProductCategoryUpdate").on('click', function(){
        if(productCategoryCreateValidationStatus.form()){

            let dataToPost = $("#frmUpdateProductCategory").serialize();
            let url = "{{route('productCategory.updateById')}}";

            axios({
                url : url,
                method : "PUT",
                data : dataToPost,
                type : "application/json"
            }).then(function(response){
                if (response.data.status == "success") {
                    Swal.fire({
                        icon: 'success',
                        title: 'Update a product category',
                        text: response.data.messages.request_msg,
                        confirmButtonText: "OK"
                    }).then((result) => {
                        $("#mdlUpdateProductCategory").modal('hide');
                    });

                    $("#dtProductCategory").DataTable().ajax.reload();
                }

            }).catch(error => {
                console.log(error);
            })

        }
    })



    productCategoryCreateValidationStatus = $("#frmUpdateProductCategory").validate({
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
