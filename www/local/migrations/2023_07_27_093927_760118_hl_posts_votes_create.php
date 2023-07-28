<?php

use Arrilot\BitrixMigrations\BaseMigrations\BitrixMigration;
use Arrilot\BitrixMigrations\Exceptions\MigrationException;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;


class HlPostsVotesCreate20230727093927760118 extends BitrixMigration
{
    const NAME = 'VOTES';
    const TABLE = 'badamshin_highload_votes';

    const POST_HL_NAME = 'POSTS';

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
                throw new MigrationException('Ошибка при добавлении пользовательского свойства ' . $aUserField['EDIT_FORM_LABEL']['ru']);
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

            $oUserTypeEntity = new CUserTypeEntity();
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
        $postHl = HL\HighloadBlockTable::getList(['filter' => ['=NAME' => self::POST_HL_NAME]])->fetch();
        $hlPostId = $postHl['ID'];
        if(empty($hlPostId)) {
            throw new MigrationException('Ошибка при удалении highload блока, не найден HL POSTS');
        }

        return [
            [
                'FIELD_NAME'        => 'UF_POST_ID',
                'USER_TYPE_ID'      => 'hlblock',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'Y',
                'EDIT_FORM_LABEL'   => [
                    'ru'    => 'Пост',
                    'en'    => 'Post',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru'    => 'Пост',
                    'en'    => 'Post',
                ],
                'LIST_FILTER_LABEL' => [
                    'ru'    => 'Пост',
                    'en'    => 'Post',
                ],
                'SETTINGS' => [
                    'DISPLAY' => 'LIST',
                    'LIST_HEIGHT' => 1,
                    'HLBLOCK_ID' => $hlPostId,
                    'HLFIELD_ID' => 0,
                    'DEFAULT_VALUE' => ''
                ]
            ],
            [
                'FIELD_NAME'        => 'UF_IP_ADDRESS',
                'USER_TYPE_ID'      => 'string',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'Y',
                'EDIT_FORM_LABEL'   => [
                    'ru'    => 'IP Адрес',
                    'en'    => 'IP address',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru'    => 'IP Адрес',
                    'en'    => 'IP address',
                ],
                'LIST_FILTER_LABEL' => [
                    'ru'    => 'IP Адрес',
                    'en'    => 'IP address',
                ],
                'SETTINGS' => [
                    'SIZE' => '15',
                ]
            ],
            [
                'FIELD_NAME'        => 'UF_CREATE_DATE_TIME',
                'USER_TYPE_ID'      => 'datetime',
                'MULTIPLE'          => 'N',
                'MANDATORY'         => 'Y',
                'SHOW_FILTER'       => 'Y',
                'EDIT_FORM_LABEL'   => [
                    'ru'    => 'Время создания',
                    'en'    => 'Date create',
                ],
                'LIST_COLUMN_LABEL' => [
                    'ru'    => 'Время создания',
                    'en'    => 'Date create',
                ],
                'LIST_FILTER_LABEL' => [
                    'ru'    => 'Время создания',
                    'en'    => 'Date create',
                ],
                'SETTINGS' => [
                    'DEFAULT_VALUE' => [
                        'TYPE' => 'NOW',
                        'VALUE' => ''
                    ],
                ]
            ],
        ];
    }
}
