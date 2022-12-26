<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);

use \Bitrix\Main\Localization\Loc;

\Bitrix\Main\UI\Extension::load("ui.bootstrap4");
\Bitrix\Main\UI\Extension::load("jquery3");
?>

<? if(!empty($arResult["DATA_SEND"])): ?>
    <p class="<?=($arResult["DATA_SEND"]["STATUS"] == "SUCCESS" ? "text-success" : "text-danger")?>"><?=$arResult["DATA_SEND"]["MESSAGE"]?></p>
<? endif; ?>

<div class="application">
    <? if(!empty($arParams["FORM_NAME"])): ?>
        <div class="application__title mb-4">
            <h2 class="font-weight-bold"><?=$arParams["FORM_NAME"]?></h2>
        </div>
    <? endif; ?>
    <div class="application__form mb-5">
        <form method="post" action="#" enctype="multipart/form-data">
            <div class="form-group form-group__adaptive">
                <label for="applicationName">Заголовок заявки</label>
                <input type="text" name="name" class="form-control" id="applicationName" placeholder="Введите название заявки" required>
            </div>

            <? if(!empty($arResult["CATEGORIES"]) && is_array($arResult["CATEGORIES"])): ?>
                <div class="form-group">
                    <label>Категория</label>

                    <? foreach($arResult["CATEGORIES"] as $kCat => $category): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="categories" id="category<?=$kCat?>" value="<?=$kCat?>" required>
                            <label class="form-check-label" for="category<?=$kCat?>"><?=$category;?></label>
                        </div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>

            <? if(!empty($arResult["TYPES"]) && is_array($arResult["TYPES"])): ?>
                <div class="form-group">
                    <label>Вид заявки</label>

                    <? foreach($arResult["TYPES"] as $kType => $type): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="types" id="type<?=$kType?>" value="<?=$kType?>" required>
                            <label class="form-check-label" for="type<?=$kType?>"><?=$type;?></label>
                        </div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>

            <? if(!empty($arResult["STORAGES"]) && is_array($arResult["STORAGES"])): ?>
                <div class="form-group form-group__adaptive">
                    <label for="applicationStorages">Склад поставки</label>
                    <select name="storage" class="form-control" id="applicationStorages">
                        <? foreach($arResult["STORAGES"] as $storage): ?>
                            <option><?=$storage;?></option>
                        <? endforeach; ?>
                    </select>
                </div>
            <? endif; ?>

            <div class="form-group mb-5">
                <label>Состав заявки</label>
                <div class="application-elements">
                    <div class="application-elements__content">
                        <div class="application-elements__rows">
                            <div class="application-elements__row">
                                <div class="application-elements__line row row-cols-lg-5">
                                    <div class="col col-12">
                                        <label for="applicationElementBrand">Бренд</label>
                                        <select name="elements[brand][]" class="form-control" id="applicationElementBrand">
                                            <option value="0" selected>Выберите бренд</option>
                                            <? if(!empty($arResult["BRANDS"]) && is_array($arResult["BRANDS"])): ?>
                                                <? foreach($arResult["BRANDS"] as $brand): ?>
                                                    <option><?=$brand;?></option>
                                                <? endforeach; ?>
                                            <? endif; ?>
                                        </select>
                                    </div>
                                    <div class="col col-12">
                                        <label for="applicationElementName">Наименование</label>
                                        <input type="text" name="elements[name][]" class="form-control" id="applicationElementName">
                                    </div>
                                    <div class="col col-12">
                                        <label for="applicationElementQuantity">Количество</label>
                                        <input type="text" name="elements[quantity][]" class="form-control" id="applicationElementQuantity">
                                    </div>
                                    <div class="col col-12">
                                        <label for="applicationElementPacking">Фасовка</label>
                                        <input type="text" name="elements[packing][]" class="form-control" id="applicationElementPacking">
                                    </div>
                                    <div class="col col-12">
                                        <label for="applicationElementClient">Клиент</label>
                                        <input type="text" name="elements[client][]" class="form-control" id="applicationElementClient">
                                    </div>
                                </div>
                                <div class="application-elements__btns">
                                    <div class="application-elements__btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-square-fill -js-btn_add_element" viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0z"/>
                                        </svg>
                                    </div>
                                    <div class="application-elements__btn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square-fill -js-btn_remove_element" viewBox="0 0 16 16">
                                            <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm3.354 4.646L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 1 1 .708-.708z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <input type="file" name="files[]" class="form-control-file" id="applicationFiles" multiple>
            </div>
            <div class="form-group form-group__adaptive">
                <label class="form-check-label" for="exampleCheck1">Комментарий</label>
                <textarea class="form-control" name="comment" aria-label="With textarea"></textarea>
            </div>
            <button type="submit" class="btn"><?=Loc::getMessage("FORM_APPLY");?></button>
        </form>
    </div>
</div>