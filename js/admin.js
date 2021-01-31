
/*
showModifAdresse = showElt("#modifAdresse","index.php?order/getAdress",'#divModifLocal','#updateAdressForm');
showNewAdresse = showElt("#newAdresse","index.php?order/getNewAdress",'#divNewLocal','#newLocalAdressForm');
showModifAdresseFacturation = showElt("#modifAdresseFacturation","index.php?order/getAdressBill",'#divModifLocalBill','#updateAdressBillForm');
showNewAdresseFacturation = showElt("#newAdresseFacturation","index.php?order/getNewAdressBill",'#divNewBill','#newLBillAdressForm');

$("#modifProfileAdmin").click(showElt("#modifInfo","index.php?order/getInfo",'#divform','#infoForm'));

function updateInfoOrder(){
    $.ajax({
        url: "index.php?order/postInfo",
        method: "POST",
        data : $('#infoForm').serialize(),
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                location.reload()
            } else {
                $('#modifInfo').html(reponse.content);
                initBoxWidget();
                $('#divform').on('removed.boxwidget', removeProfile)
            }
        }
    })
}

function getAgencyDesk(){
    $.ajax({
        url: "index.php?order/getAgencyDesk",
        method: "GET",
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                $('#sidebar').html(reponse['sidebar']);
                $('#mainContent').html(reponse['content']);
                initBoxWidget();
            }
        }
    })
}

function getMainOrder(){
    $.ajax({
        url: "index.php?order/getDesk",
        method: "GET",
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                $('#sidebar').html(reponse['sidebar']);
                $('#mainContent').html(reponse['content']);
                $("#modifProfileAdmin").click(showElt("#modifInfo","index.php?order/getInfo",'#divform','#infoForm'));
                initBoxWidget();
            }
        }
    })
}
*/

function initTableOrders(){
    $('#tableOrders').DataTable({
        "serverSide" : true,
        "ajax" : {
            url: "index.php?admin/getOrders",
            type: 'GET',
        },
        'columns': [
            { data: 'id' },
            { data: 'nom' },
            { data: 'siren' },
            { data: 'ville' }
        ]
    })
    /*$.ajax({
        url: "index.php?admin/getOrders",
        method: "GET",
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                console.log(JSON.stringify(reponse));
            }
        }
    })*/
}

/*
function getOrdersDesk(){
    $.ajax({
        url: "index.php?admin/getOrderDesk",
        method: "GET",
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                $('#sidebar').html(reponse['sidebar']);
                $('#mainContent').html(reponse['content']);
                initBoxWidget();
                initTableOrders();
            }
        }
    })
}

function getImportDesk(){
    $.ajax({
        url: "index.php?admin/getImportDesk",
        method: "GET",
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                $('#sidebar').html(reponse['sidebar']);
                $('#mainContent').html(reponse['content']);
                initBoxWidget();
            }
        }
    })
}*/

function getAdminMainDesk(){
    $.ajax({
        url: "index.php?admin/getAdminDesk",
        method: "GET",
        dataType: "JSON",
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                $('#sidebar').html(reponse['sidebar']);
                $('#mainContent').html(reponse['content']);
                initBoxWidget();
            }
        }
    })
}

function postNomenclature(){
    var fd = new FormData();
    var files = $("#nomenclatureInputFile")[0].files;
    fd.append('nomenclatureInputFile',files[0]);
    $.ajax({
        url: "index.php?admin/postNomenclature",
        method: "POST",
        dataType: "JSON",
        data: fd,
        contentType : false,
        processData : false,
        success: function (reponse, status) {
            if (reponse['status']=='ok'){
                alert(reponse['error']);
                $('#sidebar').html(reponse['sidebar']);
                $('#infoContent').html(reponse['content']);
                initBoxWidget();
            }
        }
    })
}

function postStructure(){
    var fd = new FormData();
    var files = $("#structureInputFile")[0].files;
    fd.append('structureInputFile',files[0]);
    $.ajax({
        url: "index.php?admin/postStructure",
        method: "POST",
        dataType: "JSON",
        data: fd,
        contentType : false,
        processData : false,
        success: function (reponse, status) {
            //alert(reponse);
            if (reponse['status']=='ok'){
                //alert(reponse['error']);
                $('#sidebar').html(reponse['sidebar']);
                $('#infoContent').html(reponse['content']);
                initBoxWidget();
            }
        },
        complete: function (reponse,status){
            //alert('Requete complete');
            //alert(status);
        }

    })
}

function postEleves(){
    var fd = new FormData();
    var files = $("#eleveInputFile")[0].files;
    fd.append('eleveInputFile',files[0]);
    $.ajax({
        url: "index.php?admin/postEleves",
        method: "POST",
        dataType: "JSON",
        data: fd,
        contentType : false,
        processData : false,
        success: function (reponse, status) {
            //alert(reponse);
            if (reponse['status']=='ok'){
                //alert(reponse['error']);
                $('#sidebar').html(reponse['sidebar']);
                $('#infoContent').html(reponse['content']);
                initBoxWidget();
            }
        },
        complete: function (reponse,status){
            //alert('Requete complete');
            //alert(status);
        }

    })
}