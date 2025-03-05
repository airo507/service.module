<?php

namespace Riat\Service\Install;

use Bitrix\Crm\DealTable;
use CCrmOwnerType;
use Bitrix\Main\Event;
use Bitrix\Main\EventResult;
use Bitrix\Main\Web\Uri;
use CJSCore;

class Events
{
    public static function addTabToDealHandler(Event $event)
    {
        $entityTypeID = $event->getParameter('entityTypeID');
        if ($entityTypeID === CCrmOwnerType::Deal) {
            $tabs = $event->getParameter('tabs');
            $entityID = $event->getParameter('entityID');
            if ($entityID) {
                $dealFields = DealTable::getList([
                    'select' => ['UF_CRM_DEAL_*', '*'],
                    'filter' => ['ID' => $entityID]
                ])->fetch();
                $arFields = [];

                foreach ($dealFields as $key => $dealField) {
                    if (str_contains($key, 'UF_CRM_DEAL_')) {
                        $newKey = str_replace('UF_CRM_DEAL_', '', $key);
                        $arFields[$newKey] = $dealField;
                    }
                    if ($key === 'TITLE') {
                        $arFields[$key] = $dealField;
                    }
                }
                $arFields['DEAL_ID'] = $entityID;
                $uri = new Uri('/service_centr/index.php');
                $tabs[] = [
                    'id' => 'tab_service_centr_add',
                    'name' => 'Записать в сервисный центр',
                    'loader' => [
                        'serviceUrl' => '/bitrix/tools/riat/ajax.php',
                        'componentData' => [
                            'template' => '',
                            'params' => $arFields
                        ]
                    ]
                ];
            }

            return new EventResult(EventResult::SUCCESS, [
                'tabs' => $tabs,
            ]);
        }
    }

    public static function addTab()
    {
        CJSCore::RegisterExt("servicetab", array(
            "js" => '/bitrix/js/riat/servicetab.js',
            "use" => CJSCore::USE_PUBLIC,
            'rel' => ['core'],
        ));
        CJSCore::Init(['servicetab']);
    }

    public static function onEpilogHandler()
    {
        global $APPLICATION;
        $currentDirectory = $APPLICATION->getCurDir();

        if (mb_strpos($currentDirectory, '/crm/deal/details/') !== false) {
            self::addTab();
        }
    }


}