<?php

namespace Riat\Service\Install;

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\Loader;
use CIBlock;
use CIBlockProperty;
use CIBlockPropertyEnum;
use CIBlockType;

class Iblock
{
    private static $recordIblockId;

    public function addIblock(): void
    {
        if (Loader::includeModule('iblock')) {
            $iblockType = $this->getIblockType();
            $type = new CIBlockType();
            $typeId = $type->Add($iblockType);
            $iblocks = $this->getIblock();
            foreach ($iblocks as $iblock) {
                $ib = new CIBlock();
                $id = $ib->Add($iblock);
            }
            $createdIBlocks = $this->getIblockIds();
            if ($createdIBlocks) {
                $recordIblockId = $createdIBlocks['service_record'];
                $propsCodes = [];
                $propertiesExist = [];
                foreach ($this->getIblockProperties() as $property) {
                    $propsCodes[] = $property['CODE'];
                }
                if (!empty($propsCodes)) {
                    $propsExist = PropertyTable::getList([
                        'select' => ['CODE', 'ID'],
                        'filter' => ['CODE' => $propsCodes]
                    ])->fetchAll();

                    foreach ($propsExist as $propExist) {
                        $propertiesExist[$propExist['ID']] = $propExist['CODE'];
                    }
                    $prop = new CIBlockProperty();
                    foreach ($this->getIblockProperties() as $property) {
                        $property['IBLOCK_ID'] = $recordIblockId;
                        if (!array_key_exists($property['CODE'], $propertiesExist)) {
                            $propId = $prop->Add($property);
                        } else {
                            $prop->Update($propertiesExist[$property['CODE']], $property);
                        }
                    }
                }


            }
        }
    }

    public function getIblockIds(): array
    {
        $createdIbs = IblockTable::getList([
            'select' => ['ID', 'CODE'],
            'filter' => ['CODE' => ['service_record', 'cars_posts']]
        ]);
        $result = [];
        while ($ib = $createdIbs->fetch()) {
            $result[$ib['CODE']] = $ib['ID'];
        }
        return $result;
    }

    public function deleteIblocks()
    {
        if (Loader::includeModule('iblock')) {
            $iblocks = $this->getIblock();

            $propsCodes = [];
            foreach ($this->getIblockProperties() as $property) {
                $propsCodes[] = $property['CODE'];
            }
            if (!empty($propsCodes)) {
                $propsExist = PropertyTable::getList([
                    'select' => ['ID'],
                    'filter' => ['CODE' => $propsCodes]
                ])->fetchAll();
                if (!empty($propsExist)) {
                    foreach ($propsExist as $propExist) {
                        CIBlockProperty::Delete($propExist['ID']);
                    }
                }
            }

            $iblockCodes = [];
            foreach ($iblocks as $iblock) {
                $iblockCodes[] = $iblock['CODE'];
            }
            if (!empty($iblockCodes)) {
                $existIbs = IblockTable::getList([
                    'select' => ['ID'],
                    'filter' => ['CODE' => $iblockCodes]
                ])->fetchAll();
                foreach ($existIbs as $iBlock) {
                    CIBlock::Delete($iBlock['ID']);
                }
            }
        }
    }


    public function getIblockEnumProperties()
    {
        return [

        ];
    }

