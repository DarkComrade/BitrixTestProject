<?php

namespace Msoft\Team;

use Bitrix\Main\Application;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Event;
use Bitrix\Highloadblock as HL;


class HighloadBlockEventHandler
{

    public static function onAddVotes(Event $event)
    {
        $arParam = $event->getParameters();
        $conn = Application::getConnection();
        $conn->startTransaction();
        try {
            $postId = $arParam['fields']['UF_POST_ID'];

            /** @var DataManager $votesEntity */
            $votesEntity = \Msoft\Team\HighloadBlockHelper::compileEntityByCode(HL_VOTES_CODE);


            $count = $votesEntity::getCount(
                [
                    '=UF_POST_ID' => $postId,
                ]
            );
            if (!$count) {
                throw new Exception('Ошибка при получении количества голосов');
            }

            /** @var DataManager $postEntity */
            $postEntity = \Msoft\Team\HighloadBlockHelper::compileEntityByCode(HL_POSTS_CODE);

            $postEntity::update($postId, [
                'UF_VOTE_COUNT' => $count
            ]);
            $conn->commitTransaction();
        } catch (\Exception $exception) {
            $conn->rollbackTransaction();
        }
    }

    public static function onAfterDeletePost(Event $event)
    {
        $arParam = $event->getParameters();
        $postId = $arParam['id']['ID'];
        $votesEntity = \Msoft\Team\HighloadBlockHelper::compileEntityByCode(HL_VOTES_CODE);

        $dbRes = $votesEntity::getList([
                'select' => [
                    'ID'
                ],
                'filter' => [
                    '=UF_POST_ID' => $postId,
                ]
            ]
        );

        while ($voteItem = $dbRes->fetch()) {
            $votesEntity::delete($voteItem['ID']);
        }
    }
}