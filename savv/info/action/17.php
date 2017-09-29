<tr><!--<td class="mnmenus">&nbsp;</td>-->
<td class="mndata">
<h5 class="tt"><?php echo $ti1 ?></h5>


	<FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=18&vopros=1" method="post">
              <input class="inp_main_zakon" type="submit" value="Нормативные акты по пенсионному обеспечению" onMouseOver="window.status=''; return null;">
        </FORM> 

	<FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=18&vopros=2" method="post">
             <input class="inp_main_zakon" type="submit" value="Трудовая пенсия по старости" onMouseOver="window.status=''; return null;">
        </FORM>
        
	<FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=18&vopros=3" method="post">
             <input class="inp_main_zakon" type="submit" value="Трудовая пенсия по инвалидности" onMouseOver="window.status=''; return null;">
        </FORM>
        

        <FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=18&vopros=4" method="post">
             <input class="inp_main_zakon" type="submit" value="Трудовая пенсия по случаю потери кормильца" onMouseOver="window.status=''; return null;">
        </FORM>
	
         <FORM class="frm_main_button" action="<?php echo $PHP_SELF ?>?action=18&vopros=5" method="post">
             <input class="inp_main_zakon" type="submit" value="Социальная пенсия" onMouseOver="window.status=''; return null;">
        </FORM>
	
<?php
//какое то действие
echo "</td></tr>";