<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Data\DataManager;

class TestPostsAndVotes20230728163941969814 extends BitrixMigration
{
    const HL_VOTE_NAME = 'VOTES';
    const HL_POST_NAME = 'POSTS';

    /**
     * Run the migration.
     *
     * @return mixed
     * @throws \Exception
     */
    public function up()
    {
        Loader::includeModule('highloadblock');
        $postHlId = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HL_POST_NAME);
        /** @var DataManager $votesEntity */
        $postEntity = HL\HighloadBlockTable::compileEntity($postHlId)->getDataClass();
        $postCount = 0;
        $postIds = [];
        while ($postCount <= 15) {
            $result = $postEntity::add([
                'UF_NAME' => 'INIT__PROJECT_TEST_POST_' . $postCount,
                'UF_VOTE_COUNT' => 0
            ]);
            if ($result->isSuccess()) {
                $postIds[] = $result->getId();
            }
            $postCount++;
        }

        $votesHlId = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HL_VOTE_NAME);
        /** @var DataManager $votesEntity */
        $voteEntity = HL\HighloadBlockTable::compileEntity($votesHlId)->getDataClass();

        foreach ($postIds as $postId) {
            $votesCount = rand(1, 5);
            $i = 0;
            while ($i < $votesCount) {
                $voteEntity::add([
                    'UF_POST_ID' => $postId,
                    'UF_IP_ADDRESS' => long2ip(rand(0, 4294967295))
                ]);
                $i++;
            }
        }
    }

    /**
     * Reverse the migration.
     *
     * @return mixed
     * @throws \Exception
     */
    public function down()
    {
        Loader::includeModule('highloadblock');
        $postHlId = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HL_POST_NAME);
        /** @var DataManager $votesEntity */
        $postEntity = HL\HighloadBlockTable::compileEntity($postHlId)->getDataClass();
        $dbRes = $postEntity::getList(['filter' => [
            '%=UF_NAME' => 'INIT__PROJECT_TEST_POST_%'
        ]]);

        while ($item = $dbRes->fetch()) {
            $postEntity::delete($item['ID']);
        }
    }

}
