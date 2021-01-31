<?php
if ($error){
    echo "<div class='form-group has-error'>";
    } else {
    echo "<div class='form-group'>";
   }?>
        <label for="<?= $id;?>" class="col-sm-2 control-label">
            <?= $label;?>
        </label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="<?= $id;?>" placeholder="<?= $label?>" autocomplete="off" value="<?= $value;?>" name="<?= $name?>">
            <?php if ($error){
                ?> <span class="help-block"> <?= $error;?></span><?php
            } ?>
        </div>
    </div>
