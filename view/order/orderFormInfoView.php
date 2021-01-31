<form action="index.php?order/postInfo" method="post" class="form-horizontal" id="infoForm">
    <div class="box" id="divform">
        <div class="box-header with-border">
            <h3 class="box-title">Modification des informations</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title data-original-title="Réduire">
                    <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title data-original-title="Fermer">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>

        <div class="box-body">
            <?= $contact; ?>
            <?= $email; ?>
            <?= $siren;?>

            <div class="form-group">
                <label for="" class="col-sm-2 control-label">
                    Adresse
                </label>
                <div class="col-sm-10">
                    <button type="button" class="btn btn-primary pull-left" style="margin-right: 5px;" onclick="showNewAdresse();">
                        <i class="fa fa-plus-square"></i>
                        Nouvelle adresse
                    </button>
                    <button type="button" class="btn btn-primary pull-left" onclick="showModifAdresse();" >
                        <i class="fa fa-edit"></i>
                        Modifier l'adresse
                    </button>

                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-2 control-label">
                    Adresse de facturation
                </label>
                <div class="col-sm-10">
                    <button type="button" class="btn btn-primary pull-left" style="margin-right: 5px;" onclick="showNewAdresseFacturation();">
                        <i class="fa fa-plus-square"></i>
                        Nouvelle adresse
                    </button>
                    <button type="button" class="btn btn-primary pull-left" onclick="showModifAdresseFacturation()">
                        <i class="fa fa-edit"></i>
                        Modifier l'adresse
                    </button>

                </div>
            </div>
        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-primary" onclick="updateInfoOrder()">Valider</button>
        </div>
    </div>
</form>
