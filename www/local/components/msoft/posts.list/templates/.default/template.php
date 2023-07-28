<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<?=$arResult['USER_IP']?>

<div class="postsContainer">
    <div class="postsBlocks">
        <? foreach ($arResult['POSTS'] as $post) { ?>
            <div class="postBlock">
                <div> <?= $post['UF_NAME'] ?></div>
                <div><?=
                    $APPLICATION->IncludeComponent('msoft:posts.votes', '.default', [
                        'VOTE_COUNT' => (int)$post['UF_VOTE_COUNT'],
                        'USER_IP' => $arResult['USER_IP'],
                        'POST_ID' => $post['ID'],
                        'CAN_VOTE' => !$post['VOTED']
                    ]);
                    ?></div>
            </div>
        <? } ?>
    </div>
</div>

<? $APPLICATION->IncludeComponent(
    'bitrix:main.pagenavigation',
    'modern',
    array(
        'NAV_OBJECT' => $arResult['NAV'],
        'SEF_MODE' => 'N',
    ),
    false
);
?>
