<?php

global $APPLICATION;

use Bitrix\Main\Localization\Loc;

if(!check_bitrix_sessid()) return;

if ($errorException = $APPLICATION->getException()) {
    CAdminMessage::showMessage(
        Loc::getMessage('MODULE_INSTALL_FAILED').': '.$errorException->GetString()
    );
} else {
    CAdminMessage::showNote(
        Loc::getMessage('MODULE_INSTALL_SUCCESS')
    );
}
?>

<form action="<?= $APPLICATION->getCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="<?= Loc::getMessage('RETURN_MODULES'); ?>">
</form>
