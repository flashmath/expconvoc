function removeProfile(){
    $('#infoForm').remove();
}
/*
function removeModifAdress(){
    $('#updateAdressForm').remove();
}


function removeModifAdressFacturation(){
    $('#updateAdressBillForm').remove();
}

function removeNewAdress() {
    $('#newLocalAdressForm').remove();
}

function removeNewAdressFacturation() {
    $('#newLBillAdressForm').remove();
}*/

function removeElement(elt){
    return function (){
        elt.remove();
    }
}

function initBoxWidget(){
    $('.box').boxWidget({
        animationSpeed : 500,
        collapseTrigger: '[data-widget="collapse"]',
        removeTrigger  : '[data-widget="remove"]',
        collapseIcon   : 'fa-minus',
        expandIcon     : 'fa-plus',
        removeIcon     : 'fa-times'
    });
}

function showElt(divCible, action, box, form){
    return function(){
        if ($.trim($(divCible).text()) == "") {
            $.ajax({
                url: action,
                method: "GET",
                dataType: "html",
                success: function (code_html, status) {
                    $(code_html).appendTo(divCible);
                    initBoxWidget();
                    $(box).on('removed.boxwidget',function(){
                        $(form).remove()
                    })
                }
            })
        }
    }
}