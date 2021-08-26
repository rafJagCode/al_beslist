<?php
function getBeslistCategories()
{
    $categoriesFilePath = _PS_MODULE_DIR_.'amelenbeslist/categories.json';
    $categoriesString = file_get_contents($categoriesFilePath);
    $categoriesJson = json_decode($categoriesString, true);
    return $categoriesJson;
}
