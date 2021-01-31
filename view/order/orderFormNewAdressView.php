<form class="form-horizontal" action="index.php?order/postNewLocalAdress" method="post" id="newLocalAdressForm">
    <div class="box" id="divNewLocal">
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
