<tr>
<!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<h5 class="tt"><?php echo $ti1 ?></h5>
<?php
if ($vopros==2)//справка №2
{
?>
<script language="VBScript" src="scripts/scr_help2_a.vbs"></script>
<input name="txtRajon"  type="hidden" value="<?php echo $rajon ?>"><br>
<img style="visibility: hidden" name="load" src="images/loadinfo.gif"><br>
<input name="txtText"  type="hidden" value="<?php echo $inumber ?>"><br>
<input name="dat1"  type="hidden" value="<?php echo $dat1 ?>"><br>
<input name="dat2"  type="hidden" value="<?php echo $dat2 ?>"><br>
<input name="B10" type="button" class="input-button2" value="Печатать"><br>
<?php
}
elseif ($vopros==3)//справка №3
{
?>
<script language="VBScript" src="scripts/scr_help3_a.vbs">
</script>
<input name="txtRajon"  type="hidden" value="<?php echo $rajon ?>"><br>
<input name="dat1" type="hidden" value="<?php echo $dat1 ?>"><br>
<img style="visibility: hidden" name="load" src="images/loadinfo.gif"><br>
<input name="dat2"  type="hidden" value="<?php echo $dat2 ?>"><br>
<input name="txtText" type="hidden" value="<?php echo $inumber ?>"><br>
<input name="B10" type="button" class="input-button2" value="Печатать"><br>
<?php
}
echo "</td></tr>";	