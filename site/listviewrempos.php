<?php
/**
 * System Plugin.
 *
 * @package    ListViewRemPos
 * @subpackage Plugin
 * @author     Hans-Guenter Heiserholt {@link http://www.moba-hgh.de}
 * @author     Created on 18-Sep-2014
 * @license    GNU/GPL Public License version 2 or later
 *
 * 1.1.1 + code restructering
 * 1.1.0 + changed all buttons with listitemtask ....
 *       + changed homepage-/mail-address
 *       + some errors into joomla message-queue
 *       + asset-files to media-folder
 *       + joomla updateserver
 *       + default-option: option=com_fields    enabled  (since J3.7)
 *       + up to github
 * 1.0.5 + some code optimasation
 * 1.0.4   - not released
 * 1.0.3 + correction of menutypes blockade
 * 1.0.2 + std-options enabled
 *       ° change cookie-handling js
 * 1.0.1 + default-option: option=com_installer enabled 
 *       + default-option: option=com_tags      enabled
 *       + default-option: option=com_finder    enabled
 *       + default-option: option=com_search    enabled
 *       + default-option: option=com_media     enabled
 *       + default-option: option=com_redirect  enabled
 *       - com_menue
 *       + com_menus
 * 1.0.0 First Edition
 * 
 **/
