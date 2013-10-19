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


?>
<table>
	<?php if ($enablednow==0) { ?>
	<tr valign="middle">
		<?if ($current['t']) : ?><td nowrap><span style="font-size:16pt"><?php echo $current['t']?> <sup>o</sup> </span></td><? endif;?>
		<td nowrap><span style="font-size:8pt;margin-left:5px;"><?php echo $current['c']?></span></td>
		<td rowspan="2"><img src="/components/com_jlweather/img/<?php echo $current['p']?>" alt="."></td>
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
	<?php } else { ?>
	<tr valign="middle">
		<?php 
		$t_t = date("H",time()+$hoffset);
		$tt = $t_t{0}==0 ? str_replace("0","",date("H",time()+$hoffset)) : date("H",time()+$hoffset);
		$dt = date("d",time()+$hoffset);		
		foreach ($forecast as $daypart) {			
			if (date("d",$daypart['timestamp']) == $dt) {
			//echo '<pre>'.print_r($daypart,true).'</pre>';
				if (( $daypart['hour'] >= 3) && ($tt >= $daypart['hour']) && ($tt < 9) ) {
					echo '<img src="/components/com_jlweather/img/'.$daypart['pict'].'" alt=".">'.' <b>'.$daypart['t']['min'].'...'.$daypart['t']['max'].'&deg;C</b> '.$daypart['cloud'];
				} elseif (( $daypart['hour'] >= 9) && ($tt >= $daypart['hour']) && ($tt < 15) ) {
					echo '<img src="/components/com_jlweather/img/'.$daypart['pict'].'" alt=".">'.' <b>'.$daypart['t']['min'].'...'.$daypart['t']['max'].'&deg;C</b> '.$daypart['cloud'];
				} elseif (( $daypart['hour'] >= 15) && ($tt >= $daypart['hour']) && ($tt < 21) ) {
					echo '<img src="/components/com_jlweather/img/'.$daypart['pict'].'" alt=".">'.' <b>'.$daypart['t']['min'].'...'.$daypart['t']['max'].'&deg;C</b> '.$daypart['cloud'];
				} elseif (( $daypart['hour'] >= 21) && ($tt >= $daypart['hour']) && ($tt < 24)) {
					echo '<img src="/components/com_jlweather/img/'.$daypart['pict'].'" alt=".">'.' <b>'.$daypart['t']['min'].'...'.$daypart['t']['max'].'&deg;C</b> '.$daypart['cloud'];
				} elseif (($tt >= 0) && ($tt < 3)) {				
					echo '<img src="/components/com_jlweather/img/'.$daypart['pict'].'" alt=".">'.' <b>'.$daypart['t']['min'].'...'.$daypart['t']['max'].'&deg;C</b> '.$daypart['cloud'];
				}
			}
		}
		
		//echo '<pre>GfG'.print_r($forecast[0],true).'</pre>'; 
		
		
		?>
	</tr>	
	<?php } ?>
	<tr>
		<td colspan="2">
			<a style="font-size:8pt" href="<?php echo JRoute::_('index.php?option=com_jlweather&Itemid='.$Itemid.'&cid='. $city)?>">Прогноз для <?php echo $city?></a>
		</td>
	</tr>
		<div style="text-align: right;">
			<a style="text-decoration:none; color: #c0c0c0; font-family: arial,helvetica,sans-serif; font-size: 5pt; " target="_blank" href="http://joomline.ru/rasshirenija/komponenty/jlweather.html">Погода для joomla</a>
		</div>
</table>
<?php
