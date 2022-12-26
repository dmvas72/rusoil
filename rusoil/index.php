<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

/**
 * @global CMain $APPLICATION
 */

$APPLICATION->SetTitle("Русойл");
?>

<?$APPLICATION->IncludeComponent(
    "rusoil:form.application.new",
    "",
    Array(
        "EMAIL_FROM" => "notice@rusoil72.ru",
        "EMAIL_SUBJECT" => "RUSOIL | Новая заявка",
        "EMAIL_TO" => "vasilicyndmitry@gmail.com",
        "FORM_NAME" => "Новая заявка",
        "HIDE_CATEGORIES" => "N",
        "HIDE_STORAGES" => "N",
        "HIDE_TYPES" => "N",
    )
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>