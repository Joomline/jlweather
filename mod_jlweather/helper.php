<?php
/**
 * Mod JLweather
 *
 * @version 2.3
 * @author Anton Voynov (anton@joomline.ru)
 * @copyright (C) 2011 by Anton Voynov(http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/


// no direct access
defined('_JEXEC') or die;
if (!function_exists("getForecastXML")) {
	function getForecastXML($cid = '692', $params)
	{
		//echo print_r($params,true);
		$hoffset = $params->get('hoffset') * 3600;
		//echo $hoffset;
		$days = array();
		$xml = file_get_contents("http://xml.weather.ua/1.2/forecast/$cid?dayf=5&lang=ru");
		$xml = simplexml_load_string($xml);
		$cityname = (string)$xml->city->name;
		$xml0 = file_get_contents("http://export.yandex.ru/inflect.xml?name=" . urlencode($cityname));
		$xml0 = simplexml_load_string($xml0);
		$cityname = (string)$xml0->inflection[0];

		$weekdays[0] = "Вс";
		$weekdays[1] = "Пн";
		$weekdays[2] = "Вт";
		$weekdays[3] = "Ср";
		$weekdays[4] = "Чт";
		$weekdays[5] = "Пт";
		$weekdays[6] = "Сб";
		$clouds[0] = 'Ясно, без осадков';
		$clouds[1] = 'Переменная облачность';
		$clouds[2] = 'Облачно';
		$clouds[3] = 'Пасмурно';
		$clouds[4] = 'Небольшой дождь';
		$clouds[5] = 'Дождь';
		$clouds[6] = 'Дождь, гроза';
		$clouds[7] = 'Град';
		$clouds[8] = 'Мокрый снег';
		$clouds[9] = 'Снег';
		$clouds[10] = 'Снегопад';

		$current['t'] = (string)$xml->current->t;
		$current['w'] = (string)$xml->current->w;
		$current['p'] = (string)$xml->current->pict;
		$cur_cloud = (string)$xml->current->cloud;
		$cur_cloud = floor($cur_cloud / 10);
		$current['c'] = $clouds[$cur_cloud];

		foreach ($xml->forecast->day as $fpart) {
			$forecast = array();
			$attr = $fpart->attributes();
			$forecast['t']['min'] = (string)$fpart->t->min;
			$forecast['t']['min'] = $forecast['t']['min'] > 0 ? "+" . $forecast['t']['min'] : $forecast['t']['min'];
			$forecast['t']['max'] = (string)$fpart->t->max;
			$forecast['t']['max'] = $forecast['t']['max'] > 0 ? "+" . $forecast['t']['max'] : $forecast['t']['max'];
			$forecast['p']['min'] = (string)$fpart->p->min;
			$forecast['p']['max'] = (string)$fpart->p->max;
			$forecast['w']['min'] = (string)$fpart->wind->min;
			$forecast['w']['max'] = (string)$fpart->wind->max;
			$forecast['w']['rumb'] = (string)$fpart->wind->rumb;
			$forecast['h']['min'] = (string)$fpart->hmid->min;
			$forecast['h']['max'] = (string)$fpart->hmid->max;
			$forecast['pict'] = (string)$fpart->pict;
			$cloud = (string)$fpart->cloud;
			$cloud = floor($cloud / 10);
			$forecast['cloud'] = $clouds[(string)$cloud];
			$forecast['hoffset'] = $hoffset;
			
			$date = (string)$attr['date'];
			$hour = (string)$attr['hour'];
			$date0 = strtotime($date . " " . $hour . ":00");
			$forecast['timestamp'] = $date0;
			$date = strtotime($date);
			$dayofweek = date('w', $date);
			$date = $weekdays[$dayofweek] . " " . date('d.m', $date);
			$forecast['date'] = $date;
			$forecast['hour'] = $hour;
			//if ($forecast['timestamp'] > time() + $hoffset) {
				$days[] = $forecast;
			//}

		}

		return array($cityname, $current, $days, $hoffset);
	}

}

if (!function_exists("jlwgetItemid")) {
	function jlwgetItemid($component)
	{
		if (!function_exists('realGetItemid')) {
			function realGetItemid($component)
			{
				$component = & JComponentHelper::getComponent('com_jlweather');

				//echo '<pre>'.print_r($component,true).'</pre>';

				if (!isset($component->id)) return 0;
				$menus = &JSite::getMenu();
				$items = $menus->getItems('component_id', $component->id);
				$Itemid = (count($items) > 0) ? $items[0]->id : 0;
				unset($items);
				return $Itemid;
			}
		}
		$cache = & JFactory::getCache('mod_jlweather');
		return $cache->call('realGetItemid', $component);
	}
}
jimport ('joomla.html.parameter');
$component = JComponentHelper::getComponent('com_jlweather');
$cparams = new JRegistry($component->params);
$cid = $params->get('city');
$enablednow = $params->get('enablednow');
//$menus = JSite::getMenu();
$menus = JFactory::getApplication()->getMenu();
$items = $menus->getItems('link', 'index.php?option=com_jlweather&view=jlweather');
$Itemid = (count($items) > 0) ? $items[0]->id : 0;
//$Itemid = jlwgetItemid('com_jlweather');

$cache = JFactory::getCache('mod_jlweather');
$cache->setCaching(1);
$cache->setLifeTime($cparams->get('cachetime') * 60);
$dpartname[3] = 'Ночью';
$dpartname[9] = 'Утром';
$dpartname[15] = 'Днем';
$dpartname[21] = 'Вечером';


list($city, $current, $forecast, $hoffset) = $cache->call('getForecastXML', $cid, $cparams);
//echo "<pre>" . print_r($forecast, true) . "</pre>";

