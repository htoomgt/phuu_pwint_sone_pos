<script>
        $("#btnCreateProduct").on('click', function(){
            let dataToPost = $("#frmCreateProduct").serialize();
            let url = "{{route('product.addNew')}}";

            if(frmCreateProductValidationStatus.form())
            {
                axios({
                    url : url,
                    method : "POST",
                    data : dataToPost
                })
                .then((response)=>{
                    if(response.data.status == "success"){
                        Swal.fire({
                            'icon' : 'success',
                            'title' : 'Product Creating',
                            'text' : response.data.messages.request_msg,
                            'confirmButtonText' : "OK"
                        })
                        .then((result)=>{
                            if(result.isConfirmed){
                                window.location = "{{route('product.showList')}}";
                            }
                        });
                    }
                })
                .catch((error)=>{
                    console.log(error)
                });
            }


        })

        frmCreateProductValidationStatus = $("#frmCreateProduct").validate({
            rules : {
                name : {
                    required : true,
                    minlenght : 5
                }
            },
            messages : {
                name : {
                    required : "Please enter the product name",
                    minlenght : "Please enter at least 5 characters name."
                }
            }
        });


        /* $("#txtExMillPrice").on('change', function(){
            let ex_mill_price = $("#txtExMillPrice").val;
            let transport_fee = $("#txtTransportFee").val;
            let unload_fee = $("#txtUnloadFee").val;

        }) */

</script>
