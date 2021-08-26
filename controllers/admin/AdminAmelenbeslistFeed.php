<?php
require_once __DIR__ . '/utils/generateFeed.php';
require_once __DIR__ . '/utils/getBeslistCategories.php';
require_once __DIR__ . '/utils/saveFeedSettings.php';

class AdminAmelenbeslistFeedController extends ModuleAdminController{
	public function __construct()
	{
		$this->bootstrap = false;
		parent::__construct();
	}
	public function initContent()
	{
		parent::initContent();


        $action = Tools::getValue('action');

        if($action === 'GET_BESLIST_CATEGORIES_DROPDOWN'){
            $this->getBeslistCategoryDropdown();
            return;
        }

        if($action === 'GENERATE_FEED'){
            generateFeed();
            return;
        }

        if($action === 'SAVE_FEED_SETTINGS'){
            saveFeedSettings();
            return;

        }

        //DISPLAY FEED SETTINGS
        $psCategories = $this->getPsCategories();

		$this->context->smarty->assign(['psCategories' => $psCategories, 'controller_link' => $this->context->link->getAdminLink('AdminAmelenbeslistFeed')]);
		$this->setTemplate('products.tpl');
	}

	public function getBeslistCategoryDropdown(){
        $beslistCategories = getBeslistCategories();
        $this->context->smarty->assign(['beslistCategories' => $beslistCategories]);
        $categoryTreeDropdown = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'amelenbeslist/views/templates/category-tree_dropdown.tpl');

        header('Content-Type: application/json');
        return $this->ajaxRender(json_encode($categoryTreeDropdown));
    }

    public function getPsCategories(){
        // get categories names from prestashop db
        $categoriesQuery = new DbQuery();
        $categoriesQuery->select('cl.name, cl.id_category, fs.beslist_name, fs.id_beslist_category, fs.enabled');
        $categoriesQuery->from('category_lang', 'cl');
        $categoriesQuery->leftJoin('amelenbeslist_feed_settings', 'fs', 'cl.id_category = fs.id_category');
        $categoriesQuery->where('cl.id_lang = 1');

        $psCategories = Db::getInstance()->executeS($categoriesQuery);
        return $psCategories;
    }







}