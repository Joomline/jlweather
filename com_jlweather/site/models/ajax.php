<?php
 /**
 * JLweather - components of the weather for joomla.
 *
 * @version 1.0
 * @package JLweather
 * @author Anton Voynov (anton@joomline.ru)
 * @copyright (C) 2010 by Anton Voynov(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 *
 * If you fork this to create your own project,
 * please make a reference to JoomLine someplace in your code
 * and provide a link to http://www.joomline.ru
 **/ 
// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class JlweatherModelAjax extends JModel {
	function __construct() {
		parent::__construct();
	}
	function get_forecast() {
		$city = JRequest::getInt('city');
	}
	private function returnError($text) {
		echo "<span style='font-weight:bold; color: red'>".$text."</span>";
		die();
	}

}
