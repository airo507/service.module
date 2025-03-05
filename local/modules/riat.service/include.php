<?php

Bitrix\Main\Loader::registerAutoLoadClasses("riat.service", [
    "Riat\Service\Install\Iblock" => "lib/install/Iblock.php",
    "Riat\Service\Install\Userfield" => "lib/install/Userfield.php",
    "Riat\Service\Install\Events" => "lib/install/Events.php",
]);