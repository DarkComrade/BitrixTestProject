<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="voteBlock">
    <button class="voteBlock_item sendVote <?= ($arParams['CAN_VOTE']) ? "" : "nonActive" ?>"
            data-post="<?= $arParams['POST_ID'] ?>">
        Проголосовать
    </button>
    <div class="voteBlock_item isVoted <?= (!$arParams['CAN_VOTE']) ? "" : "nonActive" ?>"
         data-post="<?= $arParams['POST_ID'] ?>">Голос принят
    </div>
</div>
<div class="voteCount">
    <div>Проголосовало:&nbsp;</div>
    <div class="voteCountValue" data-post="<?= $arParams['POST_ID'] ?>"><?= $arParams['VOTE_COUNT'] ?></div>
</div>
