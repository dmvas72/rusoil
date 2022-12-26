<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Localization\Loc as Loc;

try
{
    $arComponentParameters = array(
        "GROUPS" => array(
            "FORM_PARAMS" => array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_FORM_GROUP_PARAMS")
            ),
            "SEND_NOTICE" => array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_FORM_GROUP_PARAMS_SEND")
            ),
        ),
        "PARAMETERS" => array(
            "TITLE" => array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_TITLE"),
                "TYPE" => "STRING",
                "DEFAULT" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_DEFAULT_TITLE"),
                "PARENT" => "FORM_PARAMS",
            ),
            "HIDE_CATEGORIES" => Array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_HIDE_CATEGORIES"),
                "TYPE" => "CHECKBOX",
                "MULTIPLE" => "N",
                "VALUE" => "Y",
                "DEFAULT" =>"N",
                "PARENT" => "FORM_PARAMS",
            ),
            "HIDE_TYPES" => Array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_HIDE_TYPES"),
                "TYPE" => "CHECKBOX",
                "MULTIPLE" => "N",
                "VALUE" => "Y",
                "DEFAULT" =>"N",
                "PARENT" => "FORM_PARAMS",
            ),
            "HIDE_STORAGES" => Array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_HIDE_STORAGES"),
                "TYPE" => "CHECKBOX",
                "MULTIPLE" => "N",
                "VALUE" => "Y",
                "DEFAULT" =>"N",
                "PARENT" => "FORM_PARAMS",
            ),
            "EMAIL_FROM" => array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_EMAIL_FROM"),
                "TYPE" => "STRING",
                "DEFAULT" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_DEFAULT_EMAIL_FROM"),
                "PARENT" => "SEND_NOTICE",
            ),
            "EMAIL_TO" => array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_EMAIL_TO"),
                "TYPE" => "STRING",
                "DEFAULT" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_DEFAULT_EMAIL_TO"),
                "PARENT" => "SEND_NOTICE",
            ),
            "EMAIL_SUBJECT" => array(
                "NAME" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_PARAMS_EMAIL_SUBJECT"),
                "TYPE" => "STRING",
                "DEFAULT" => Loc::GetMessage("RUSOIL_ADD_APPLICATION_DEFAULT_EMAIL_SUBJECT"),
                "PARENT" => "SEND_NOTICE",
            ),
        ),
    );
} catch (Main\LoaderException $e) {
    ShowError($e->getMessage());
}