<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>

<div>
    <?foreach ($arResult as $item){?>
        <p><?=$item['EMAIL_DOMAIN']?> - <?=$item['EMAIL_DOMAIN_COUNT']?></p>
    <?}?>
</div>