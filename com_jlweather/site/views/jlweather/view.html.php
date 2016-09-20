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

class JlweatherViewJlweather extends JViewLegacy
{
	function display($tpl = null)
	{
		$mainframe = JFactory::getApplication();
		$params = JcomponentHelper::getParams('com_jlweather');
		$citymenu = $mainframe->getMenu()->getActive()->params;

		$tmp_city_list = $citymenu->get('citymenu')!='' ? $citymenu->get('citymenu') : $params->get('citylist');

		$cache = JFactory::getCache('com_jlweather');
		$cache->setCaching(1);
		$cache->setLifeTime($params->get('cachetime')*60);
		
		$model = $this->getModel();
		$city_list = explode(",",$tmp_city_list);
		if (is_array($city_list)) {
			$city_list = array_map('trim',$city_list);
		}

		if (count($city_list)>0) {
			foreach ($city_list as $k =>$v) {
				$city_list[$k] = explode('#',$v);
			}
		}
		$reqcity = JRequest::getInt('cid',0);

		$city = '';
		if($reqcity > 0){
			foreach ($city_list as $k => $v){
				if($v[0] == $reqcity){
					$city = $v[1];
				}
			}
			$selcity = $reqcity;
		}
		else{
			$city = $city_list[0][1];
			$selcity = $city_list[0][0];
		}

		$forecast = $cache->call( array( 'JlweatherModelJlweather', 'getForecastXML') , $selcity  );

		$daysOfWeek = array(
			0 => JText::_('SUNDAY'),
			1 => JText::_('MONDAY'),
			2 => JText::_('TUESDAY'),
			3 => JText::_('WEDNESDAY'),
			4 => JText::_('THURSDAY'),
			5 => JText::_('FRIDAY'),
			6 => JText::_('SATURDAY')
		);

		$this->assignRef( 'selcity',	$selcity );
		$this->assignRef( 'city_list',	$city_list );
		$this->assignRef( 'city',	$city );
		$this->assignRef( 'forecast',	$forecast );
		$this->assignRef( 'daysOfWeek',	$daysOfWeek );

		$gettitle = $params->get('title')!='' ? $params->get('title') : 'Прогноз погоды';
		$app = JFactory::getApplication();
		$currentMenuName = isset($app->getMenu()->getActive()->title) ? $app->getMenu()->getActive()->title : '';
		$title = $currentMenuName.' '.$params->get('title').' для города '.$city;		
		$mainframe = JFactory::getDocument();
		$mainframe->setTitle($title);

		$pathway = $app->getPathway(); 
		$pathway->addItem(JText::_('FORECAST_CITY') .$this->city, '/component/jlweather/');
		parent::display($tpl);
	}
}
?>
