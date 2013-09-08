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
jimport('joomla.application.component.controller');

class JlweatherController extends JControllerLegacy
{
	public function display($cachable = false, $urlparams = array())
	{
		parent::display($cachable);
	}

	function ajax() {
		$action = JRequest::getVar('action');
		$model = $this->getModel('ajax');
		header('Content-type: text/html; charset=UTF-8');
		call_user_func(array($model,$action));
		die();
	}

}
?>
