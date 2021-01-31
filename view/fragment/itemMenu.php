<?php
/**
* @var string $state
 * @var string $link
 * @var string $click
 * @var string $image
 * @var string $texte
 */
?>
<li class="<?= $state;?>"><a href="<?= $link;?>" onclick="<?= $click; ?>"><i class="fa <?= $image;?>"></i> <span><?= $texte;?></span></a></li>
