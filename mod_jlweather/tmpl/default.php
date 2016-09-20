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

$current = $data['current'];
$fiveDays = $data['fiveDays'];
$enablednow = count($current) > 0;
$enabledFiveDays = count($fiveDays) > 0;
?>
<table>
	<?php if ($enablednow) { ?>
	<tr valign="middle">
		<td><img src="<?php echo $current['icon']?>" alt="."></td>
		<td nowrap><span style="font-size:16pt"><?php echo round($current['temp'],0); ?> <sup>o</sup>C </span></td>
		<td nowrap><span style="font-size:8pt;margin-left:5px;"><?php echo $current['description']?></span></td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Давление: <?php echo $current['pressure']?> мм рт. ст.</span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Влажность: <?php echo $current['humidity']?> %</span>
		</td>
		</tr>

		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Минимальная температура: <?php echo round($current['temp_min'],0)?> &deg;C</span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Максимальначя температура: <?php echo round($current['temp_max'],0)?> &deg;C</span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Видимость: <?php echo $current['visibility']?> м</span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Скорость ветра: <?php echo $current['wind_speed']?> м/с</span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Направление ветра: <?php echo $current['wind_deg_text']?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Восход: <?php echo $current['sunrise']?></span>
		</td>
		</tr>
		<tr>
		<td nowrap colspan="3">
			<span style="font-size:8pt;margin-left:5px;"> Закат: <?php echo $current['sunset']?></span>
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
			<tr style="font-size:8pt;margin-left:5px;">
				<td colspan="2">
					<?php echo $daypart['time']; ?>
				</td>
				<td>
					<img src="<?php echo $daypart['icon']; ?>" alt=".">
				</td>
			<tr style="font-size:8pt;margin-left:5px;">
			<tr>
				<td colspan="3">
					<div><?php echo JString::ucfirst($daypart['description']); ?></div>
					<div>Температура: <?php echo round($daypart['temp_min'],0); ?> ... <?php echo round($daypart['temp_max'],0); ?>&deg;C</div>
					<div>Ветер <?php echo $daypart['wind_deg_text']; ?>, <?php echo $daypart['wind_speed']; ?> м/с</div>
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
			<a style="font-size:8pt" href="<?php echo JRoute::_('index.php?option=com_jlweather&Itemid='.$Itemid.'&cid='. $city)?>">Прогноз для <?php echo $params->get('city_name', ''); ?></a>
		</td>
	</tr>
		<div style="text-align: right;">
			<a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; " target="_blank" href="http://joomline.ru/rasshirenija/komponenty/jlweather.html">Погода для joomla</a>
		</div>
</table>
<?php
