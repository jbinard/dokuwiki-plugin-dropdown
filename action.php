<?php 

/**
 * Plugin Dropdown : create dropdown menus with javascript
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Johan Binard <johan.binard@gmail.com>
 */

// must be run within DokuWiki
if(!defined('DOKU_INC')) die();

if(!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN',DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_dropdown extends DokuWiki_Action_Plugin {
 
	/**
	* return some info
	*/
	function getInfo(){
		return array(
			'author' => 'Johan Binard',
			'email'  => 'johan.binard@gmail.com',
			'date'   => '2013-04-11',
			'name'   => 'Dropdown',
			'desc'   => 'Creat menus with display and JavaScript',
			'url'    => '',
			);
	}
 
	/**
	* Register handlers with the DokuWiki's event controller
	*/ 
	function register(&$controller) {
		$controller->register_hook('TPL_METAHEADER_OUTPUT', 'BEFORE',  $this, '_hookjs');
		$controller->register_hook('TPL_ACT_RENDER', 'BEFORE', $this, '_hide', array());  
	}
   
	/**
	* Load javascript 
	*/
	function _hookjs(&$event, $param) {
	$event->data["script"][] = array ("type" => "text/javascript",
									"charset" => "utf-8",
									"_data" => "",
									"src" => DOKU_BASE."lib/plugins/dropdown/showhide.js"
									);
	}
	
	/**
    * Hide div with "hidden" class 
    */
	function _hide(&$event, $param) {
	   echo '<body onload="hide();">';
   }
}
