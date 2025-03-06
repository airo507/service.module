<?php

namespace Riat\Service\Install;

use Bitrix\Iblock\IblockTable;
use Bitrix\Main\UserFieldTable;

class Userfield
{
    public function add()
    {
        $ufType = new \CUserTypeEntity();
        $uFields = $this->getUserFields();
        $fieldsNames = [];
        foreach ($uFields as $uField) {
            $fieldsNames[] = $uField['FIELD_NAME'];
        }
        $ufsExist = array_column(UserFieldTable::getList([
            'select' => ['ID', 'FIELD_NAME'],
            'filter' => ['FIELD_NAME' => $fieldsNames]
        ])->fetchAll(), 'ID','FIELD_NAME');
        foreach ($uFields as $uField) {
            if (!array_key_exists($uField['FIELD_NAME'], $ufsExist)) {
                $typeId = $ufType->Add($uField);
            } else {
                $ufType->Update($ufsExist[$uField['FIELD_NAME']], $uField);
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

    public function getUserFields()
    {
        $iBlocks = $this->getIblockIds();
        return [
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_ACCESS_DATE',
              'USER_TYPE_ID' => 'datetime',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DEFAULT_VALUE' =>
                          array (
                              'TYPE' => 'NOW',
                              'VALUE' => '',
                          ),
                      'USE_SECOND' => 'Y',
                      'USE_TIMEZONE' => 'N',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Дата обращения',
                      'ru' => 'Дата обращения',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_PLANNED_DATE',
              'USER_TYPE_ID' => 'datetime',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DEFAULT_VALUE' =>
                          array (
                              'TYPE' => 'NOW',
                              'VALUE' => '',
                          ),
                      'USE_SECOND' => 'Y',
                      'USE_TIMEZONE' => 'N',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Плановая дата заезда',
                      'ru' => 'Плановая дата заезда',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_CHECK_INFORMATION',
              'USER_TYPE_ID' => 'boolean',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DEFAULT_VALUE' => 1,
                      'DISPLAY' => 'DROPDOWN',
                      'LABEL' =>
                          array (
                              0 => '',
                              1 => '',
                          ),
                      'LABEL_CHECKBOX' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Check information',
                      'ru' => 'Подтверждение заезда',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_STATUS',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Status',
                      'ru' => 'Статус',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_POST',
              'USER_TYPE_ID' => 'iblock_element',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DISPLAY' => 'LIST',
                      'LIST_HEIGHT' => 1,
                      'IBLOCK_ID' => $iBlocks['cars_posts'],
                      'DEFAULT_VALUE' => '',
                      'ACTIVE_FILTER' => 'N',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Post',
                      'ru' => 'Пост',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_QUEUE',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Queue',
                      'ru' => 'Очередь',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_DATE_FOR_NEXT_CONTACT',
              'USER_TYPE_ID' => 'datetime',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DEFAULT_VALUE' =>
                          array (
                              'TYPE' => 'NONE',
                              'VALUE' => '',
                          ),
                      'USE_SECOND' => 'Y',
                      'USE_TIMEZONE' => 'N',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Date for next contact with client',
                      'ru' => 'Дата следующего контакта с клиентом',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_TYPES_OF_WORK',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Types of work',
                      'ru' => 'Виды работ',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_MODEL',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Model',
                      'ru' => 'Марка',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_STATE_NUMBER',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'State number',
                      'ru' => 'Гос. номер',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_SHASSI',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Shassi',
                      'ru' => '№ шасси',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_CONSENT_TO_CALL',
              'USER_TYPE_ID' => 'boolean',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DEFAULT_VALUE' => 0,
                      'DISPLAY' => 'DROPDOWN',
                      'LABEL' =>
                          array (
                              0 => '',
                              1 => '',
                          ),
                      'LABEL_CHECKBOX' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Consent to call',
                      'ru' => 'Согласие на обзвон',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_PARTS',
              'USER_TYPE_ID' => 'integer',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'MIN_VALUE' => 0,
                      'MAX_VALUE' => 0,
                      'DEFAULT_VALUE' => NULL,
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Parts (days)',
                      'ru' => 'Запчасти (дни)',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_WORK',
              'USER_TYPE_ID' => 'integer',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'MIN_VALUE' => 0,
                      'MAX_VALUE' => 0,
                      'DEFAULT_VALUE' => NULL,
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Work (days)',
                      'ru' => 'Работа (дни)',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_REASON_FOR_CONTACT',
              'USER_TYPE_ID' => 'string',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'SIZE' => 20,
                      'ROWS' => 1,
                      'REGEXP' => '',
                      'MIN_LENGTH' => 0,
                      'MAX_LENGTH' => 0,
                      'DEFAULT_VALUE' => '',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Reason for contact',
                      'ru' => 'Причина обращения',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ],
          [
              'ENTITY_ID' => 'CRM_DEAL',
              'FIELD_NAME' => 'UF_CRM_DEAL_SC_RECORD_ID',
              'USER_TYPE_ID' => 'iblock_element',
              'XML_ID' => '',
              'SORT' => '100',
              'MULTIPLE' => 'N',
              'MANDATORY' => 'N',
              'SHOW_FILTER' => 'N',
              'SHOW_IN_LIST' => 'Y',
              'EDIT_IN_LIST' => 'Y',
              'IS_SEARCHABLE' => 'N',
              'SETTINGS' =>
                  array (
                      'DISPLAY' => 'LIST',
                      'LIST_HEIGHT' => 1,
                      'IBLOCK_ID' => $iBlocks['service_record'],
                      'DEFAULT_VALUE' => '',
                      'ACTIVE_FILTER' => 'N',
                  ),
              'EDIT_FORM_LABEL' =>
                  array (
                      'en' => 'Id sc record',
                      'ru' => 'Id записи в СЦ',
                  ),
              'LIST_COLUMN_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'LIST_FILTER_LABEL' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'ERROR_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
              'HELP_MESSAGE' =>
                  array (
                      'en' => '',
                      'ru' => '',
                  ),
          ]
        ];
    }
}