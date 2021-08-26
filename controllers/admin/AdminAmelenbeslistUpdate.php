<?php

class AdminAmelenbeslistUpdateController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = false;
        parent::__construct();
    }
    public function initContent()
    {
        parent::initContent();
        $action = Tools::getValue('action');

        if($action === 'UPDATE'){

            return;
        }


        $page = Tools::getValue('page') ?: 1;
        $pagination = $this->getPagination();
        $changedProducts = $this->getChangedProducts($pagination->records_per_page, $page);

        $this->context->smarty->assign(['page' => $page, 'pagination' => $pagination, 'changedProducts' => $changedProducts, 'controller_link' => $this->context->link->getAdminLink('AdminAmelenbeslistUpdate')]);
        $this->setTemplate('updates.tpl');
    }

    public function getChangedProducts($limit, $page){
        $offset = ($page - 1) * $limit;
        $sql = new DbQuery();
        $sql->select('*');
        $sql->from('amelenbeslist_update');
        $sql->orderBy('updated');
        $sql->limit($limit, $offset);

        return Db::getInstance()->executeS($sql);
    }

    public function getTotalCountOfChangedItems(){
        $sql = new DbQuery();
        $sql->select('COUNT(*)');
        $sql->from('amelenbeslist_update');

        return Db::getInstance()->getValue($sql);
    }

    public function getPagination(){
        //PAGINATION SETTINGS
        $pagination = new stdClass();
        $pagination->records_per_page = 15;
        $pagination->total = $this->getTotalCountOfChangedItems();
        $pagination->pages = ceil($pagination->total / $pagination->records_per_page);
        return $pagination;
    }

    public function getAllChanges(){
        $sql = new DbQuery();
        $sql->select('ean13, quantity, price');
        $sql->from('amelenbeslist_update');

        return Db::getInstance()->executeS($sql);
    }

    public function getUpdatePayload($changes){
        $payload = [];
        foreach($changes as $changed){
            $price = [
                'regularPrice' => $changed['price']
            ];
            $stock = [
                'level' => $changed['quantity']
            ];
            $part_payload = [
                'externalId' => $changed['ean13'],
                'price' => $price,
                'stok' => $stock
            ];
            array_push($payload, $part_payload);
        }
        return $payload;
    }

    public function makeApiCall($payload){
        $apiKey = Configuration::get('AMELENBESLIST_APIKEY');
        $shopId = Configuration::get('AMELENBESLIST_SHOP_ID');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://shopitem.api.beslist.nl/v3/offer/shops/{$shopId}/batch",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                "apiKey: {$apiKey}",
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
}