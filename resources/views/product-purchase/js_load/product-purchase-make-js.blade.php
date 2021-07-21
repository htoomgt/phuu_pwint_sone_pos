<script>
    $("#btnProductPurchaseMake").on('click', function(e) {
        e.preventDefault();

        let datatToPost = $("#frmProductPurchaseMake").serialize();

        let url = "{{ route('productPurchase.addNew') }}";

        axios({
                url: url,
                method: "POST",
                data: datatToPost
            })
            .then((response) => {
                console.log(response.data)
            })
            .catch((error) => {

            })



    })


    $(".select2Product").on('change', function() {
        let productId = $(this).val();
        let selectorId = $(this).attr('id');


        let inputIndex = selectorId.substring(11);
        let productCodeId = "#product_code_"+inputIndex;
        let productMeasureUnitId = "#product_measure_unit_"+inputIndex;


        axios({
            url : "{{route('product.getDataRowById')}}",
            method : "GET",
            params : { id : productId},
        })
        .then((response)=> {
            let row = response.data.data;

            $(productCodeId).val(row.product_code);
            $(productMeasureUnitId).val(row.measure_unit.name);
        })
        .catch((error)=> {
            console.log(error)
        })






    })

    $('.add-product').on('click', function(){

    })

    $('.remove-product').on('click', function(){

})

</script>
