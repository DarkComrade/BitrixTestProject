<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;


class HlPostsCreate20230727091205960933 extends BitrixMigration
{
    const NAME = 'POSTS';
    const TABLE = 'badamshin_highload_post';

    /**
     * Run the migration.
     * @return mixed
     * @throws \Exception
     */
    public function up()
    {
        Loader::includeModule('highloadblock');

        $result = HL\HighloadBlockTable::add([
            'NAME' => self::NAME,
            'TABLE_NAME' => self::TABLE,
        ]);
        if (!$result->isSuccess()) {
            throw new MigrationException('Ошибка при добавлении highload блока' . print_r($result->getErrorMessages(), true));
        }
        $hlId = $result->getId();

        $entityId = 'HLBLOCK_' . $hlId;
        $oUserTypeEntity = new CUserTypeEntity();
        foreach ($this->userFields() as $aUserField) {
            $aUserField['ENTITY_ID'] = $entityId;
            if (!$oUserTypeEntity->Add($aUserField)) {
                throw new MigrationException('Ошибка при добавлении пользовательского свойства' . $aUserField['EDIT_FORM_LABEL']['ru']);
            }
        }
    }

    /**
     * Reverse the migration.
     * @return mixed
     * @throws \Exception
     */
    public function down()
    {
        Loader::includeModule('highloadblock');

        $hlblock = HL\HighloadBlockTable::getList(['filter' => ['=NAME' => self::NAME]])->fetch();
        if ($hlblock !== false) {
            $hlId = $hlblock['ID'];

            $oUserTypeEntity    = new CUserTypeEntity();
            $oUserTypeEntity->DropEntity('HLBLOCK_' . $hlId);

            $result = HL\HighloadBlockTable::delete($hlblock['ID']);
            if (!$result->isSuccess()) {
                throw new MigrationException('Ошибка при удалении highload блока' . print_r($result->getErrorMessages(), true));
            }
        }
    }


    /**
     * Список свойств
     * @return array
     */
    public function userFields()
    {
        return [
            [
                'FIELD_NAME'        => 'UF_NAME',
                'USER_TYPE_ID'      => 'string',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'Y',
                'EDIT_FORM_LABEL'   => [
                    'ru'    => 'Название',
                    'en'    => 'Name',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru'    => 'Название',
                    'en'    => 'Name',
                ],
                'LIST_FILTER_LABEL' => [
                    'ru'    => 'Название',
                    'en'    => 'Name',
                ],
                'SETTINGS' => [
                    'SIZE' => '256',
                ]
            ],
            [
                'FIELD_NAME'        => 'UF_VOTE_COUNT',
                'USER_TYPE_ID'      => 'integer',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'N',
                'SHOW_FILTER'       => 'Y',
                'EDIT_FORM_LABEL'   => [
                    'ru'    => 'Количество голосов',
                    'en'    => 'Vote Count',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru'    => 'Количество голосов',
                    'en'    => 'Vote Count',
                ],
                'LIST_FILTER_LABEL' => [
                    'ru'    => 'Количество голосов',
                    'en'    => 'Vote Count',
                ],
            ],
        ];
    }
}
