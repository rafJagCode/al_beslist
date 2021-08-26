<?php
//Functions for generating categories json

     function getCategoryTree(){
        $categoriesRawFilePath = _PS_MODULE_DIR_.'amelenbeslist_feed/categoriesRaw.json';
        $categoriesRawString = file_get_contents($categoriesRawFilePath);
        $categoriesRawJson = json_decode($categoriesRawString, true);
        $mainCategories = $categoriesRawJson['categories']['maincat'];
        $categoriesPaths = $this->getCategoriesPaths($mainCategories);
        // dump($name);
        $categoriesFilePath = _PS_MODULE_DIR_.'amelenbeslist_feed/categories.json';
        $fp = fopen($categoriesFilePath, 'w');
        fwrite($fp, json_encode($categoriesPaths));
        fclose($fp);
     }

    function getCategoriesPaths($mainCategories){
        $categoriesPaths = array();
        foreach($mainCategories as $category){
            if(array_key_exists('level_1', $category)){
                foreach($category['level_1'] as $subcategory){
                    if(array_key_exists('level_2', $subcategory)){
                        foreach($subcategory['level_2'] as $subsubcategory){
                            $path = array($category['-name'] => $category['-id'], $subcategory['-name'] => $subcategory['-id'], $subsubcategory['-name'] => $subsubcategory['-id']);
                            array_push($categoriesPaths, $path);
                        }
                    }
                }
            }
            else{
                array_push($categoriesPaths, array($category['-name'] => $category['-id']));
            }
        }
        return $categoriesPaths;
    }

