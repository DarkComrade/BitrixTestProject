<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;

class MsoftPostsVotes extends CBitrixComponent
{
    const HIGLOAD_POST_NAME = 'POSTS';

    public function onPrepareComponentParams($arParams)
    {
        $arParams['currentUserIP'] = getClientIp();
        return $arParams;
    }

    public function executeComponent()
    {
        CJSCore::Init(["jquery"]);
        CJSCore::Init();
        $this->includeComponentTemplate();
    }

}