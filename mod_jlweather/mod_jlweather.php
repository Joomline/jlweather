<?php
/**
 * Mod JLweather
 *
 * @version 2.3
 * @author Anton Voynov (anton@joomline.ru)
 * @copyright (C) 2011 by Anton Voynov(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/
// No direct access
defined('_JEXEC') or die('Restricted access');

require_once( dirname(__FILE__).'/helper.php' );

$menus = JFactory::getApplication()->getMenu();
$items = $menus->getItems('link', 'index.php?option=com_jlweather&view=jlweather');
$Itemid = (count($items) > 0) ? $items[0]->id : 0;
//echo '<pre>'; var_dump($module);echo '</pre>'; die;
$data = modJLWeatherHelper::getForecastXML($params, $module->id);
$city = $params->get('city', 0);
require JModuleHelper::getLayoutPath('mod_jlweather', $params->get('layout', 'default'));






