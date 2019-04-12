<?php
/**
 * @author Visibilis Team
 * @date 1st April 2019
 * With this module, show the announcement on header
 */
class UspBar extends Module{

    /**
     * Baic configuration
     */

    public function __construct()
	{
        $this->name = 'uspbar';
        $this->displayName = 'USP Bar For Announcement';
		$this->version = '0.0.1';
        $this->author = 'Visibilis';
        $this->tab = 'front_office_features';
        $this->description = 'With this module, Show the announcement';		
        $this->bootstrap = true;
		parent::__construct();
		
    }
    /**
     * Register hook and create the table into database
     *
     * @return bool
     */
    public function install()
    {

        /* Adds Module */
        if (parent::install() &&
            $this->registerHook('backOfficeHeader') &&
            $this->registerHook('displayHeader') &&
            $this->registerHook('displayUspBar')
        )
        {
            $this->createTables();
            return true;
        }
        return false;
    }

    /**
     * Uninstall hook and drop the table from database
     *
     * @return bool
     */
    public function uninstall()
    {
        if (parent::uninstall()
            && $this->unregisterHook('backOfficeHeader')
            && $this->unregisterHook('displayHeader') && $this->unregisterHook('displayUspBar')) {
                
            /* Deletes tables */
			$this->deleteTables();

            return true;
        } else {
            return false;
        }
    }
    /**
	 * Creates tables
	 */
	protected function createTables()
	{
		/* Slides */
        return (bool)Db::getInstance()->execute('
			CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'uspbar` (
				`id_uspbar` int(10) unsigned NOT NULL AUTO_INCREMENT,
				`description` text  NULL,
			    `color` varchar(255)  NULL,
                 `link` varchar(255) NULL,
                 `active` tinyint(1) unsigned NOT NULL DEFAULT 0,
                 `date_upd` date NULL,
				PRIMARY KEY (`id_uspbar`)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=UTF8;
            
            INSERT INTO `ps_uspbar` (`id_uspbar`, `description`, `color`, `link`, `active`, `date_upd`) VALUES(1, "<p>Free delivery for orders above $500\n</p><p>Shop Now</p>", "#D89ABD", "http://www.google.com", 1, "2019-04-02"),
            (2, "UK\'s Premium Wholesaler <br> Wide Ranges & Sizes Available", "#97CCE5", "http://www.google.com", 1, "2019-04-02"),
            (3, "Worldwide Shipping Available<br>Find Out More", "#D1AA83", "http://www.google.com", 1, "2019-04-02");
		');

	}

	/**
	 * deletes tables
	 */
	protected function deleteTables()
	{
		return Db::getInstance()->execute('
			DROP TABLE IF EXISTS `'._DB_PREFIX_.'uspbar`;
		');
    }

    /**
     * Header Hook
     */
    
    public function hookdisplayHeader($params)
    {
        return $this->hookdisplayUspBar($params);
    }

    /**
     * Custom hook for uspbar
     */

    public function hookdisplayUspBar($params){
        $this->assignConfiguration();
        return $this->display(__FILE__, 'displayUspBar.tpl');
    }

    public function processConfiguration()
    {
        if (Tools::isSubmit('saveConfiguration'))
        {
            for($i=1; $i<=3; $i++){
                
                $active = Tools::getValue('active')[$i];
                $color = Tools::getValue('color')[$i];
                $description = Tools::getValue('description')[$i];
                $link = Tools::getValue('link')[$i];
                try{
                    $sql = 'UPDATE ps_uspbar SET 
                                color = \''.$color.'\',
                                description = \''.nl2br(addslashes($this->prepareBody($description))).'\',
                                link = \''.$link.'\',
                                active = \''.$active.'\',
                                date_upd = NOW()
                            WHERE id_uspbar = '.(int)$i;
                 //   echo $sql.'<br>';          
                  Db::getInstance()->executeS($sql);
                 
                } catch (PDOException $e) {
                    echo 'Sql Error: '. $e->getMessage() .'<br /><br />';
                }
              
            }
            //exit;
            $this->context->smarty->assign('confirmation', 'ok');

            Tools::redirectAdmin(AdminController::$currentIndex.'&configure='.$this->name.'&conf=4&token='.Tools::getAdminTokenLite('AdminModules'));
        }
    }

    public function assignConfiguration()
    {
        $uspBarListing = Db::getInstance()->executeS('SELECT * FROM `ps_uspbar` where active = 1');
        
        $this->context->smarty->assign('uspbarLists', $uspBarListing);
        $this->context->smarty->assign('countUspBar', count($uspBarListing));
        
    }

    /**
     * Show the configuration section on backend
     *
     * @return void
     */
    public function getContent()
    {
        $this->processConfiguration();
        $uspBarListing = Db::getInstance()->executeS('SELECT * FROM `ps_uspbar`');

        global $cookie;
        $iso = Language::getIsoById((int)($cookie->id_lang));
        $isoTinyMCE = (file_exists(_PS_ROOT_DIR_ . '/js/tiny_mce/langs/' . $iso . '.js') ? $iso : 'en');
        $ad = dirname($_SERVER["PHP_SELF"]);
        $this->context->smarty->assign('iso', $iso);
        $this->context->smarty->assign('isoTinyMCE', $isoTinyMCE);
        $this->context->smarty->assign('ad', $ad);
        
        $this->context->smarty->assign('uspbarLists', $uspBarListing);
        return $this->display(__FILE__, 'getContent.tpl');
    }

    public function prepareBody($body)
    {
        $body = str_replace(array(
            "\rn",
            "\r",
            "\n"
        ), array(
            ' ',
            ' ',
            ' '
        ), $body);
        $body = str_replace("// <![CDATA[", "", $body);
        $body = str_replace("// ]]>", "", $body);
        return $body;
    }

}


?>