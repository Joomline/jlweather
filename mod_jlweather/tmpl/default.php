<?php
/**
 * Mod JLweather
 *
 * @version 2.5.0
 * @author Anton Voynov (anton@joomline.ru), Vadim Kunitsyn vadim@joomline.ru, Arkadiy (a.sedelnikov@gmail.com)
 * @copyright (C) 2010-2016 by Joomline (http://www.joomline.ru)
 * @license GNU/GPL: http://www.gnu.org/copyleft/gpl.html
 **/

// no direct access

$current = $data['current'];
$fiveDays = $data['fiveDays'];
$enablednow = count($current) > 0;
$enabledFiveDays = count($fiveDays) > 0;
?>
<style type="text/css">
   .jlweather-mod-temp {font-size:16pt}
   .jlweather-mod-other {font-size:8pt;margin-left:5px;}
</style>
<table>
	<?php if ($enablednow) { ?>
	<tr valign="middle">
		<td><img src="<?php echo $current['icon']?>" alt="."></td>
		<td nowrap><span class="jlweather-mod-temp"><?php echo round($current['temp'],0); ?> <sup>o</sup>C </span></td>
		<td nowrap><span class="jlweather-mod-other"><?php echo $current['description']?></span></td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_PRESSURE'); ?> <?php echo $current['pressure']?> <?php echo JText::_('JL_WEATHER_MM'); ?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_HIMIDITY'); ?> <?php echo $current['humidity']?> <?php echo JText::_('JL_WEATHER_PROCENT'); ?></span>
		</td>
		</tr>

		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_MIN'); ?> <?php echo round($current['temp_min'],0)?> <?php echo JText::_('JL_WEATHER_TEMP_C'); ?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_MAX'); ?> <?php echo round($current['temp_max'],0)?> <?php echo JText::_('JL_WEATHER_TEMP_C'); ?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_VISIBILITY'); ?> <?php echo $current['visibility']?> <?php echo JText::_('JL_WEATHER_TEMP_M'); ?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_WIND_SPEED'); ?> <?php echo $current['wind_speed']?> <?php echo JText::_('JL_WEATHER_TEMP_MS'); ?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_WIND_DEG'); ?> <?php echo $current['wind_deg_text']?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_SUNRISE'); ?> <?php echo $current['sunrise']?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span class="jlweather-mod-other"> <?php echo JText::_('JL_WEATHER_TEMP_SUNSET'); ?> <?php echo $current['sunset']?></span>
		</td>
		</tr>

	<?php } if($enabledFiveDays) { ?>

		<?php foreach ($fiveDays as $k => $v) { ?>
			<tr>
			<td colspan="3">
				<h4><?php echo $k; ?></h4>
			</td>
			</tr>
			<?php
			foreach ($v as $key => $daypart) {
				?>
			<tr class="jlweather-mod-other">
				<td colspan="2">
					<?php echo $daypart['time']; ?>
				</td>
				<td>
					<img src="<?php echo $daypart['icon']; ?>" alt=".">
				</td>
			<tr class="jlweather-mod-other">
			<tr>
				<td colspan="3">
					<div><?php echo JString::ucfirst($daypart['description']); ?></div>
					<div><?php echo JText::_('JL_WEATHER_TEMP'); ?> <?php echo round($daypart['temp_min'],0); ?> ... <?php echo round($daypart['temp_max'],0); ?><?php echo JText::_('JL_WEATHER_TEMP_C'); ?></div>
					<div><?php echo JText::_('JL_WEATHER_WIND'); ?> <?php echo $daypart['wind_deg_text']; ?>, <?php echo $daypart['wind_speed']; ?> <?php echo JText::_('JL_WEATHER_TEMP_MS'); ?></div>
				</td>
			</tr>
			<?php
			}
		}
		
		//echo '<pre>GfG'.print_r($forecast[0],true).'</pre>'; 
		
		
		?>

	<?php } ?>
	<tr>
		<td colspan="2">
			<a style="font-size:8pt" href="<?php echo JRoute::_('index.php?option=com_jlweather&Itemid='.$Itemid.'&cid='. $city)?>"><?php echo JText::_('JL_WEATHER_FOR_CITY'); ?> <?php echo $params->get('city_name', ''); ?></a>
		</td>
	</tr>
		<div style="text-align: right;">
			<a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; " target="_blank" href="http://joomline.ru/rasshirenija/komponenty/jlweather.html">JL Weather</a>
		</div>
</table>
<?php
