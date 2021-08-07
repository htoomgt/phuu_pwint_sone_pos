require('./bootstrap');

let addCommasTest = "ABC add commas";


$("#logout").on('click', function(){
    $("#frmLogout").submit();
})


/**
 * To format number with thousand seperator and decimal
 *referenced from https://stackoverflow.com/questions/7327046/jquery-number-formatting correct answer
 */
numFormat = (nStr) => {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}




/** Change Status Function */
dtChangeStatus = (id=0, statusToChange = "", url = "", dataTableId = "") => {
    let dataToPost = {
        id : id,
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

