<?php
function saveFeedSettings(){
    $settings = Tools::getValue('settings');
    foreach($settings as $s){
        $id_category = $s['id_category'];
        $name = "'{$s['name']}'";
        $enabled = $s['enabled'];
        $id_beslist_category = empty($s['id_beslist_category']) ? 'NULL' : "'{$s['id_beslist_category']}'";
        $beslist_name = empty($s['beslist_name']) ? 'NULL' : "'{$s['beslist_name']}'";

        $sql = "INSERT INTO " ._DB_PREFIX_. "amelenbeslist_feed_settings (id_category, name, enabled, id_beslist_category, beslist_name)
                        VALUES({$id_category}, {$name}, ${enabled}, {$id_beslist_category}, {$beslist_name})
                        ON DUPLICATE KEY UPDATE 
                        name = {$name}, 
                        enabled = {$enabled}, 
                        id_beslist_category = {$id_beslist_category},
                        beslist_name = {$beslist_name}";

        Db::getInstance()->execute($sql);
    }
}