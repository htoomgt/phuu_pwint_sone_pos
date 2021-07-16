require('./bootstrap');

$("#logout").on('click', function(){
    $("#frmLogout").submit();
})


/** Change Status Function */
dtChangeStatus = (id=0, statusToChange = "", url = "", dataTableId = "") => {
    let dataToPost = {
        userId : id,
        statusToChange : statusToChange,
        _token : $("meta[name='csrf-token']").attr("content")
    }

    axios({
        method : 'PATCH',
        url : url,
        data: dataToPost
    }).then(function(response){
        $(dataTableId).DataTable().ajax.reload();
    }).catch(function(response){
        console.log(response.data);
    })

}


/** Delete User Function*/
dtDeleteRow = (id=0, url="", dataTableId = "") => {
    let dataToPost = {
        id : id,
        _token : $("meta[name='csrf-token']").attr("content")
    }

    Swal.fire({
        title: 'Are you sure to delete?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            axios({
                method : 'DELETE',
                url : url,
                data: dataToPost
            }).then(function(response){
                if(response.data.status == 'success'){
                        Swal.fire(
                            'Deleted!',
                            response.data.messages.request_msg,
                            'success'
                        )
                    }

            }).catch(function(response){
                console.log(response);
            }).then(function(){
                $(dataTableId).DataTable().ajax.reload();
            })
        }
    });


}

