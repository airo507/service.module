<?php

use Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

echo CAdminMessage::ShowMessage(array('MESSAGE' => Loc::getMessage('MODULE_INSTALL_STEP2_SUCCESS'), 'TYPE' => 'OK'));
?>
<form action="<?= $APPLICATION->GetCurPage() ?>?" method="get">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID ?>">
    <input type="submit" name="" value="<?= Loc::getMessage('MODULE_INSTALL_STEP2_FINISH') ?>">
</form>