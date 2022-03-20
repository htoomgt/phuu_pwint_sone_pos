<script>
    // all products config
    let select2ProductConfig = {
        placeholder: "Select a product",
        allowClear: true,
        ajax: {
            url: "{{ route('dropdownData.getAllProducts') }}",
            method: "POST",
            dataType: "json",

            data: function(params) {
                let dataToPost = {
                    _token: $("meta[name='csrf-token']").attr("content"),
                    search: params.term
                }
                return dataToPost;
            },
            processResults: function(resp) {
                let roles;
                if (resp.status == "success") {
                    roles = resp.data;

                    return {
                        results: $.map(roles, function(obj) {
                            return {
                                id: obj.id,
                                text: obj.name
                            }
                        })
                    }
                } else {
                    return {
                        id: "",
                        text: "no role found"
                    }
                }
            }
        }
    }


    function dropDownRefresh() {
        // Role
        $(".select2Role").select2({
            placeholder: "Select a role",
            allowClear: true,
            ajax: {
                url: "{{ route('dropdownData.getAllRoles') }}",
                method: "POST",
                dataType: "json",

                data: function(params) {
                    let dataToPost = {
                        _token: $("meta[name='csrf-token']").attr("content"),
                        search: params.term
                    }
                    return dataToPost;
                },
                processResults: function(resp) {
                    let roles;
                    if (resp.status == "success") {
                        roles = resp.data;

                        return {
                            results: $.map(roles, function(obj) {
                                return {
                                    id: obj.name,
                                    text: obj.name
                                }
                            })
                        }
                    } else {
                        return {
                            id: "",
                            text: "no role found"
                        }
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
                url: "{{ route('dropdownData.getAllProductCategories') }}",
                method: "POST",
                dataType: "json",

                data: function(params) {
                    let dataToPost = {
                        _token: $("meta[name='csrf-token']").attr("content"),
                        search: params.term
                    }
                    return dataToPost;
                },
                processResults: function(resp) {
                    let roles;
                    if (resp.status == "success") {
                        roles = resp.data;

                        return {
                            results: $.map(roles, function(obj) {
                                return {
                                    id: obj.id,
                                    text: obj.name
                                }
                            })
                        }
                    } else {
                        return {
                            id: "",
                            text: "no role found"
                        }
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
                url: "{{ route('dropdownData.getProductMeasureUnits') }}",
                method: "POST",
                dataType: "json",

                data: function(params) {
                    let dataToPost = {
                        _token: $("meta[name='csrf-token']").attr("content"),
                        search: params.term
                    }
                    return dataToPost;
                },
                processResults: function(resp) {
                    let roles;
                    if (resp.status == "success") {
                        roles = resp.data;

                        return {
                            results: $.map(roles, function(obj) {
                                return {
                                    id: obj.id,
                                    text: obj.name
                                }
                            })
                        }
                    } else {
                        return {
                            id: "",
                            text: "no role found"
                        }
                    }
                }
            }
        });
        // / Product Categories

        // Product Measure Unit

        // Product
        $(".select2Product").select2(select2ProductConfig);
        // Product End



        // Product all by names
        $(".select2ProductAllByName").select2({
            placeholder: "Select a product name | code",
        allowClear: true,
        ajax: {
            url: "{{ route('dropdownData.getProductAllByNames') }}",
            method: "POST",
            dataType: "json",

            data: function(params) {
                let dataToPost = {
                    _token: $("meta[name='csrf-token']").attr("content"),
                    search: params.term,
                    name: ""
                }
                return dataToPost;
            },
            processResults: function(resp) {
                let roles;
                if (resp.status == "success") {
                    roles = resp.data;

                    return {
                        results: $.map(roles, function(obj) {
                            return {
                                id: obj.id,
                                text: obj.name +" | "+obj.product_code
                            }
                        })
                    }
                } else {
                    return {
                        id: "",
                        text: "no role found"
                    }
                }
            }
        }
        });
        // / Product all by names


    }
</script>
