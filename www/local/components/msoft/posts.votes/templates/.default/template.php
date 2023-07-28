<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="voteCount"><?= $arParams['VOTE_COUNT'] ?></div>
<div class="voteBlock">
    <button class="sendVote <?= ($arParams['CAN_VOTE']) ? "" : "nonActive" ?>" data-post="<?= $arParams['POST_ID'] ?>">
        Проголосовать
    </button>
    <div class="isVoted <?= (!$arParams['CAN_VOTE']) ? "" : "nonActive" ?>" data-post="<?= $arParams['POST_ID']?>">Голос принят</div>
</div>