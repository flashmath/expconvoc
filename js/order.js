
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

/*
$("#modifProfileAdmin").click(function () {
    if ($.trim($("#modifInfo").text()) == "") {
        $.ajax({
            url: "index.php?order/getInfo",
            method: "GET",
            dataType: "html",
            success: function (code_html, status) {

                $(code_html).appendTo("#modifInfo");
                initBoxWidget();
                $('#divform').on('removed.boxwidget', removeElement($('#infoForm')))
            },
            error: function(reponse){
                alert('error');
            }
        })
    }
})*/

