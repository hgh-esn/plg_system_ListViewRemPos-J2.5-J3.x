<?php
/**
 * System Plugin.
 *
 * @package    ListViewRemPos
 * @subpackage Plugin
 * @author     Hans-Guenter Heiserholt {@link http://www.web-hgh.de}
 * @author     Created on 18-Sep-2014
 * @license    GNU/GPL Public License version 2 or later
 *
 * 1.0.0 First Edition
 * 1.0.1 + default-option: option=com_installer enabled 
 *       + default-option: option=com_tags      enabled
 *       + default-option: option=com_finder    enabled
 *       + default-option: option=com_search    enabled
 *       + default-option: option=com_media     enabled
 *       + default-option: option=com_redirect  enabled
 *       - com_menue
 *       + com_menus
 * 1.0.2 + std-options enabled
 *       ° change cookie-handling js
 * 1.0.3 + correction of menutypes blockade
 * 
 */
 
//-- No direct access

defined( '_JEXEC' ) || die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgSystemListViewRemPos extends JPlugin
{
    /**
     * Constructor
     *
     * @param object $subject The object to observe
     * @param array $config  An array that holds the plugin configuration
     */
     
    var $com_adv_found;
      
    public function __construct(& $subject, $config)
    {
        $doSomething = 'here';

      parent::__construct($subject, $config);
      
         /* ----------------------------------
          * load the language file
          * ---------------------------------- */  
        
//       $this->loadLanguage();
         
         $language = JFactory::getLanguage();
         $language->load('pjg_system_listviewrempos', JPATH_ADMINISTRATOR, 'en-GB', true);
         $language->load('pjg_system_listviewrempos', JPATH_ADMINISTRATOR,    null, true);

         /* ----------------------------------
          * load the plugin-params
          * ---------------------------------- */
        
        $params = $this->params;   
//       $params = {"comp_0":"com_jcomments","adv_parm_1":"","adv_parm_2":"","adv_parm_3":"","adv_parm_4":"","adv_parm_5":"","adv_parm_6":"","adv_parm_7":"","adv_parm_8":"","adv_parm_9":"","adv_parm_10":"","adv_parm_11":"","adv_parm_12":"","adv_parm_13":"","adv_parm_14":"","adv_parm_15":""}
/*
         $params_0 = $this->params->get('adv_parm_0');
         $params_1 = $this->params->get('adv_parm_1');
         $params_2 = $this->params->get('adv_parm_2');
         $params_3 = $this->params->get('adv_parm_3');
         $params_4 = $this->params->get('adv_parm_4');
         $params_5 = $this->params->get('adv_parm_5');
         $params_6 = $this->params->get('adv_parm_6');
         $params_7 = $this->params->get('adv_parm_7');
         $params_8 = $this->params->get('adv_parm_8');
         $params_9 = $this->params->get('adv_parm_9');
         $params_10 = $this->params->get('adv_parm_10');
         $params_11 = $this->params->get('adv_parm_11');
		 $params_12 = $this->params->get('adv_parm_12');
         $params_13 = $this->params->get('adv_parm_13');
         $params_14 = $this->params->get('adv_parm_14');
         $params_14 = $this->params->get('adv_parm_15');
 */       
//       echo  '<br /><br /><br />params_0 = ' .$params_0;

         /* ----------------------------------------
          * fill variable for dynamic if-statement 
          * ---------------------------------------- */

         global $com_adv_found;
         global $com_std_found;
		 global $com_std;

         $com_adv_found = false;
         $com_std_found = false;
		 $com_std='';

//       echo  '<br /><br /><br />function __construct:com_flg_found_load = ' .$com_adv_found;
//       echo              '<br />function __construct: url = '  .$_SERVER['REQUEST_URI'];

         /* ------------------------------------------------------------
          *  user plugin listview call-strings 
          *  if parm(0 ... 14) is used, search url and if found, set flag
          * ------------------------------------------------------------ */

      if ($this->params->get('adv_parm_0')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_0'))) {
 //			echo 'this-params-getadv_parm_0'.$params_0;
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_1')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_1'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_2')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_2'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_3')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_3'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_4')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_4'))) {
            $com_adv_found = true;     
         }
      }
	  elseif  ($this->params->get('adv_parm_5')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_5'))) {
            $com_adv_found = true;
         }
      }
	  elseif ($this->params->get('adv_parm_6')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_6'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_7')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_7'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_8')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_8'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_9')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_9'))) {
            $com_adv_found = true;
         }
      }     
      elseif ($this->params->get('adv_parm_10')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_10'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_11')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_11'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_12')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_12'))) {
            $com_adv_found = true;
         }
      }
	  elseif ($this->params->get('adv_parm_13')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_13'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_14')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_14'))) {
            $com_adv_found = true;
         }
      }
      elseif ($this->params->get('adv_parm_15')) {
         if (strpos ($_SERVER['REQUEST_URI'],'option=' .$this->params->get('adv_parm_15'))) {
            $com_adv_found = true;
         }
      }
	  	  	  	  
         /* -----------------------------------
          * system-plugin listview call-strings 
          * ----------------------------------- */

	  if (strpos ($_SERVER['REQUEST_URI'],'option=com_banners')) {
		  If ($this->params->get('LVRP_com_banners')) {
			$com_std_found = true;
		  }
      }		  	  
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_categories')) {
		  If ($this->params->get('LVRP_com_categories')) {
			$com_std_found = true;
		  }
	  }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_contact')) {
 		  If ($this->params->get('LVRP_com_contact')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_content')) {
		  If ($this->params->get('LVRP_com_content')) {
			$com_std_found = true;
		  }
	  }		 
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_finder')) {
  		  If ($this->params->get('LVRP_com_finder')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_installer')) {
		  If ($this->params->get('LVRP_com_installer')) {
			$com_std_found = true;
		  }
      }   
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_languages')) {
 		  If ($this->params->get('LVRP_com_languages')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_media')) {
  		  If ($this->params->get('LVRP_com_media')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_menus')) {
		 if (strpos ($_SERVER['REQUEST_URI'],'view=menutypes')) 
		 {
			 // do nothing
		 }
		 else {
 		  If ($this->params->get('LVRP_com_menus')) {
			$com_std_found = true;
		  }
		 }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_messages')) {
 		  If ($this->params->get('LVRP_com_messages')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_modules')) {
 		  If ($this->params->get('LVRP_com_modules')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_newsfeeds')) {
 		  If ($this->params->get('LVRP_com_newsfeeds')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_plugins')) {
  		  If ($this->params->get('LVRP_com_plugins')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_redirect')) {
  		  If ($this->params->get('LVRP_com_redirect')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_search')) {
 		  If ($this->params->get('LVRP_com_search')) {
			$com_std_found = true;
		  }
      }
	  elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_tags')) {
 		  If ($this->params->get('LVRP_com_tags')) {
			$com_std_found = true;
		  }
      }
	  elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_templates')) {
		  If ($this->params->get('LVRP_com_templates')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_users')) {
 		  If ($this->params->get('LVRP_com_users')) {
			$com_std_found = true;
		  }
      }
      elseif (strpos ($_SERVER['REQUEST_URI'],'option=com_weblinks')) {
		If ($this->params->get('LVRP_com_weblinks')) {
			$com_std_found = true;
		  }
      }

//  echo    '<br /><br /><br />function __construct:com_flg_found = ' .$com_adv_found;    
//	    $com_adv_found = false;
//		$com_std_found = false;
/*		
        if ($com_adv_found === false && $com_std_found === false) {
			// Get a handle to the Joomla! application object
			$application = JFactory::getApplication();
			
			// Add a message to the message queue
 			$application->enqueueMessage(JText::_('keine Komponenten Parameter > com_xxxxxxx < definiert!'), 'error');
			$session = JFactory::getSession();
			$session->set('application.queue', null);
		}
*/
		if ($com_adv_found === true || $com_std_found === true) {
         /* ----------------------------------
         * get the document-objekt
         * ---------------------------------- */

         $doc =& JFactory::getDocument();

         /* ----------------------------------
         * load js-file
         * ---------------------------------- */

         $doc->addScript('/plugins/system/listviewrempos/js/listviewrempos.js');

         /* ----------------------------------
         * set load-event
         * ---------------------------------- */  

         $content = "/* Start dyn. event-management by plugin: listviewrempos */ 
   window.addEvent('load', function() { 
      go2pos(); 
   }) 
/* End dyn. event-management by plugin: listviewrempos */;";  

         $doc->addScriptDeclaration( $content );

        }
 //		JFactory::getApplication()->clearMessageQueue('all');
//$session = JFactory::getSession();
//$session->set('application.queue', null); 
    }
    
    /**
     * Event onAfterRender
     */
    public function onAfterRender()
    { 	
		if (strpos ($_SERVER['REQUEST_URI'],'layout=edit')) {
          //
          // do nothing in editor-mode !
          //
//       echo  '<br /><br /><br />onAfterRender: r e t u r n';
          return;     
		};
	  		    
         /* ----------------------------------
          * get global variable
          * ---------------------------------- */

		global $com_adv_found;
		global $com_std_found;
		
         /* ----------------------------------
          * do change html
          * ---------------------------------- */

		if ($com_adv_found === true || $com_std_found === true) {
      
//    echo  '<br /><br /><br />onAfterRender: com_flg_found=true';     
         /* ----------------------------------
         * get the rendered html
         * ---------------------------------- */

         $html = JResponse::getBody();

         /* ----------------------------------
         * get only the body code in match[0]
         * ---------------------------------- */

         $regex = '#<body(.*?)</body># sU';
         preg_match($regex, $html, $match);

         /* ----------------------------------
         * set some work variables
         *
         * Note: The oncl-variable contains the name
         * of the javascript-funktion to get and save
         * the clicked position within the list
         * ---------------------------------- */

         $oncl = 'onclick="getDocPos()" ';
         $href = 'href="/';
         $href2 = 'href="index.php';
         /* ----------------------------------
         * do the change: 
         * Put the onClick call before href
         * ---------------------------------- */

         $body_new = str_replace($href, $oncl .$href, $match[0]);      

         $body_new = str_replace($href2, $oncl .$href2, $body_new);      

         $html = str_replace($match[0], $body_new, $html);

         /* ----------------------------------
         * put back the changed html
         * ---------------------------------- */
         JResponse::setBody($html);
      }
      return;
    }

    /**
     * Log events.
     *
     * @param string $event The event to be logged.
     * @param string $comment A comment about the event.
     */
    private function _log ($status, $comment)
    {
//       echo '<br /><br /><br /><br /><br />HGH-Log:<br /><br />';
   /*
        jimport('joomla.error.log');

        JLog::getInstance('plugin_system_example_log.php')
        ->addEntry(array('event' => $event, 'comment' => $comment));
   */
    }
}
?>