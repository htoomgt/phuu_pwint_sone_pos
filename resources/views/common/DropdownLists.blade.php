<script>

    // Role
    $(".select2Role").select2({
        placeholder: "Select a role",
        allowClear: true,
        ajax: {
            url : "{{route('dropdownData.getAllRoles')}}",
            method : "POST",
            dataType : "json",

            data : function(params){
                let dataToPost = {
                    _token : $("meta[name='csrf-token']").attr("content"),
                    search : params.term
                }
                return dataToPost;
            },
            processResults: function(resp){
                let roles;
                if(resp.status == "success"){
                    roles = resp.data;

                    return {
                        results: $.map(roles, function(obj){
                            return { id : obj.name, text:  obj.name }
                        })
                    }
                }
                else{
                    return { id : "", text: "no role found"}
                }
            }
        }
    });
    // / Role

    // Product Categories
    $(".select2ProductCategory").select2({
        placeholder: "Select a product category",
        allowClear: true,
        ajax: {
            url : "{{route('dropdownData.getAllProductCategories')}}",
            method : "POST",
            dataType : "json",

            data : function(params){
                let dataToPost = {
                    _token : $("meta[name='csrf-token']").attr("content"),
                    search : params.term
                }
                return dataToPost;
            },
            processResults: function(resp){
                let roles;
                if(resp.status == "success"){
                    roles = resp.data;

                    return {
                        results: $.map(roles, function(obj){
                            return { id : obj.id, text:  obj.name }
                        })
                    }
                }
                else{
                    return { id : "", text: "no role found"}
                }
            }
        }
    });
    // / Product Categories

    // Product Measure Unit
    $(".select2ProductMeasureUnit").select2({
        placeholder: "Select a product measure unit",
        allowClear: true,
        ajax: {
            url : "{{route('dropdownData.getProductMeasureUnits')}}",
            method : "POST",
            dataType : "json",

            data : function(params){
                let dataToPost = {
                    _token : $("meta[name='csrf-token']").attr("content"),
                    search : params.term
                }
                return dataToPost;
            },
            processResults: function(resp){
                let roles;
                if(resp.status == "success"){
                    roles = resp.data;

                    return {
                        results: $.map(roles, function(obj){
                            return { id : obj.id, text:  obj.name }
                        })
                    }
                }
                else{
                    return { id : "", text: "no role found"}
                }
            }
        }
    });
    // / Product Categories




</script>
