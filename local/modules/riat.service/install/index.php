<?php

use Bitrix\Main\EventManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Application;
use Bitrix\Main\Loader;
use Riat\Service\Install\Events;
use Riat\Service\Install\Iblock;
use Riat\Service\Install\Userfield;


class riat_service extends CModule
{
    public $MODULE_ID = 'riat.service';

    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;


    public function __construct() {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('MODULE_DESCRIPTION');
        $this->MODULE_GROUP_RIGHTS = 'Y';
    }

    public function DoInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);
        CModule::IncludeModule($this->MODULE_ID);
        $this->InstallDB();

        CopyDirFiles(__DIR__ . "/components", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components", true, true);
        CopyDirFiles(__DIR__ . "/tools", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/tools", true, true);
        CopyDirFiles(__DIR__ . "/js", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js", true, true);
        CopyDirFiles(__DIR__ . "/pages", $_SERVER["DOCUMENT_ROOT"], true, true);
    }

    public function DoUninstall()
    {
        $this->UnInstallDB();
        $this->UnInstallEvents();
        $iblock = new Iblock();
        $iblock->deleteIblocks();
        $this->UnRegisterEvents();

        DeleteDirFilesEx('/bitrix/components/riat');
        DeleteDirFilesEx('/bitrix/tools/riat');
        DeleteDirFilesEx('/bitrix/js/riat');
        DeleteDirFilesEx('/service_centr');
        ModuleManager::unRegisterModule($this->MODULE_ID);
    }

    public function InstallDB()
    {
        $iblock = new Iblock();
        $iblock->addIblock();
        $uf = new Userfield();
        $uf->add();
        $this->RegisterEvents();
    }

    public function RegisterEvents()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible('main',"OnEpilog",$this->MODULE_ID, Events::class,"onEpilogHandler");
        $eventManager->registerEventHandler('crm',"onEntityDetailsTabsInitialized",$this->MODULE_ID, Events::class,"addTabToDealHandler");
    }

    public function UnRegisterEvents()
    {
        $eventManager = EventManager::getInstance();
        $eventManager->registerEventHandlerCompatible('main',"OnEpilog",$this->MODULE_ID, Events::class,"onEpilogHandler");
        $eventManager->unRegisterEventHandler('crm',"onEntityDetailsTabsInitialized",$this->MODULE_ID, Events::class,"addTabToDealHandler");
    }

    public function UnInstallDB()
    {
        if (Loader::includeModule($this->MODULE_ID))
        {
            $this->UnRegisterEvents();
        }
    }

}