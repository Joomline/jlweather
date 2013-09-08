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
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

class JlweatherModelJlweather extends JModelLegacy
{
	function getForecastXML($cid='692')
	{
		$params = JcomponentHelper::getParams('com_jlweather');
		$hoffset = $params->get('hoffset')*3600;
		
		$days = array();
		$xml = file_get_contents("http://xml.weather.ua/1.2/forecast/$cid?dayf=5&lang=ru");
	    $xml = simplexml_load_string($xml);
	    $cityname = (string)$xml->city->name;

	    $weekdays[0] = JText::_("SUNDAY");
	    $weekdays[1] = JText::_("MONDAY");
	    $weekdays[2] = JText::_("TUESDAY");
	    $weekdays[3] = JText::_("WEDNESDAY");
	    $weekdays[4] = JText::_("THURSDAY");
	    $weekdays[5] = JText::_("FRIDAY");
	    $weekdays[6] = JText::_("SATURDAY");

		if (count($xml->forecast->day)>0){
	    foreach ($xml->forecast->day as $fpart) {
		    $forecast = array();
		    $attr = $fpart->attributes();
		    $forecast['t']['min'] = (string)$fpart->t->min;
		    $forecast['t']['min'] = $forecast['t']['min'] > 0 ? "+".$forecast['t']['min'] : $forecast['t']['min'];
		    $forecast['t']['max'] = (string)$fpart->t->max;
		    $forecast['t']['max'] = $forecast['t']['max'] > 0 ? "+".$forecast['t']['max'] : $forecast['t']['max'];
		    $forecast['p']['min'] = (string)$fpart->p->min;
		    $forecast['p']['max'] = (string)$fpart->p->max;
		    $forecast['w']['min'] = (string)$fpart->wind->min;
		    $forecast['w']['max'] = (string)$fpart->wind->max;
		    $forecast['w']['rumb'] = (string)$fpart->wind->rumb;
		    $forecast['h']['min'] = (string)$fpart->hmid->min;
		    $forecast['h']['max'] = (string)$fpart->hmid->max;
		    $forecast['pict'] = (string)$fpart->pict;
		    $date = (string)$attr['date'];
		    $hour = (string)$attr['hour'];
		    $date0 = strtotime($date." ".$hour.":00");
		    $forecast['timestamp'] = $date0;
		    $date = strtotime($date);
		    $dayofweek = date('w',$date);
		    $date = $weekdays[$dayofweek]." ".date('d.m',$date);
		    if ($forecast['timestamp'] > time()+$hoffset){
			    $days[$date][$hour] = $forecast;
		    }

	    }
		} else {$days=array();}

		return array($cityname,$days);
	}
}
