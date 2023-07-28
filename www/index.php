<?
require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/header.php');
$APPLICATION->SetTitle('Главная');

$APPLICATION->IncludeComponent(
    'msoft:posts.list',
    '.default',
    [
        'NAV_PAGE_SIZE' => 5,
    ]);

require($_SERVER['DOCUMENT_ROOT'] . '/bitrix/footer.php');
?>