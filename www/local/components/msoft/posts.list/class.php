<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Data\DataManager;


class MsoftPostsList extends CBitrixComponent
{
    const HIGLOAD_POST_NAME = 'POSTS';
    const HIGLOAD_VOTES_NAME = 'VOTES';

    public function onPrepareComponentParams($arParams)
    {
        $arParams['currentUserIP'] = $_SERVER['REMOTE_ADDR'];

        return $arParams;
    }

    public function executeComponent()
    {
        Loader::includeModule('highloadblock');
        Loader::includeModule('msoft.team');


        $this->arResult['USER_IP'] = $this->arParams['currentUserIP'];
        $this->arResult['POSTS'] = $this->getPostsList();
        $this->setIsVotedByUser();
        $this->includeComponentTemplate();
    }

    protected function getPostsList()
    {
        $postsData = [];

        $id = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HIGLOAD_POST_NAME);
        /** @var DataManager $postEntity */
        $postEntity = HL\HighloadBlockTable::compileEntity($id)->getDataClass();
        $allCount = $postEntity::getCount();

        $nav = new \Bitrix\Main\UI\PageNavigation('post');
        $nav->setPageSize(5)
            ->initFromUri();
        $nav->setRecordCount($allCount);

        /** @var \Bitrix\Main\ORM\Query\Result $dbRes */
        $dbRes = $postEntity::getList([
            'offset' => $nav->getOffset(),
            'limit' => $nav->getLimit(),
        ]);

        while ($item = $dbRes->fetch()) {
            $postsData[$item['ID']] = $item;
            $postsData[$item['ID']]['VOTED'] = false;
        }
        $this->arResult['NAV'] = $nav;

        return $postsData;
    }

    protected function setIsVotedByUser()
    {
        if (empty($this->arResult['POSTS'])) return [];
        $postIds = array_column($this->arResult['POSTS'], 'ID');

        $id = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HIGLOAD_VOTES_NAME);
        /** @var DataManager $postEntity */
        $postEntity = HL\HighloadBlockTable::compileEntity($id)->getDataClass();

        $dbRes = $postEntity::getList([
            'filter' => [
                '=UF_POST_ID' => $postIds,
                '=UF_IP_ADDRESS' => $this->arParams['currentUserIP']
            ]
        ]);

        while ($item = $dbRes->fetch()) {
            $this->arResult['POSTS'][$item['UF_POST_ID']]['VOTED'] = true;
        }
    }
}