<div class="row">
    <div class="col-md-3">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Paramètres</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <img src="<?= $image;?>" class="profile-user-img img-responsive img-circle" alt="Company Profile picture">
                <h3 class="profile-username text-center"><?= $order['denomination']; ?></h3>
                <p class="text-muted text-center"><?= $login;?></p>
                <strong>
                    <i class="fa fa-id-card margin-r-5"> Contact</i>
                </strong>
                <p class="text-muted"><?= $order['Contact'];?></p>
                <hr>
                <strong>
                    <i class="fa fa-envelope margin-r-5"> Email</i>
                </strong>
                <p class="text-muted"><?= $order['email'];?></p>
                <hr>
                <strong>
                    <i class="fa fa-building margin-r-5"> Siren</i>
                </strong>
                <p class="text-muted"><?= $order['siren'];?></p>
                <hr>
                <strong>
                    <i class="fa fa-map-marker margin-r-5"> Adresse</i>
                </strong>
                <p class="text-muted"><?= $order['localAdr1'].'<br/>';
                    if ($order['localAdr2']!=""){
                        echo $order['localAdr2'].'<br/>';
                    }
                    echo $order['localCode'].' '.$order['localVille'];
                    ?></p>
                <hr>
                <strong>
                    <i class="fa fa-map-marker margin-r-5"> Adresse de facturation</i>
                </strong>
                <p class="text-muted"><?= $order['factAdr1'].'<br/>';
                    if ($order['factAdr2']!=""){
                        echo $order['factAdr2'].'<br/>';
                    }
                    echo $order['factCode'].' '.$order['factVille'];
                    ?></p>
            </div>
            <div class="box-footer clearfix">
                <button type="button" class="pull-right btn btn-default" id="modifProfileAdmin">
                    Modifier <i class="fa fa-arrow-circle-right"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div id="modifInfo"></div>


        <div id="modifAdresse"></div>
        <div id="modifAdresseFacturation"></div>
        <div id="newAdresse"></div>
        <div id="newAdresseFacturation"></div>

    </div>
</div>
