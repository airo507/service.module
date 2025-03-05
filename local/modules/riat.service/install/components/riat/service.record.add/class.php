<?php

use Bitrix\Crm\DealTable;
use Bitrix\Crm\LeadTable;
use Bitrix\Iblock\Elements\ElementCarsPostsTable;
use Bitrix\Iblock\Elements\ElementServiceRecordTable;
use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\PropertyEnumerationTable;
use Bitrix\Iblock\PropertyTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Loader;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;
use Bitrix\Main\SystemException;
use Bitrix\Main\Web\Json;

class ServiceRecordAdd extends \CBitrixComponent implements Controllerable
{
    public function configureActions()
    {
        return [];
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    private function getQueueIblockId(): int
    {
        $iblockId = 0;
        $ibs = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => 'service_record']
        ])->fetch();
        if ($ibs) {
            $iblockId = $ibs['ID'];
        }
        return $iblockId;
    }

    private function getPostsIblockId(): int
    {
        $iblockId = 0;
        $ibs = IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => 'cars_posts']
        ])->fetch();
        if ($ibs) {
            $iblockId = $ibs['ID'];
        }
        return $iblockId;
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    public function addRecordAction()
    {
       $requestList = $this->request->getPostList()->toArray();
       $consentToCallFieldValues = $this->getProperty();
       if ($requestList['CONSENT_TO_CALL'] === 1) {
           $requestList['CONSENT_TO_CALL'] = $consentToCallFieldValues['Y'];
       } else {
           $requestList['CONSENT_TO_CALL'] = $consentToCallFieldValues['N'];
       }
       if ($requestList['PLANNED_DATE_START']) {
           if ($requestList['PARTS']) {
               $newDate = $this->setDateTime($requestList['PLANNED_DATE_START'], $requestList['PARTS']);
               if ($requestList['WORK']) {
                   $newDate = $this->setDateTime($newDate, $requestList['WORK']);
               }
           } else {
               $newDate = $this->setDateTime($requestList['PLANNED_DATE_START'], $requestList['WORK']);
           }
       }
        $requestList['PLANNED_DATE_END'] = $newDate;

       $queueIblockId = $this->getQueueIblockId();
       $ib = new CIBlockElement();
       if ($queueIblockId > 0) {
           $arFields = [
               'IBLOCK_ID' => $queueIblockId,
               'NAME' => $requestList['NAME'],
               'ACTIVE_FROM' => $requestList['PLANNED_DATE_START'],
               'ACTIVE_TO' => $requestList['PLANNED_DATE_END'],
               'PROPERTY_VALUES' => $requestList
           ];

           if (!$requestList['ELEMENT_ID'] || $requestList['ELEMENT_ID'] == 0) {
               return $this->addRecord($arFields);
           } else {
               $checkRecord = ElementServiceRecordTable::getList([
                   'select' => ['ID'],
                   'filter' => ['ID' => $requestList['ELEMENT_ID']]
               ])->fetch();
               if ($checkRecord['ID']) {
                   return $ib->Update($requestList['ELEMENT_ID'], $arFields);
               } else {
                   return $this->addRecord($arFields);
               }
           }
       }
    }

    public function addRecord($arFields)
    {
        $ib = new CIBlockElement();
        if($elem = $ib->Add($arFields)) {
            if (Loader::includeModule('crm')){
                $deal = new CCrmDeal(false);
                $dealFields['UF_CRM_DEAL_SC_RECORD_ID'] = $elem;
                $upd = $deal->Update($arFields['PROPERTY_VALUES']['CLIENT'], $dealFields);
            }
            return $elem;
        } else {
            return $ib->LAST_ERROR;
        }
    }
    private function getProperty(): array
    {
        $props = PropertyTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => 'CONSENT_TO_CALL']
        ]);
        $resultEnums = [];
        if ($property = $props->fetch()) {
            $propEnum = PropertyEnumerationTable::getList([
                'select' => ['ID', 'XML_ID'],
                'filter' => ['PROPERTY_ID' => $property['ID']]
            ]);
            while ($enumValue = $propEnum->fetch()) {
                $resultEnums[$enumValue['XML_ID']] = $enumValue['ID'];
            }
        }
        return $resultEnums;
    }

    /**
     * @throws SystemException
     * @throws ArgumentException
     */
    private function getQueueData(): void
    {
        $queueId = $this->request->get('id');

        $this->arResult['QUEUE_IBLOCK_ID'] = $this->getQueueIblockId();
        $this->arResult['POSTS_IBLOCK_ID'] = $this->getPostsIblockId();

        $queueTable = ElementServiceRecordTable::getList([
            'select' => ['*',
                         'POST_ID' => 'POST.IBLOCK_GENERIC_VALUE',
                         'DATE_ACTIVE_TO' => 'ACTIVE_TO',
                         'DATE_ACTIVE_FROM' => 'ACTIVE_FROM',
                         'ACCESS_DATE_VALUE' => 'ACCESS_DATE.VALUE',
                         'CHECK_INFORMATION_VALUE' => 'CHECK_INFORMATION.VALUE',
                         'CLIENT_ID' => 'CLIENT.VALUE',
                         'REASON_FOR_CONTACT_VALUE' => 'REASON_FOR_CONTACT.VALUE',
                         'STATUS_VALUE' => 'STATUS.VALUE',
                         'QUEUE_VALUE' => 'QUEUE.VALUE',
                         'DATE_FOR_NEXT_CONTACT_VALUE' => 'DATE_FOR_NEXT_CONTACT.VALUE',
                         'TYPES_OF_WORK_VALUE' => 'TYPES_OF_WORK.VALUE',
                         'MODEL_VALUE' => 'MODEL.VALUE',
                         'STATE_NUMBER_VALUE' => 'STATE_NUMBER.VALUE',
                         'SHASSI_VALUE' => 'SHASSI.VALUE',
                         'CONSENT_TO_CALL_VALUE' => 'CONSENT_TO_CALL.VALUE',
                         'PARTS_VALUE' => 'PARTS.VALUE',
                         'WORK_VALUE' => 'WORK.VALUE',
                         'CLIENT_NAME' => 'CLIENT_INFO.TITLE',
            ],
            'filter' => [
                'ID' => $queueId,
            ],
            'runtime' => [
                new Reference(
                    'CLIENT_INFO',
                    DealTable::class,
                    Join::on('this.CLIENT_ID', 'ref.ID'),
                    ['join_type' => 'inner']
                ),
            ]
        ]);
        $consentToCallValues = array_flip($this->getProperty());

        if ($queue = $queueTable->fetch()) {
            $this->arResult['QUEUE'] = $queue;
            $this->arResult['QUEUE']['POST'] = !empty($this->arResult['QUEUE']['POST_ID']) ? $this->getPostData($this->arResult['QUEUE']['POST_ID']) : "";
            $this->arResult['QUEUE']['LEAD'] = $this->arResult['QUEUE']['CLIENT_ID'] ? $this->getLeadData($this->arResult['QUEUE']['CLIENT_ID']) : "";
            $this->arResult['QUEUE']['CONSENT_TO_CALL_VALUE'] = $consentToCallValues[$queue['CONSENT_TO_CALL_VALUE']];
        }
    }

    /**
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws ArgumentException
     */
    private function getLeadData(int $leadId): string
    {
        $leadResult = [];
        $leads = DealTable::getList([
            'select' => ['TITLE'],
            'filter' => ['ID' => $leadId],
        ]);
        if ($lead = $leads->fetch()) {
            $leadResult = [
                "id" => $leadId,
                "entityId" => 'lead',
                "title" => $lead['TITLE'],
                'link' => "/crm/deal/details/".$leadId."/",
            ];

        }
        return Json::encode($leadResult);
    }

    /**
     * @throws ArgumentException
     */
    private function getPostData(int $postId): string
    {
        $postResult = [];
        $carsPosts = ElementCarsPostsTable::getList([
            'select' => ['NAME'],
            'filter' => ['ID' => $postId]
        ]);
        if ($post = $carsPosts->fetch()) {
            $postResult = [
                "id" => $postId,
                "entityId" => 'iblock-element',
                "title" => $post['NAME'],
            ];
        }
        return Json::encode($postResult);
    }

    private function setDateTime($date, $days): string
    {
        if ($date) {
            $interval = new \DateInterval('P'.$days.'D');
            $newDate = (new DateTime($date))->add($interval)->format('d.m.Y H:i:s');
        }
        return $newDate;
    }

    /**
     * @throws SystemException
     * @throws ArgumentException
     */
    public function executeComponent(): void
    {
        $this->getQueueData();
        $this->includeComponentTemplate();
    }
}