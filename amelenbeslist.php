<?php
/**
* 2007-2021 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2021 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Amelenbeslist extends Module
{
    protected $config_form = false;

    public function __construct()
    {
        $this->name = 'amelenbeslist';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Rafał Jagielski';
        $this->need_instance = 0;

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = false;
        parent::__construct();

        $this->displayName = $this->l('Amelen Beslist');
        $this->description = $this->l('Module integrating prestashop with beslist.nl');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }

    public function getContent()
    {
        /**
         * If values have been submitted in the form, process.
         */
        if (((bool)Tools::isSubmit('submitAmelenbeslistModule')) == true) {
            $this->postProcess();
        }

        $this->context->smarty->assign('module_dir', $this->_path);

        $output = $this->context->smarty->fetch($this->local_path . 'views/templates/admin/configure.tpl');

        return $output . $this->renderForm();

    }

    /**
     * Create the form that will be displayed in the configuration of your module.
     */
    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitAmelenbeslistModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            . '&configure=' . $this->name . '&tab_module=' . $this->tab . '&module_name=' . $this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm(array($this->getConfigForm()));
    }

    /**
     * Create the structure of your form.
     */
    protected function getConfigForm()
    {
        return array(
            'form' => array(
                'legend' => array(
                    'title' => $this->l('Settings'),
                    'icon' => 'icon-cogs',
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'name' => 'AMELENBESLIST_SHOP_ID',
                        'label' => $this->l('SHOP ID'),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'AMELENBESLIST_CLIENT_ID',
                        'label' => $this->l('CLIENT ID'),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'AMELENBESLIST_ORDERXML',
                        'label' => $this->l('ORDER XML'),
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'AMELENBESLIST_APIKEY',
                        'label' => $this->l('APIKEY'),
                    ),
                ),
                'submit' => array(
                    'title' => $this->l('Save'),
                ),
            ),
        );
    }

    /**
     * Set values for the inputs.
     */
    protected function getConfigFormValues()
    {
        return array(
            'AMELENBESLIST_SHOP_ID' => Configuration::get('AMELENBESLIST_SHOP_ID', '642812'),
            'AMELENBESLIST_CLIENT_ID' => Configuration::get('AMELENBESLIST_CLIENT_ID', '23690'),
            'AMELENBESLIST_ORDERXML' => Configuration::get('AMELENBESLIST_ORDERXML', '137b2d6df0e7669defcc81a8769a9ed6'),
            'AMELENBESLIST_APIKEY' => Configuration::get('AMELENBESLIST_APIKEY', 'MQRuSxmFjuNG3uZEKQNKoND0GCbun55szKT9A9TU9moyYUIog2hHiJYR4K5oSlbjM3aB44Uc'),
        );
    }

    /**
     * Save form data.
     */
    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();

        foreach (array_keys($form_values) as $key) {
            Configuration::updateValue($key, Tools::getValue($key));
        }
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        Configuration::updateValue('AMELENBESLIST_LIVE_MODE', false);

        $this->installTabs();

        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('actionUpdateQuantity') &&
            $this->createDB() &&
            $this->createUpdateDB() &&
            $this->createFeedSettingsDB();
    }

    public function uninstall()
    {
        Configuration::deleteByName('AMELENBESLIST_LIVE_MODE');

        $this->uninstallTabs();

        return parent::uninstall() &&
            $this->removeDB() &&
            $this->removeUpdateDB() &&
            $this->removeFeedSettingsDB();
    }

    public function uninstallTabs(){

        $tab1 = new Tab((int)Tab::getIdFromClassName('Amelenbeslist'));
        $tab2 = new Tab((int)Tab::getIdFromClassName('AdminAmelenbeslistFeed'));
        $tab3 = new Tab((int)Tab::getIdFromClassName('AdminAmelenbeslistUpdate'));

        $tab1->delete();
        $tab2->delete();
        $tab3->delete();
    }

    public function installTabs(){

        //CREATE MAIN TAB
        $tab = new Tab();
        $tab->id_parent = (int)Tab::getIdFromClassName('IMPROVE');
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = 'Amelen Beslist';
        }
        $tab->class_name = 'Amelenbeslist';
        $tab->module = $this->name;
        $tab->active = 1;
        $tab->add();
        $tab->save();

        $mainTabId = $tab->id;

        //CREATE CHILD TABS

        $childTab = new Tab();
        $childTab->id_parent = $mainTabId;
        foreach (Language::getLanguages(true) as $lang) {
            $childTab->name[$lang['id_lang']] = 'Ustawienia FEED';
        }
        $childTab->class_name = 'AdminAmelenbeslistFeed';
        $childTab->module = $this->name;
        $childTab->active = 1;
        $childTab->add();
        $childTab->save();

        $childTab = new Tab();
        $childTab->id_parent = $mainTabId;
        foreach (Language::getLanguages(true) as $lang) {
            $childTab->name[$lang['id_lang']] = 'Export stanów magazynowych i cen';
        }
        $childTab->class_name = 'AdminAmelenbeslistUpdate';
        $childTab->module = $this->name;
        $childTab->active = 1;
        $childTab->add();
        $childTab->save();

        $childTab = new Tab();
        $childTab->id_parent = $mainTabId;
        foreach (Language::getLanguages(true) as $lang) {
            $childTab->name[$lang['id_lang']] = 'Import zamówień';
        }
        $childTab->class_name = 'AdminAmelenbeslistImport';
        $childTab->module = $this->name;
        $childTab->active = 1;
        $childTab->add();
        $childTab->save();
    }
    /**
     * Add the CSS & JavaScript files you want to be loaded in the BO.
     */
    public function hookBackOfficeHeader()
    {
        if (Tools::getValue('module_name') !== $this->name) {
            $this->context->controller->addJS($this->_path . 'views/js/back.js');
            $this->context->controller->addCSS($this->_path . 'views/css/back.css');

        }
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path . '/views/js/front.js');
        $this->context->controller->addCSS($this->_path . '/views/css/front.css');
    }

    public function createDB()
    {
        return Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'amelenbeslist_feed
			(
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
				`value` varchar(3000) CHARACTER SET utf8 DEFAULT NULL,
				`status` tinyint(1) NOT NULL DEFAULT "1",
				`category` int(11) DEFAULT NULL,
				PRIMARY KEY (`id`)
			)');
    }

    public function removeDB()
    {
        return Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'amelenbeslist_feed`');
    }

    public function createFeedSettingsDB()
    {
        return Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'amelenbeslist_feed_settings
			(
				`id_category` int(11) NOT NULL,
				`enabled` boolean DEFAULT "0",
				`name` text,
				`beslist_name` text,
				`id_beslist_category` int(11) UNSIGNED,
				PRIMARY KEY (`id_category`)
			)');
    }

    public function removeFeedSettingsDB()
    {
        return Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'amelenbeslist_feed_settings`');

    }

    public function createUpdateDB()
    {
        return Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS ' . _DB_PREFIX_ . 'amelenbeslist_update
			(
				`ean13` varchar(13),
				`id_product` int(11),
				`reference` text,
				`quantity` int,
				`price` text,
				`updated` datetime,
				PRIMARY KEY (`ean13`)
			)');
    }

    public function removeUpdateDB()
    {
        return Db::getInstance()->Execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'amelenbeslist_update`');

    }