    public function getIblockProperties()
    {
        $iBlockIds = $this->getIblockIds();
        return [
            [
                'NAME' => 'Дата обращения',
                'ACTIVE' => 'Y',
                'SORT' => '100',
                'CODE' => 'ACCESS_DATE',
                'DEFAULT_VALUE' => NULL,
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => 'DateTime',
                'USER_TYPE_SETTINGS' => NULL,
                'HINT' => '',
                "IBLOCK_ID" => self::$recordIblockId,
            ],
            [
                'NAME' => 'Клиент',
                'ACTIVE' => 'Y',
                'SORT' => '400',
                'CODE' => 'CLIENT',
                'DEFAULT_VALUE' => NULL,
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => 'ECrm',
                'USER_TYPE_SETTINGS' =>
                    array (
                        'DEAL' => 'Y',
                        'VISIBLE' => 'Y',
                        'LEAD' => 'N',
                        'CONTACT' => 'N',
                        'COMPANY' => 'N',
                    ),
                'HINT' => '',
                'FEATURES' =>
                    array (
                        0 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                        1 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                    ),
            ],
            [
                'NAME' => 'Причина обращения',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'REASON_FOR_CONTACT',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => 'Статус',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'STATUS',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => 'Пост',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'POST',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'E',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => $iBlockIds['cars_posts'],
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
                'FEATURES' =>
                    array (
                        0 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                        1 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                    ),
            ],
            [
                'NAME' => 'Очередь',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'QUEUE',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => 'Дата следующего контакта с клиентом',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'DATE_FOR_NEXT_CONTACT',
                'DEFAULT_VALUE' => NULL,
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => 'DateTime',
                'USER_TYPE_SETTINGS' => NULL,
                'HINT' => '',
            ],
            [
                'NAME' => 'Виды работ',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'TYPES_OF_WORK',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => 'Марка',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'MODEL',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => 'Гос.номер',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'STATE_NUMBER',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => '№ шасси',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'SHASSI',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
            ],
            [
                'NAME' => 'Запчасти',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'PARTS',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '5',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
                'FEATURES' =>
                    array (
                        0 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                        1 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                    ),
            ],
            [
                'NAME' => 'Работа',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'WORK',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'S',
                'ROW_COUNT' => '5',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
                'FEATURES' =>
                    array (
                        0 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                        1 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                    ),
            ],
            [
                'NAME' => 'Подтверждение заезда',
                'ACTIVE' => 'Y',
                'SORT' => '300',
                'CODE' => 'CHECK_INFORMATION',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'L',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
                'VALUES' =>
                    array (
                        0 =>
                            array (
                                'VALUE' => 'Да',
                                'DEF' => 'N',
                                'SORT' => '500',
                                'XML_ID' => 'Y',
                            ),
                        1 =>
                            array (
                                'VALUE' => 'Нет',
                                'DEF' => 'N',
                                'SORT' => '500',
                                'XML_ID' => 'N',
                            ),
                    ),
                'FEATURES' =>
                    array (
                        0 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'DETAIL_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                        1 =>
                            array (
                                'MODULE_ID' => 'iblock',
                                'FEATURE_ID' => 'LIST_PAGE_SHOW',
                                'IS_ENABLED' => 'N',
                            ),
                    ),
            ],
            [
                'NAME' => 'Согласие на обзвон',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'CODE' => 'CONSENT_TO_CALL',
                'DEFAULT_VALUE' => '',
                'PROPERTY_TYPE' => 'L',
                'ROW_COUNT' => '1',
                'COL_COUNT' => '30',
                'LIST_TYPE' => 'L',
                'MULTIPLE' => 'N',
                'XML_ID' => NULL,
                'FILE_TYPE' => '',
                'MULTIPLE_CNT' => '5',
                'LINK_IBLOCK_ID' => '0',
                'WITH_DESCRIPTION' => 'N',
                'SEARCHABLE' => 'N',
                'FILTRABLE' => 'N',
                'IS_REQUIRED' => 'N',
                'VERSION' => '1',
                'USER_TYPE' => NULL,
                'USER_TYPE_SETTINGS' => 'a:0:{}',
                'HINT' => '',
                'VALUES' =>
                    array (
                        0 =>
                            array (
                                'VALUE' => 'Да',
                                'DEF' => 'N',
                                'SORT' => '500',
                                'XML_ID' => 'Y',
                            ),
                        1 =>
                            array (
                                'VALUE' => 'Нет',
                                'DEF' => 'N',
                                'SORT' => '500',
                                'XML_ID' => 'N',
                            ),
                    ),
            ]
        ];
    }

    public function getIblockType()
    {
        return [
            'ID'=>'service_centr',
            'SECTIONS'=>'N',
            'IN_RSS'=>'N',
            'SORT'=>100,
            'LANG'=>Array(
                'en'=>Array(
                    'NAME'=>'Service centr',
                    'SECTION_NAME'=>'Sections',
                    'ELEMENT_NAME'=>'Products'
                ),
                'ru'=>Array(
                    'NAME'=>'Сервисный центр',
                    'SECTION_NAME'=>'Разделы',
                    'ELEMENT_NAME'=>'Элементы'
                )
            )
        ];
    }