defined( '_JEXEC' ) || die( 'Restricted access' );
jimport( 'joomla.plugin.plugin' );
class plgSystemListViewRemPos extends JPlugin
{
    /**
     * Define some variables for later global use
     */
		var $com_adv_found;
		var $com_adv;
		var $com_std_found;
		var $com_std;
    /**
     * Constructor
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
		public function __construct(& $subject, $config)
		{       
			parent::__construct($subject, $config);
			global $com_adv_found;
			global $com_adv;
			global $com_std_found;
			global $com_std;
			/* ----------------------------------
			 * load the default language file
			 * ---------------------------------- */  
			$language = JFactory::getLanguage();
			$language->load('plg_system_listviewrempos', JPATH_ADMINISTRATOR, 'en-GB', true);
			$language->load('plg_system_listviewrempos', JPATH_ADMINISTRATOR,    null, true);
			/* ----------------------------------
			 * check plugin-parms
			 * ---------------------------------- */  
			$this->checkAdvParms();
			$this->checkStdParms();
			/* ----------------------------------
			 * Get a handle to the Joomla! application object
			 * ---------------------------------- */  
			$application = JFactory::getApplication();
			if ($com_adv_found === true || $com_std_found === true) 
			{
				if ( strpos ($_SERVER['REQUEST_URI'],'=edit') || strpos ($_SERVER['REQUEST_URI'],'id=')	) 
				{
		//			 do nothing in editor-mode !
					return;     
				}
				/* ----------------------------------
				 * get the document-objekt
				 * ---------------------------------- */
				$doc = & JFactory::getDocument();
				/* ----------------------------------
				 * put in js-script to load js-code in html
				 * ---------------------------------- */
					$doc->addScript('../media/plg_listviewrempos/js/listviewrempos.js');
				/* ----------------------------------
				 * set load-event to html
				 * ---------------------------------- */  
				$content = "\n 
				/* Start dyn. event-management by plugin: listviewrempos */
					window.addEventListener('load', function() { LVRP_scroll2Pos();} )
				/* End dyn. event-management by plugin: listviewrempos */ \n\n";
				$doc->addScriptDeclaration( $content );
			}
			return;
		} // End function __construct
    /**
     * Event onAfterRender
     */
		public function onAfterRender() 
		{            
			/* ----------------------------------
			 * get global variable
			 * ---------------------------------- */
			global $com_adv_found;
			global $com_adv;
			global $com_std_found;
			global $com_std;
			/* ----------------------------------
			 * do change html
			 * ---------------------------------- */
			if ($com_adv_found === true || $com_std_found === true)
			{
				/* ----------------------------------
				 * get the rendered html
				 * ---------------------------------- */
				$html = JResponse::getbody();
				/* ----------------------------------
				 * extract the body-code ... all between <body> .... </body>
				 * ---------------------------------- */
				$regex = '#<body(.*?)</body># sU';
				preg_match($regex, $html, $match);
				/* ----------------------------------
				 * set some work variables
				 *
				 * Note: The oncl-variable contains the name
				 * of the javascript-funktion to get/save and set
				 * the clicked position within the list
				 * ---------------------------------- */
				$oncl = 'onclick="LVRP_getPos()" ';
				$admin_lnk ='/administrator/index.php?option=';
				if ($com_adv) 
				{
					$href = 'href="' .$admin_lnk .$com_adv;
					$hrefH = 'href="http://' .$_SERVER['HTTP_HOST'] .$admin_lnk .$com_adv;
					$href2 = 'href="index.php?option=' .$com_adv;       
				}
				elseif ($com_std) 
				{
					$href = 'href="' .$admin_lnk .$com_std;
					$hrefH = 'href="http://' .$_SERVER['HTTP_HOST'] .$admin_lnk .$com_std;
					$href2 = 'href="index.php?option=' .$com_std;             
					$hrefP = 'href="http://' .$_SERVER['HTTP_HOST'] .'/images';   // bei com_media
				}
				else 
				{
				/*
				 * Add a messages to the message queue
				 */
					$application->enqueueMessage(JText::_(PLG_SYSTEM_LVRP_NOPARMS), 'warning');         
				} 
				/* ----------------------------------
				 * do the change: 
				 * Put the onClick call before all matching href's
				 *
				 * str_replace ( such-string , ergebnis , zu durchsuchender string  )
				 * ----------------------------------------------------------------- */
				$body_new = str_replace($href, $oncl .$href, $match[0]);
				$body_new = str_replace($hrefH, $oncl .$hrefH, $body_new);
				$body_new = str_replace($href2, $oncl .$href2, $body_new);
				if ($com_std == 'com_media') 
				{
					$body_new = str_replace($hrefP, $oncl .$hrefP, $body_new);
				}
				$oncl1 = 'return listItemTask';
				$oncl2 = 'LVRP_getPos();' .$oncl1;
				$body_new = str_replace($oncl1, $oncl2, $body_new);
				$html = str_replace($match[0], $body_new, $html);
				/* ----------------------------------
				 * put back the changed html
				 * ---------------------------------- */
				JResponse::setBody($html);
			}
		} // End  function onAfterRender
    /**
     * Log events.
     *
     * @param string $event The event to be logged.
     * @param string $comment A comment about the event.
     */
		private function _log ($status, $comment)
		{
		}
		public function loadparms($subject, $config) 
		{
			/* ----------------------------------
			 * load the extended plugin-params
			 * ---------------------------------- */
			$params = $this->params;
		}
		public function checkAdvParms() 
		{
		  /************************************************************
		   * This function checks if the joomla extended-call-strings 
		   * of   > extra installed extensions <   should be checked.
		   * -----------------------------------------------------------     
		   * Note: the user can define them by the extended plugin-parms
		   ************************************************************ */
			global $com_adv_found;
			global $com_adv;
			$com_adv_found = false;
			$com_adv = '';
			/* ------------------------------------------------------------
			 *  user listview call-strings 
			 *  if parm(0 ... 15) is used, search url and if found, set flag
			 * ------------------------------------------------------------ */
			if ( $this->params->get('adv_parm_0') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_0'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_0');
				}
			}
			if ( $this->params->get('adv_parm_1') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_1'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_1');
				}
			}
			if ( $this->params->get('adv_parm_2') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_2'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_2');
				}
			}
			if ( $this->params->get('adv_parm_3') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_3'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_3');
				}
			}
			if ( $this->params->get('adv_parm_4') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_4'))) {
					$com_adv_found = true;     
					$com_adv = $this->params->get('adv_parm_4');
				}
			}
			if  ( $this->params->get('adv_parm_5') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_5'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_5');
				}
			}
			if ( $this->params->get('adv_parm_6') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_6'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_6');
				}
			}
			if ( $this->params->get('adv_parm_7') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_7'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_7');
				}
			}
			if ( $this->params->get('adv_parm_8') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_8'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_8');
				}
			}
			if ( $this->params->get('adv_parm_9') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_9'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_9');
				}
			}     
			if ( $this->params->get('adv_parm_10') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_10'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_10');
				}
			}
			if ( $this->params->get('adv_parm_11') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_11'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_11');
				}
			}
			if ( $this->params->get('adv_parm_12') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_12'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_12');
				}
			}
			if ( $this->params->get('adv_parm_13') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_13'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_13');
				}
			}
			if ( $this->params->get('adv_parm_14') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_14'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_14');
				}
			}
			if ( $this->params->get('adv_parm_15') ) {
				if (strpos ($_SERVER['REQUEST_URI'], $this->params->get('adv_parm_15'))) {
					$com_adv_found = true;
					$com_adv = $this->params->get('adv_parm_15');
				}
			}
			return;
		} // End function checkAdvParms
		public function checkStdParms() 
		{
			/************************************************************
			 * This function checks if the call-strings of standard-extensions 
			 * of joomla should be checked. 
			 * -----------------------------------------------------------     
			 * Note: the user can switch them off/on via plugin-parms
			 ************************************************************ */
			global $com_std_found;
			global $com_std;
			$com_std_found = false;
			$com_std = '';
			/* -----------------------------------
			 * system-plugin listview call-strings
			 * ! values are logical  !!!              
			 * ----------------------------------- */
			if (strpos ($_SERVER['REQUEST_URI'],'option=com_banners') ) {
				if ( $this->params->get('LVRP_com_banners') ) {
					$com_std_found = true;
					$com_std = 'com_banners';
				}
			}          
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_categories') ) {
				if ( $this->params->get('LVRP_com_categories') ) {
					$com_std_found = true;
					$com_std = 'com_categories';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_contact') ) {
				if ( $this->params->get('LVRP_com_contact') ) {
					$com_std_found = true;
					$com_std = 'com_contact';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_content') ) {
				if ( $this->params->get('LVRP_com_content') ) {
					$com_std_found = true;
					$com_std ='com_content';
				}
			}      
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_finder') ) {
				if ( $this->params->get('LVRP_com_finder') ) {
					$com_std_found = true;
					$com_std = 'com_finder';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_installer') ) {
				if ( $this->params->get('LVRP_com_installer') ) {
					$com_std_found = true;
					$com_std = 'com_installer';
				}
			}   
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_languages') ) {
				if ( $this->params->get('LVRP_com_languages') ) {
					$com_std_found = true;
					$com_std = 'com_languages';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_media') ) {
				if ( $this->params->get('LVRP_com_media') ) {
					$com_std_found = true;
					$com_std = 'com_media';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_menus') ) {
				if ( $this->params->get('LVRP_com_menus') ) {
					$com_std_found = true;
					$com_std = 'com_menus';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_messages') ) {
				if ( $this->params->get('LVRP_com_messages') ) {
					$com_std_found = true;
					$com_std = 'com_messages';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_modules') ) {
				if ( $this->params->get('LVRP_com_modules') ) {
					$com_std_found = true;
					$com_std = 'com_modules';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_newsfeeds') ) {
				if ( $this->params->get('LVRP_com_newsfeeds') ) {
					$com_std_found = true;
					$com_std = 'com_newsfeeds';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_plugins') ) {
				if ( $this->params->get('LVRP_com_plugins') ) {
					$com_std_found = true;
					$com_std = 'com_plugins';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_redirect') ) {
				if ( $this->params->get('LVRP_com_redirect') ) {
					$com_std_found = true;
					$com_std = 'com_redirect';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_search') ) {
				if ( $this->params->get('LVRP_com_search') ) {
					$com_std_found = true;
					$com_std = 'com_search';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_tags') ) {
				if ( $this->params->get('LVRP_com_tags') ) {
					$com_std_found = true;
					$com_std = 'com_tags';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_templates') ) {
				if ( $this->params->get('LVRP_com_templates') ) {
					$com_std_found = true;
					$com_std = 'com_templates';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_users') ) {
				if ( $this->params->get('LVRP_com_users') ) {
					$com_std_found = true;
					$com_std = 'com_users';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_weblinks') ) {
				if ( $this->params->get('LVRP_com_weblinks') ) {
					$com_std_found = true;
					$com_std = 'com_weblinks';
				}
			}
			elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_fields') ) {   // since 3.7
				if ( $this->params->get('LVRP_com_fields') ) {
					$com_std_found = true;
					$com_std = 'com_fields';
				}
			}
			return;
		} // End function checkStdParms    
} // End class plgSystemListViewRemPos
?>