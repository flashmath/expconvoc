<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Importations</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title data-original-title="Collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <form role="form" id="nomenclatureForm">
                    <div class="form-group col-md-9">
                        <label for="nomenclatureInputFile">
                            Importation des nomenclatures
                        </label>
                        <input id="nomenclatureInputFile" type="file">

                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-info pull-right" type="button" onclick="postNomenclature();">Importer</button>
                    </div>
                </form>
                    <hr>
                <form role="form" id="structureForm">
                    <div class="form-group col-md-9">
                        <label for="structureInputFile">
                            Importation des structures
                        </label>
                        <input id="structureInputFile" type="file">

                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-info pull-right" type="button" onclick="postStructure();">Importer</button>
                    </div>
                </form>
                <hr>
                <form role="form" id="eleveForm">
                    <div class="form-group col-md-9">
                        <label for="eleveInputFile">
                            Importation des élèves avec adresses
                        </label>
                        <input id="eleveInputFile" type="file">

                    </div>
                    <div class="form-group col-md-3">
                        <button class="btn btn-info pull-right" type="button" onclick="postEleves();">Importer</button>
                    </div>
                </form>
            </div>
            <div class="box-footer clearfix">
            </div>
        </div>
    </div>
    <div class="col-md-6" id="infoContent">

    </div>
</div>
