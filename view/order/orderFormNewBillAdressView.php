<form class="form-horizontal" action="index.php?order/postNewBillAdress" method="post" id="newBillAdressForm">
    <div class="box" id="divNewBill">
        <?= $header;?>
        <div class="box-body">
            <?= $adress1;?>
            <?= $adress2;?>
            <?= $code; ?>
            <?= $ville; ?>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary">Valider</button>
        </div>
    </div>
</form>
