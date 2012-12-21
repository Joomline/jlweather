<?php
 /**
 * @package plugin mail sync. Ya
 * @author Artem Zhukov (artem@joomline.ru)
 * @version 1.3
 * @copyright (C) 2008-2012 by JoomLine (http://www.joomline.net)
 * @license JoomLine: http://joomline.net/licenzija-joomline.html
 *
*/

// no direct access


?>
<table>
	<tr valign="middle">
		<?if ($current['t']) : ?><td nowrap><span style="font-size:16pt"><?=$current['t']?> <sup>o</sup> </span></td><? endif;?>
		<td nowrap><span style="font-size:8pt;margin-left:5px;"><?=$current['c']?></span></td>
		<td rowspan="2"><img src="/components/com_jlweather/img/<?=$current['p']?>" alt="."></td>
		<td rowspan="2">
			<table>
			<?php
				for ($i=1;$i<=3;$i++) {
					echo "<tr><td nowrap>".$dpartname[$forecast[$i]['hour']].": </td><td nowrap align='right'>". $forecast[$i]['t']['min'] ."</td><td nowrap>...</td><td nowrap>". $forecast[$i]['t']['max']."</td></tr>\n";
				}
			?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<a style="font-size:8pt" href="<?=JRoute::_('index.php?option=com_jlweather&Itemid='.$Itemid.'&cid='. $city)?>">Прогноз для <?=$city?></a>
		</td>
	</tr>
		<div style="text-align: right;">
			<a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; " target="_blank" href="http://joomline.ru/rasshirenija/komponenty/jlweather.html">Погода для joomla</a>
		</div>
</table>
<?php
