<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\UI\Extension;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

/**
 * @var $arResult array
 * @var $APPLICATION array
 */

$APPLICATION->SetTitle('Добавление в очередь в СЦ');

Extension::load(["ui.forms", "calendar", 'ui.entity-selector', 'date', 'jquery']);

$request = Application::getInstance()->getContext()->getRequest();
$params = $request->toArray()['PARAMS']['params'];
?>
<div class="bx-service-centr">
    <form action="" id="serviceRecordAddForm" method="post">
    <div class="service-record-add-form" data-id="<?=$params['DEAL_ID']?>">
        <div class="sraf-field py-5 service-record-add-form-NAME">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_NAME_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="NAME" name="NAME" value="<?=$params['TITLE'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-ACCESS_DATE">
            <div class="ui-ctl ui-srda-field-access-date-label">
                <label><?=Loc::getMessage('SRAF_ACCESS_DATE_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-after-icon ui-ctl-datetime">
                <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
                <input type="text" class="ui-ctl-element" id="ACCESS_DATE" name="ACCESS_DATE" value="<?=$params['ACCESS_DATE'] ?: ''?>" onclick="BX.calendar({node: this, field: this, bTime: true, bSetFocus: false})" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-PLANNED_DATE_START">
            <div class="ui-ctl ui-srda-field-access-date-label">
                <label><?=Loc::getMessage('SRAF_PLANNED_DATE_START_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-after-icon ui-ctl-datetime">
                <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
                <input type="text" class="ui-ctl-element"  id="PLANNED_DATE_START" name="PLANNED_DATE_START" value="<?=$params['PLANNED_DATE'] ?: ''?>" onclick="BX.calendar({node: this, field: this, bTime: true, bSetFocus: false})">
            </div>
        </div>
        <input type="hidden" class="ui-ctl-element"  id="ELEMENT_ID" name="ELEMENT_ID" value="<?=$params['SC_RECORD_ID'] ?: ''?>">
        <input type="hidden" class="ui-ctl-element"  id="CONSENT_TO_CALL" name="CONSENT_TO_CALL" value="<?=$params['CONSENT_TO_CALL'] ?: ''?>">
        <div class="sraf-field py-5 service-record-add-form-LEAD">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_LEAD_FIELD')?></label>
            </div>
            <input type="text" class="ui-ctl-element"  id="CLIENT" name="CLIENT" value="<?=$params['DEAL_ID'] ?: ''?>" readonly>
        </div>
        <div class="sraf-field py-5 service-record-add-form-REASON_FOR_CONTACT">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_REASON_FOR_CONTACT_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="REASON_FOR_CONTACT" name="REASON_FOR_CONTACT" value="<?=$params['REASON_FOR_CONTACT'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-STATUS">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_STATUS_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="STATUS" name="STATUS" value="<?=$params['STATUS'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-POST">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_POST_FIELD')?></label>
            </div>
            <input type="text" class="ui-ctl-element"  id="POST" name="POST" value="<?=$params['POST'] ?: ''?>" readonly>
        </div>
        <div class="sraf-field py-5 service-record-add-form-QUEUE">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_QUEUE_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="QUEUE" name="QUEUE" value="<?=$params['QUEUE'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-DATE_FOR_NEXT_CONTACT">
            <div class="ui-ctl ui-srda-field-access-date-label">
                <label><?=Loc::getMessage('SRAF_DATE_FOR_NEXT_CONTACT_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-after-icon ui-ctl-datetime">
                <div class="ui-ctl-after ui-ctl-icon-calendar"></div>
                <input type="text" class="ui-ctl-element" id="DATE_FOR_NEXT_CONTACT" name="DATE_FOR_NEXT_CONTACT" value="<?=$params['DATE_FOR_NEXT_CONTACT'] ?: ''?>" onclick="BX.calendar({node: this, field: this, bTime: true, bSetFocus: false})" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-TYPES_OF_WORK">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_TYPES_OF_WORK_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="TYPES_OF_WORK" name="TYPES_OF_WORK" value="<?=$params['TYPES_OF_WORK'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-MODEL">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_MODEL_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="MODEL" name="MODEL" value="<?=$params['MODEL'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-STATE_NUMBER">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_STATE_NUMBER_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="STATE_NUMBER" name="STATE_NUMBER" value="<?=$params['STATE_NUMBER'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-SHASSI">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_SHASSI_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="SHASSI" name="SHASSI" value="<?=$params['SHASSI'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-PARTS">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_PARTS_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="PARTS" name="PARTS" value="<?=$params['PARTS'] ?: ''?>" readonly>
            </div>
        </div>
        <div class="sraf-field py-5 service-record-add-form-WORK">
            <div class="ui-ctl ui-srda-field-name-label">
                <label><?=Loc::getMessage('SRAF_WORK_FIELD')?></label>
            </div>
            <div class="ui-ctl ui-ctl-textbox ui-ctl-w100">
                <input type="text" class="ui-ctl-element" id="WORK" name="WORK" value="<?=$params['WORK'] ?: ''?>" readonly>
            </div>
        </div>

        <div class="sraf-footer">
            <div class="sraf-button-container">
                <div class="sraf-buttons">
                    <button class="ui-btn ui-btn-primary" id="saveFormButton">Сохранить</button>
                    <button class="ui-btn ui-btn-light-border" id="cancelFormButton">Отмена</button>
                </div>
            </div>
        </div>

    </div>
</form>
</div>

<script>
    BX.ready(function () {
        let params = {
            postIblockId: <?=$arResult['POSTS_IBLOCK_ID']?>,
            elementId: <?=$params['ELEMENT_ID'] ?: 0?>,
            post: <?=$params['POST']?>,
            lead: <?=$params['DEAL_ID']?>,
        }

        BX.Riat.ServiceRecordAdd.init(params);
    })
</script>



