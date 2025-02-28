<?php

global $APPLICATION;

use Bitrix\Main\Application;
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');

$request = Application::getInstance()->getContext()->getRequest();

$componentData = $request->get('PARAMS');

$APPLICATION->IncludeComponent(
    'bitrix:ui.sidepanel.wrapper',
    '',
    [
        'POPUP_COMPONENT_USE_BITRIX24_THEME' => 'Y',
        'POPUP_COMPONENT_NAME' => 'riat:service.record.add',
        'IFRAME_MODE' => true,
        'USE_PADDING' => true,
        'PLAIN_VIEW' => false,
        'PAGE_MODE' => false,
        'DEFAULT_THEME_ID' => 'light:mail',
        'POPUP_COMPONENT_PARAMS' => [
            'REQUEST' => $componentData['params']
        ]
    ]
);