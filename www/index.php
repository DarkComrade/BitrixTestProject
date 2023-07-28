<?
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
$APPLICATION->SetTitle('Главная');

$APPLICATION->IncludeComponent('msoft:posts.list','.default',[]);

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');
?>