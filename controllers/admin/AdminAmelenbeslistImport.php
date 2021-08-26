<?php

class AdminAmelenbeslistImportController extends ModuleAdminController
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

        if($action === 'SHOW_ORDER_DETAILS'){
            $order = json_decode(Tools::getValue('order'), true);

            $this->context->smarty->assign([
                'order' => $order,
            ]);

            $this->setTemplate('order_details.tpl');
            return;
        }


        $url = $this->getOrdersUrl();
        $orders = $this->getBeslistOrders($url, true);

        $this->context->smarty->assign([
            'orders' => $orders,
            'controller_link' => $this->context->link->getAdminLink('AdminAmelenbeslistImport')
        ]);
        $this->setTemplate('imports.tpl');
    }

    public function getOrdersUrl(){
        $orderXML = Configuration::get('AMELENBESLIST_ORDERXML');
        $clientId = Configuration::get('AMELENBESLIST_CLIENT_ID');
        $shopId = COnfiguration::get('AMELENBESLIST_SHOP_ID');
        $dateFrom = date('Y-m-d');
        $dateTo = $dateFrom;
        $checksum = md5($orderXML.$clientId.$shopId.$dateFrom.$dateTo);

        return "https://www.beslist.nl/xml/shoppingcart/shop_orders/?checksum={$checksum}&client_id={$clientId}&shop_id={$shopId}&date_from={$dateFrom}&date_to={$dateTo}";
    }

    public function getBeslistOrders($url, $test = false){
        if($test){
            $url = $url . '&output_type=test&test_orders=3';
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        //CONVERT TO JSON AND GET ORDERS
        $xml = simplexml_load_string($response);
        $json = json_encode($xml);
        $orders = json_decode($json,TRUE)['shopOrders']['shopOrder'];

        return $orders;
    }

}