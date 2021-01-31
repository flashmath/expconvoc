<form class="form-horizontal" action="index.php?order/postUpdateAdress" method="post" id="updateAdressForm">
    <div class="box" id="divModifLocal">
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
