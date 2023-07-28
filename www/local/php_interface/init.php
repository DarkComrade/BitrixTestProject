<?php

\Bitrix\Main\Loader::registerNamespace('Msoft\Team', $_SERVER['DOCUMENT_ROOT'] . '/local/modules/msoft.team/lib');

$eventManager = Bitrix\Main\EventManager::getInstance();

$eventManager->addEventHandler('', 'VOTESOnAfterAdd', ['Msoft\\Team\\HighloadBlockEventHandler', 'onAddVotes']);
$eventManager->addEventHandler('', 'POSTSOnAfterDelete', ['Msoft\\Team\\HighloadBlockEventHandler', 'onAfterDeletePost']);