//    public function hookActionObjectProductUpdateAfter($params){
//
//    }

    public function hookActionUpdateQuantity($params){
        $id_product_attribute = $params['id_product_attribute'];

        if(empty($id_product_attribute)){
            return;
        }

        $sql = new DbQuery();
        $sql->select('ean13');
        $sql->from('product_attribute');
        $sql->where("id_product_attribute = {$id_product_attribute}");
        $ean13 = Db::getInstance()->getRow($sql)['ean13'];

        if(empty($ean13)){
            return;
        }

        $id_product = $params['id_product'];
        $quantity = $params['quantity'];
        $product = new Product($id_product);
        $price = Product::getPriceStatic($product->id, true, $id_product_attribute, 2);
        $price = str_replace('.', ',', $price);
        $reference = $product->reference;
        $updated = date('Y-m-d H:i:s');

        $sql = "INSERT INTO " ._DB_PREFIX_. "amelenbeslist_update (ean13, id_product, reference, quantity, price, updated)
                        VALUES('${ean13}', {$id_product}, '{$reference}', {$quantity}, '{$price}', '{$updated}')
                        ON DUPLICATE KEY UPDATE 
                        id_product = {$id_product}, 
                        reference = '{$reference}', 
                        quantity = {$quantity},
                        updated = '{$updated}',
                        price = '{$price}'";

        Db::getInstance()->execute($sql);
    }

    public function log($variable){
        $dir = _PS_MODULE_DIR_ . 'amelenbeslist/file.log';
        file_put_contents($dir, '***START***'. PHP_EOL . var_export($variable, true) . PHP_EOL . '***END***' . PHP_EOL, FILE_APPEND);
    }
}
