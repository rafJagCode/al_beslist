<?php

function generateFeed(){
    $lacozziCategories = Tools::getValue('lacozziCategories');
    if(empty($lacozziCategories)){
        return;
    }

    $categoryMapping = Tools::getValue('categoryMapping');
    $products = getProducts($lacozziCategories);
    $products = getAdjustedProducts($products, $categoryMapping);
    createFeed($products);
}

function getProducts($categories_ids, $id_lang = 2, $only_active = true)
{

    $sql = new DbQuery();
    $sql->select('
            pa.ean13 as EAN,
            pa.id_product_attribute,
            p.id_product,
            pl.description_short as Titel,
            pl.description as Omshrijving,
            c.id_category as Categorie,
            m.name as Merk'
    );
    $sql->from('product_attribute', 'pa');

    $sql->leftJoin('product', 'p', 'pa.`id_product` = p.`id_product`');
    $sql->leftJoin('product_lang', 'pl', 'pa.`id_product` = pl.`id_product` AND pl.`id_lang` = '. intval($id_lang));
    $sql->leftJoin('category_product', 'c', 'pa.`id_product` = c.`id_product`');
    $sql->leftJoin('manufacturer', 'm', 'p.`id_manufacturer` = m.`id_manufacturer`');

    $sql->where('c.`id_category` IN (' . implode(',', $categories_ids) . ')');

    if ($only_active) {
        $sql->where('p.`active` = 1');
    }

    //OBLIGATORY FIELDS
    $sql->where('pa.ean13 IS NOT NULL');
    $sql->where('pl.description_short IS NOT NULL');
    $sql->where('pl.description IS NOT NULL');

    return Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);
}

function getAdjustedProducts($products, $categoryMapping){

    return array_map(function($product) use ($categoryMapping){

        //GET IMAGE_URL, PRODUCT_URL AND PRICE
        $object = new Product($product['id_product']);
        $link = new Link;
        $image = $link->getImageLink($object->link_rewrite[2], Image::getCover($object->id)['id_image'], 'home_default');
        $url = getProductLink($object);
        $price = Product::getPriceStatic($object->id, true, $product['id_product_attribute'], 2);
        $price = str_replace('.', ',', $price);

        //ADD COLOR, SEX AND BRAND FROM PRODUCT FEATURES
        $features = Product::getFrontFeaturesStatic(2, $object->id);
        foreach($features as $feature){
            if($feature['name'] === 'color'){
                $product['Kleur'] = $feature['value'];
            }
            if($feature['name'] === 'Genre' || $feature['name'] === 'Geslacht'){
                $product['Geslacht'] = $feature['value'];
            }
            if($feature['name'] === 'Materiaal' || $feature['name'] === 'mainmaterial'){
                $product['Geslacht'] = $feature['value'];
            }
            if($feature['name'] === 'Marka' || $feature['name'] === 'Merken') {
                $product['Merk'] = $feature['value'];
            }
        }

        //ADD SIZE AND COLOR FROM PRODUCT ATTRIBUTES
        $attributes = $object->getAttributeCombinations(2);
        foreach($attributes as $attribute){
            if($attribute['id_product_attribute'] != $product['id_product_attribute']){
                continue;
            }
            if($attribute['group_name'] === 'Maat'){
                $product['Maat'] = $attribute['attribute_name'];
            }
            if($attribute['group_name'] === 'Kleur'){
                $product['Kleur'] = $attribute['attribute_name'];
            }
        }


        //ASSIGN VALUES
        $product['Prijs'] = $price;
        $product['Image_URL'] = $image;
        $product['Product_URL'] = $url;
        $product['Prijs_België'] = $price;
        $product['Verzendkosten'] = '5,00';
        $product['Verzendkosten_België'] = '5,00';
        $product['Levertijd'] = '1 werkdag';
        $product['Levertijd_België'] = '3 tot 5 werkdagen';
        $product['Conditie'] = 'nieuw';
        $product['Omshrijving'] = strip_tags(str_replace('<', ' <', $product['Omshrijving']));
        $product['Unieke_Code'] = $product['EAN'];
        $product['Variantcode'] = $product['EAN'];
        $product['Categorie'] = $categoryMapping[$product['Categorie']];

        //UNSET UNUSED PROPERTIES
        unset($product['id_product']);
        unset($product['id_product_attribute']);
        return $product;
    }, $products);
}

function getProductAttributePrice($id_product_attribute)
{
    $rq = Db::getInstance()->getRow('
		SELECT `price`
		FROM `'._DB_PREFIX_.'product_attribute`
		WHERE `id_product_attribute` = '.intval($id_product_attribute));
    return $rq['price'];
}

function getProductLink($id_product)
{
    return
        _PS_BASE_URL_.__PS_BASE_URI__.
        (($id_product->category != 'home' AND !empty($id_product->category)) ? $id_product->category.'/' : '')
        .intval($id_product->id).'-'.$id_product->link_rewrite[2].($id_product->ean13 ? '-'.$id_product->ean13 : '').'.html';
}

function createFeed($products){
    // creating object of SimpleXMLElement
    $xml_data = new SimpleXMLElement('<?xml version="1.0" encoding="utf-8"?><Feed></Feed>');

    // function call to convert array to xml
    array_to_xml($products,$xml_data);
    echo json_encode($xml_data);
    //saving generated xml file;
    $path = _PS_MODULE_DIR_ . 'amelenbeslist/feed.xml';
    $result = $xml_data->asXML($path);
    return $result;
}

function array_to_xml( $data, &$xml_data ) {
    foreach( $data as $key => $value ) {
        if( is_array($value) ) {
            if( is_numeric($key) ){
                $key = 'Product'; //dealing with <0/>..<n/> issues
            }
            $subnode = $xml_data->addChild($key);
            array_to_xml($value, $subnode);
        } else {
            $xml_data->addChild("$key",htmlspecialchars("$value"));
        }
    }
}
