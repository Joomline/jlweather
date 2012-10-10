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
jimport( 'joomla.application.component.view');

class JlweatherViewJlweather extends JView
{
	function display($tpl = null)
	{
		$params = JcomponentHelper::getParams('com_jlweather');
		$cache = & JFactory::getCache('com_jlweather');
		$cache->setCaching(1);
		$cache->setLifeTime($params->get('cachetime')*3600);
		$mainframe = JFactory::getDocument();
		$mainframe->setTitle($params->get('title'));

		$model = &$this->getModel();
		$city_list = explode(",",$params->get('citylist'));
		if (is_array($city_list)) {
			$city_list = array_map('trim',$city_list);
		} else {
			$city_list[0] = trim($city_list);
		}

		if (count($city_list)>0) {
			foreach ($city_list as $k =>$v) {
				$city_list[$k] = explode('#',$v);
			}
		}
		$reqcity = JRequest::getInt('cid',0);
		$selcity = $reqcity >0 ? $reqcity : $city_list[0][0] ;
		list($city,$forecast) = $cache->call( array( 'JlweatherModelJlweather', 'getForecastXML') , $selcity  );
//		list($city,$forecast) = $model->getForecastXML($selcity);
		$this->assignRef( 'selcity',	$selcity );
		$this->assignRef( 'city_list',	$city_list );
		$this->assignRef( 'city',	$city );
		$this->assignRef( 'forecast',	$forecast );
		parent::display($tpl);
	}
}
?>
