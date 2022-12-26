<?php

use Bitrix\Main\Loader,
    Bitrix\Main\Localization\Loc,
    Bitrix\Main\Application;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();

Loc::loadMessages(__FILE__);

class RusoilAddApplication extends \CBitrixComponent
{
    protected $categories = [
        "Масла, автохимия, фильтры, Автоаксессуары, обогреватели, запчасти, сопутствующие товары",
        "Шины, диски"
    ];

    protected $types = [
        "Запрос цены и сроков поставки",
        "Пополнение складов",
        "Спецзаказ"
    ];

    protected $storages = [
        "Москва",
        "Новосибирск",
        "Тюмень"
    ];

    protected $brands = [
        "Michelin",
        "Continental",
        "Energy",
        "Bridgestone",
        "Yokohama",
    ];

    public function getResCategories()
    {
        return $this->categories;
    }

    public function getResTypes()
    {
        return $this->types;
    }

    public function getResStorages()
    {
        return $this->storages;
    }

    public function getResBrands()
    {
        return $this->brands;
    }

    public function checkParams()
    {
        if(empty($this->arParams["FORM_NAME"]))
        {
            $this->arParams["FORM_NAME"] = Loc::getMessage("RUSOIL_COMPONENT_DEFAULT_PARAM_FORM_NAME");
        }
    }

    public function getResult()
    {
        if($this->arParams["HIDE_CATEGORIES"] != "Y") $this->arResult['CATEGORIES'] = $this->getResCategories();
        if($this->arParams["HIDE_TYPES"] != "Y") $this->arResult['TYPES'] = $this->getResTypes();
        if($this->arParams["HIDE_STORAGES"] != "Y") $this->arResult['STORAGES'] = $this->getResStorages();
        $this->arResult['BRANDS'] = $this->getResBrands();
    }

    private function sendMail()
    {
        $files = [];

        $request = Application::getInstance()->getContext()->getRequest();

        $TEXT = "<b>Название: </b> {$request->get("name")} <br>";
        if($this->arParams["HIDE_CATEGORIES"] != "Y") $TEXT .= "<b>Категория: </b> {$this->categories[$request->get("categories")]} <br>";
        if($this->arParams["HIDE_TYPES"] != "Y") $TEXT .= "<b>Вид заявки: </b> {$this->types[$request->get("types")]} <br>";
        if($this->arParams["HIDE_STORAGES"] != "Y") $TEXT .= "<b>Склад поставки: </b> {$request->get("storage")} <br>";
        $TEXT .= "<b>Состав заявки: </b><br>";
        $TEXT .= "<table>";

        foreach ($request->get("elements")["brand"] as $kEl => $brand)
        {
            $n = $kEl + 1;

            $TEXT .= "<tr>";
            $TEXT .= "<td>{$n}. </td>";
            $TEXT .= "<td>{$request->get("elements")["brand"][$kEl]}</td>";
            $TEXT .= "<td>{$request->get("elements")["name"][$kEl]}</td>";
            $TEXT .= "<td>{$request->get("elements")["quantity"][$kEl]}</td>";
            $TEXT .= "<td>{$request->get("elements")["packing"][$kEl]}</td>";
            $TEXT .= "<td>{$request->get("elements")["client"][$kEl]}</td>";
            $TEXT .= "</tr>";
        }

        $TEXT .= "</table><br>";
        $TEXT .= "<b>Комментарий: </b> {$request->get("comment")} <br><br>";
        $TEXT .= "<i>Файлы к заявке находятся во вложении.</i> <br>";

        foreach ($_FILES["files"]["tmp_name"] as $kFile => $tmp_name){
            $arrFile = [
                "name" => $_FILES["files"]["name"][$kFile],
                "type" => $_FILES["files"]["type"][$kFile],
                "tmp_name" => $_FILES["files"]["tmp_name"][$kFile],
                "error" => $_FILES["files"]["error"][$kFile],
                "size" => $_FILES["files"]["size"][$kFile],
            ];

            if (!empty($tmp_name)) {
                $files[] = CFile::SaveFile($arrFile, "/form");
            }
        }

        $arEventFields = [
            "DEFAULT_EMAIL_FROM" => $this->arParams["EMAIL_FROM"],
            "EMAIL_TO" => $this->arParams["EMAIL_TO"],
            "SUBJECT" => $this->arParams["EMAIL_SUBJECT"],
            "TEXT" => $TEXT,
        ];

        if(CEvent::Send('FEEDBACK_FORM', SITE_ID, $arEventFields, 'Y', '', $files))
            return true;

        return false;
    }

    public function executeComponent()
    {
        try {
            // process POST data
            if ($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                if (!empty($_REQUEST["name"])
                    && ($_REQUEST["categories"] != "" || $this->arParams["HIDE_CATEGORIES"] == "Y")
                    && ($_REQUEST["types"] != "" || $this->arParams["HIDE_TYPES"] == "Y"))
                {
                    if($this->sendMail()) {
                        $this->arResult["DATA_SEND"]["STATUS"] = "SUCCESS";
                        $this->arResult["DATA_SEND"]["MESSAGE"] = Loc::getMessage("RUSOIL_COMPONENT_SEND_SUCCESS_MESSAGE");
                    }
                    else {
                        $this->arResult["DATA_SEND"]["STATUS"] = "ERROR";
                        $this->arResult["DATA_SEND"]["MESSAGE"] = Loc::getMessage("RUSOIL_COMPONENT_SEND_ERROR_MESSAGE");
                    }
                }
                else {
                    $this->arResult["DATA_SEND"]["STATUS"] = "ERROR";
                    $this->arResult["DATA_SEND"]["MESSAGE"] = Loc::getMessage("RUSOIL_COMPONENT_EMPTY_ERROR_MESSAGE");
                }
            }

            $this->checkParams();
            $this->getResult();
            $this->includeComponentTemplate();
        }
        catch (\Exception $e)
        {
            ShowError($e->getMessage());
        }
    }
}