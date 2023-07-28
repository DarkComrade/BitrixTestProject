<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Highloadblock as HL;
use Bitrix\Main\Loader;


class PostsVotesAjaxController extends \Bitrix\Main\Engine\Controller
{
    const HIGLOAD_VOTES_NAME = 'VOTES';

    protected function init()
    {
        parent::init();

        $this->setActionConfig('add', [
            '-prefilters' => [
                '\Bitrix\Main\Engine\ActionFilter\Authentication'
            ]
        ]);

    }

    public function addAction(array $fields)
    {
        Loader::includeModule('highloadblock');
        $votesHlId = \Msoft\Team\HighloadBlockHelper::getIdByCode(self::HIGLOAD_VOTES_NAME);
        /** @var DataManager $votesEntity */
        $votesEntity = HL\HighloadBlockTable::compileEntity($votesHlId)->getDataClass();

        $voteRes = $votesEntity::getList([
            'filter' => [
                'UF_POST_ID' => $fields['POST_ID'],
                'UF_IP_ADDRESS' => $_SERVER['REMOTE_ADDR']
            ],
            'limit' => 1]);
        if ($voteRes->fetch()) {
            return [
                'status' => false,
                'message' => "Вы уже проголосовали за этот пост!"
            ];
        }

        $result = $votesEntity::add([
            'UF_POST_ID' => $fields['POST_ID'],
            'UF_IP_ADDRESS' => $_SERVER['REMOTE_ADDR']
        ]);

        return [
            'status' => (bool)$result->isSuccess(),
            'postId' => $fields['POST_ID']
        ];
    }
}