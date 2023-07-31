<?php

define('HL_VOTES_CODE','VOTES');
define('HL_POSTS_CODE','POSTS');



\Bitrix\Main\Loader::registerNamespace('Msoft\Team', $_SERVER['DOCUMENT_ROOT'] . '/local/modules/msoft.team/lib');

$eventManager = Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('', 'VOTESOnAfterAdd', ['Msoft\\Team\\HighloadBlockEventHandler', 'onAddVotes']);
$eventManager->addEventHandler('', 'POSTSOnAfterDelete', ['Msoft\\Team\\HighloadBlockEventHandler', 'onAfterDeletePost']);

function getClientIp()
{
    $ip = FALSE;
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        for ($i = 0; $i < count($ips); $i++)
        {
            if (!preg_match("/^(10|172\\.16|192\\.168)\\./", $ips[$i]))
            {
                $ip = $ips[$i];
                break;
            }
        }
    }
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}