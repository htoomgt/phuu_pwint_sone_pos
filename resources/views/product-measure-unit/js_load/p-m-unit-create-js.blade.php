<script>
    $("#btnProductMeasureUnitCreate").on('click', function(){
        if(productMeasureUnitValidationStatus.form()){
            let dataToPost = $("#frmCreateProductMeasureUnit").serialize();
            let url = "{{route('productMeasureUnit.addNew')}}";

            axios({
                url : url,
                method : "POST",
                data : dataToPost,
                type : 'application/json'
            }).then(function(response){
                if(response.data.status == 'success')
                {
                    Swal.fire({
                        icon : 'success',
                        title : 'Creating a product measure unit',
                        text : response.data.messages.request_msg,
                        confirmButtonText : "OK"
                    }).then((result)=>{
                        $("#mdlCreateProductMeasureUnit").modal('hide');
                    })

                    $("#dtProductMeasureUnit").DataTable().ajax.reload();
                }
            }).catch(function(error){
                console.log(error);
            })


        }
    })

    productMeasureUnitValidationStatus = $("#frmCreateProductMeasureUnit").validate({
        rules : {
            name : {
                required : true
            }
        },
        messages : {
            name : {
                required : "The product measure unit is required!"
            }
        }
    })
</script>