    public function getIblock(): array
    {
        return [
            [
            'IBLOCK_TYPE_ID' => 'service_centr',
            'LID' =>
                [
                    0 => 's1',
                ],
            'CODE' => 'cars_posts',
            'API_CODE' => 'CarsPosts',
            'REST_ON' => 'N',
            'NAME' => 'Посты для автомобилей',
            'ACTIVE' => 'Y',
            'SORT' => '500',
            'LIST_PAGE_URL' => '#SITE_DIR#/service_centr/index.php?ID=#IBLOCK_ID#',
            'DETAIL_PAGE_URL' => '#SITE_DIR#/service_centr/detail.php?ID=#ELEMENT_ID#',
            'SECTION_PAGE_URL' => '#SITE_DIR#/service_centr/list.php?SECTION_ID=#SECTION_ID#',
            'CANONICAL_PAGE_URL' => '',
            'PICTURE' => NULL,
            'DESCRIPTION' => '',
            'DESCRIPTION_TYPE' => 'text',
            'RSS_TTL' => '24',
            'RSS_ACTIVE' => 'Y',
            'RSS_FILE_ACTIVE' => 'N',
            'RSS_FILE_LIMIT' => NULL,
            'RSS_FILE_DAYS' => NULL,
            'RSS_YANDEX_ACTIVE' => 'N',
            'XML_ID' => NULL,
            'INDEX_ELEMENT' => 'Y',
            'INDEX_SECTION' => 'Y',
            'WORKFLOW' => 'N',
            'BIZPROC' => 'N',
            'SECTION_CHOOSER' => 'L',
            'LIST_MODE' => '',
            'RIGHTS_MODE' => 'S',
            'SECTION_PROPERTY' => 'N',
            'PROPERTY_INDEX' => 'N',
            'VERSION' => '1',
            'LAST_CONV_ELEMENT' => '0',
            'SOCNET_GROUP_ID' => NULL,
            'EDIT_FILE_BEFORE' => '',
            'EDIT_FILE_AFTER' => '',
            'SECTIONS_NAME' => 'Разделы',
            'SECTION_NAME' => 'Раздел',
            'ELEMENTS_NAME' => 'Элементы',
            'ELEMENT_NAME' => 'Элемент',
            'EXTERNAL_ID' => NULL,
            'LANG_DIR' => '/',
            'IPROPERTY_TEMPLATES' =>
                array (
                ),
            'ELEMENT_ADD' => 'Добавить элемент',
            'ELEMENT_EDIT' => 'Изменить элемент',
            'ELEMENT_DELETE' => 'Удалить элемент',
            'SECTION_ADD' => 'Добавить раздел',
            'SECTION_EDIT' => 'Изменить раздел',
            'SECTION_DELETE' => 'Удалить раздел',
            ],
            [
                'IBLOCK_TYPE_ID' => 'service_centr',
                'LID' =>
                    array (
                        0 => 's1',
                    ),
                'CODE' => 'service_record',
                'API_CODE' => 'ServiceRecord',
                'REST_ON' => 'N',
                'NAME' => 'Запись в сервисный центр',
                'ACTIVE' => 'Y',
                'SORT' => '500',
                'LIST_PAGE_URL' => '#SITE_DIR#/service_centr/index.php?ID=#IBLOCK_ID#',
                'DETAIL_PAGE_URL' => '#SITE_DIR#/service_centr/detail.php?ID=#ELEMENT_ID#',
                'SECTION_PAGE_URL' => '#SITE_DIR#/service_centr/list.php?SECTION_ID=#SECTION_ID#',
                'CANONICAL_PAGE_URL' => '',
                'PICTURE' => NULL,
                'DESCRIPTION' => '',
                'DESCRIPTION_TYPE' => 'text',
                'RSS_TTL' => '24',
                'RSS_ACTIVE' => 'Y',
                'RSS_FILE_ACTIVE' => 'N',
                'RSS_FILE_LIMIT' => NULL,
                'RSS_FILE_DAYS' => NULL,
                'RSS_YANDEX_ACTIVE' => 'N',
                'XML_ID' => NULL,
                'INDEX_ELEMENT' => 'Y',
                'INDEX_SECTION' => 'Y',
                'WORKFLOW' => 'N',
                'BIZPROC' => 'N',
                'SECTION_CHOOSER' => 'L',
                'LIST_MODE' => '',
                'RIGHTS_MODE' => 'S',
                'SECTION_PROPERTY' => 'N',
                'PROPERTY_INDEX' => 'N',
                'VERSION' => '1',
                'LAST_CONV_ELEMENT' => '0',
                'SOCNET_GROUP_ID' => NULL,
                'EDIT_FILE_BEFORE' => '',
                'EDIT_FILE_AFTER' => '',
                'SECTIONS_NAME' => 'Разделы',
                'SECTION_NAME' => 'Раздел',
                'ELEMENTS_NAME' => 'Элементы',
                'ELEMENT_NAME' => 'Элемент',
                'EXTERNAL_ID' => NULL,
                'LANG_DIR' => '/',
                'IPROPERTY_TEMPLATES' =>
                    array (
                    ),
                'ELEMENT_ADD' => 'Добавить элемент',
                'ELEMENT_EDIT' => 'Изменить элемент',
                'ELEMENT_DELETE' => 'Удалить элемент',
                'SECTION_ADD' => 'Добавить раздел',
                'SECTION_EDIT' => 'Изменить раздел',
                'SECTION_DELETE' => 'Удалить раздел',
            ],
        ];
    }
}