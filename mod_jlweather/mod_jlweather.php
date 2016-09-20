<?php
/**
 * Mod JLweather
 *
 * @version 2.5.0
 * @author Anton Voynov (anton@joomline.ru), Vadim Kunitsyn vadim@joomline.ru, Arkadiy (a.sedelnikov@gmail.com)
 * @copyright (C) 2010-2016 by Joomline (http://www.joomline.ru)
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






