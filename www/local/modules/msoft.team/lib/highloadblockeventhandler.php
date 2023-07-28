<?php

namespace Msoft\Team;

use Bitrix\Main\Application;
use Bitrix\Main\DB\Exception;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\Event;
use Bitrix\Highloadblock as HL;


class HighloadBlockEventHandler
{
    const HIGLOAD_POST_NAME = 'POSTS';
    const HIGLOAD_VOTES_NAME = 'VOTES';

    public static function onAddVotes(Event $event)
    {
        $arParam = $event->getParameters();
        $conn = Application::getConnection();
        $conn->startTransaction();
        try {

            $postId = $arParam['fields']['UF_POST_ID'];
            $votesHlId = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HIGLOAD_VOTES_NAME);
            /** @var DataManager $votesEntity */
            $votesEntity = HL\HighloadBlockTable::compileEntity($votesHlId)->getDataClass();

            $count = $votesEntity::getCount(
                [
                    '=UF_POST_ID' => $postId,
                ]
            );
            if (!$count) {
                throw new Exception('Ошибка при получении количества голосов');
            }

            $postsHlId = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HIGLOAD_POST_NAME);
            /** @var DataManager $postEntity */
            $postEntity = HL\HighloadBlockTable::compileEntity($postsHlId)->getDataClass();

            $postEntity::update($postId, [
                'UF_VOTE_COUNT' => $count
            ]);
            $conn->commitTransaction();
        } catch (\Exception $exception) {
            $conn->rollbackTransaction();
        }

    }
}