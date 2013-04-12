<?php
 
 
 
/**
 * Plugin Dropdown : create dropdown menus with javascript
 * 
 * @license    GPL 2 (http://www.gnu.org/licenses/gpl.html)
 * @author     Johan Binard <johan.binard@gmail.com>
 */
 
// must be run within DokuWiki
if (!defined('DOKU_INC'))
	die();
 
if (!defined('DOKU_PLUGIN'))
	define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');
require_once (DOKU_PLUGIN . 'syntax.php');
 
/**
 * All DokuWiki plugins to extend the parser/rendering mechanism
 * need to inherit from this class
 */
class syntax_plugin_dropdown extends DokuWiki_Syntax_Plugin {
 
	/**
	 * return some info
	 */
	function getInfo() {
		return array (
			'author' => 'Johan Binard',
			'email' => 'johan.binard@gmail.com',
			'date' => '2013-04-11',
			'name' => 'Dropdown',
			'desc' => 'Create dropdown menu with javascript',
			'url' => '',
		);
	}
 
	// Get the type of syntax this plugin defines
	function getType() {
		return 'container';
	}
	
	// Close <p> tag before the syntax of the plugin
	function getPType(){
		return 'block';
	}
	
	// List of allowed syntax types inside the syntax of the plugin
	function getAllowedTypes() {
		return array (
			'formatting',
			'substition',
			'disabled',
			'container'
		);
	}
	
	// Add the plugin syntax after the formating syntax
	function getSort() {
		return 131;
	}
	
	// Define the opening tag corresponding to the syntax of the plugin
	function connectTo($mode) {
		$this->Lexer->addEntryPattern('<dropdown.*?>(?=.*?</dropdown>)', $mode, 'plugin_dropdown');
	}
	
	// Define the closing tag corresponding to the syntax of the plugin
	function postConnect() {
		$this->Lexer->addPattern('<lvl1.*?>', 'plugin_dropdown');
		$this->Lexer->addPattern('</lvl1>', 'plugin_dropdown');
		$this->Lexer->addPattern('<lvl2.*?>', 'plugin_dropdown');
		$this->Lexer->addPattern('</lvl2>', 'plugin_dropdown');
		$this->Lexer->addPattern('<lvl3.*?>', 'plugin_dropdown');
		$this->Lexer->addPattern('</lvl3>', 'plugin_dropdown');
		$this->Lexer->addExitPattern('</dropdown>', 'plugin_dropdown');
	}
 
	/**
	 * Handle the match
	 */
	function handle($match, $state, $pos, & $handler) {
		switch ($state) {
			case DOKU_LEXER_ENTER:
				return array (
					$state,
				);
				
			case DOKU_LEXER_MATCHED:
				// opening tag for lvl 1
				if(substr($match, 0, 6) == '<lvl1 '){
					preg_match('/\"(.*?)\"/', $match, $result);
					$name = $result[1];
					$type = 'opening_1';
					return array (
						$state,
						array (
							$name,
							$type
						)
					);
				}
				//closing tag for lvl 1
				if(substr($match, 0, 6) == '</lvl1'){
					$type = 'closing_1';
					return array (
						$state,
						array (
							'',
							$type
						)
					);
				}
				// opening tag for lvl 2
				if(substr($match, 0, 6) == '<lvl2 '){
					preg_match('/\"(.*?)\"/', $match, $result);
					$name = $result[1];
					$type = 'opening_2';
					return array (
						$state,
						array (
							$name,
							$type
						)
					);
				}
				//closing tag for lvl 2
				if(substr($match, 0, 6) == '</lvl2'){
					$type = 'closing_2';
					return array (
						$state,
						array (
							'',
							$type
						)
					);
				}
				//opening tag for lvl 3
				if(substr($match, 0, 6) == '<lvl3 '){
					preg_match('/\"(.*?)\"/', $match, $result);
					$name = $result[1];
					$type = 'opening_3';
					return array (
						$state,
						array (
							$name,
							$type
						)
					);
				}
				//closing tag for lvl 3
				if(substr($match, 0, 6) == '</lvl3'){
					$type = 'closing_3';
					return array (
						$state,
						array (
							'',
							$type
						)
					);
				}
 
			case DOKU_LEXER_UNMATCHED:
				return array (
					$state,
					$match
				);
			case DOKU_LEXER_EXIT:
				return array (
					$state
				);
		}
		return array ();
	}
 
	/**
	 * Create output
	 */
	function render($mode, & $renderer, $data) {
 
		if ($mode == 'xhtml') {
			list ($state, $match) = $data;
			switch ($state) {
				case DOKU_LEXER_ENTER:
					// output for dropdown opening tag
					list ($name) = $match;
					$renderer->doc .= '<div class="dropdown"><ul>';
					break;
					
				case DOKU_LEXER_MATCHED:
					list ($name, $type) = $match;
					// output for lvl 1 opening tag
					if ($type == 'opening_1') {
						$renderer->doc .= '<ul><li class="link" onclick="showhide(\''. $name . '\');">' . $name . '</li><div id="' . $name . '" class="hidden sublevel">';
						break;
					}
					// output for lvl 2 opening tag
					if ($type == 'opening_2') {
						$renderer->doc .= '<ul><li class="link" onclick="showhide(\''. $name . '\');">' . $name . '</li><div id="' . $name . '" class="hidden sublevel">';
						break;
					}
					// output for lvl 3 opening tag
					if ($type == 'opening_3') {
						$renderer->doc .= '<ul><li class="link" onclick="showhide(\''. $name . '\');">' . $name . '</li><div id="' . $name . '" class="hidden sublevel">';
						break;
					}
					// output for lvl 1 closing tag
					if ($type == 'closing_1') {
						$renderer->doc .= "</div></ul>";
						break;
					}
					// output for lvl 2 closing tag
					if ($type == 'closing_2') {
						$renderer->doc .= "</div></ul>";
						break;
					}
					// output for lvl 3 closing tag
					if ($type == 'closing_3') {
						$renderer->doc .= "</div></ul>";
						break;
					}
 
				case DOKU_LEXER_UNMATCHED:
					$renderer->doc .= $renderer->_xmlEntities($match);
					break;
					
				case DOKU_LEXER_EXIT:
					// output for dropdown closing tag
					$renderer->doc .= "</ul></div>";
					break;
			}
			return true;
		}
		return false;
	}

}
?>
