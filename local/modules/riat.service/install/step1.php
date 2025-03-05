<?php

global $APPLICATION;

use Bitrix\Main\Localization\Loc; ?>

<form action="<?= $APPLICATION->GetCurPage()?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANG?>">
    <input type="hidden" name="id" value="laptop.shop">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="step" value="2">
    <label>
        <input type="checkbox" name="drop_tables" value="Y" checked>
        <?= Loc::getMessage("DELETE_EXIST_TABLES") ?>
    </label>
    <br><br>
    <input type="submit" name="inst" value="<?= Loc::getMessage("MODULE_INSTALL") ?>">
</form>
