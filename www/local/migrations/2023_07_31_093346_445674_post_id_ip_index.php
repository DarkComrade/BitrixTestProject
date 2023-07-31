<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Main\Loader;
use Msoft\Team\HighloadBlockHelper;
use Bitrix\Highloadblock as HL;

class PostIdIpIndex20230731093346445674 extends BitrixMigration
{
    const INDEX_NAME = 'UNIQUE_POST_ID_IP';

    /**
     * Run the migration.
     *
     * @return mixed
     * @throws \Exception
     */
    public function up()
    {
        Loader::includeModule('highloadblock');
        $postEntity = HighloadBlockHelper::compileEntityByCode(HL_VOTES_CODE);

        $sql = $sql = 'ALTER TABLE `' . $postEntity::getTableName() . '` MODIFY COLUMN `UF_IP_ADDRESS` VARCHAR(15) NULL;';
        $this->db->query($sql);

        $sql = 'ALTER TABLE `' . $postEntity::getTableName() . '` 
                ADD UNIQUE INDEX `' . self::INDEX_NAME . '` (`UF_POST_ID`, `UF_IP_ADDRESS`)';
        $this->db->query($sql);
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
        $postEntity = HighloadBlockHelper::compileEntityByCode(HL_VOTES_CODE);

        $sql = 'ALTER TABLE `' . $postEntity::getTableName() . '` DROP INDEX `' . self::INDEX_NAME . '`';
        $this->db->query($sql);
    }
}
