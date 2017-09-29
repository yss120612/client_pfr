<?php
if ($ident==2)
{
?>
<script type="text/javascript">
function deleteChar(input,gbt) 
{
if (input.value.length==5 ||input.value.length==9 || input.value.length==12)
input.value = input.value.substring(0, input.value.length - 2)
else 
input.value = input.value.substring(0, input.value.length - 1);
gbt.style.display='none';
};

function addChar(input,gbt,character, max)
    {
    if (input.value.length<max)
    {
    <!--exit-->
    <!--}-->
    if (input.value.length==3 ||input.value.length==7) input.value+="-"+character
    else if (input.value.length==11) input.value+=" "+character
    else input.value+=character;

    if (input.value.length>=max) gbt.style.display=''
    }
};
<?php
$mx=14;
//}
?>
function checkform(str,idn)
{
var tmpst=str.value;
var loc;
tmpst=tmpst.replace(/-/g,"");
tmpst=tmpst.replace(/ /g,"");
<?php
if ($vopros==0)
{
$lc=$PHP_SELF ."?action=4&today=". $today ."&ident=". $ident ."&inumber=";
}
elseif ($vopros>0)
{
$lc=$PHP_SELF ."?action=4&vopros=". $vopros ."&ident=". $ident ."&inumber=";
}
?>
loc="<?php echo $lc ?>"+tmpst;
window.location.replace(loc)
};

function clr(input,gbt)
{
input.value='';
gbt.style.display='none';
};
-->
</script>
<tr>
<!--<td class="mnmenus">&nbsp;
</td>--><td class="mndata">     
<h5 class="tt"><?php echo $ti1 ?></h5>
<form>
<table id="number">
<tr>
<td valign="top">

<input name="display" class="input-disp" value="" onFocus="document.forms[0].display.blur();"><br>
    <img id="snils" src="images/strax.gif"><br><br>
<input style="display:none" name="GO" type="button" class="input-button5" value="Готово" onClick = "checkform(document.forms[0].display,<?php echo($mx)?>); document.forms[0].GO.value='Ждите'">

</td>
<td>
<input type="button" class="input-button" value="7" onClick="addChar(document.forms[0].display,document.forms[0].GO, '7',<?php echo($mx)?>)">
<input type="button" class="input-button" value="8" onClick="addChar(document.forms[0].display,document.forms[0].GO, '8',<?php echo($mx)?>)">
<input type="button" class="input-button" value="9" onClick="addChar(document.forms[0].display,document.forms[0].GO, '9',<?php echo($mx)?>)"><br>
<input type="button" class="input-button" value="4" onClick="addChar(document.forms[0].display,document.forms[0].GO, '4',<?php echo($mx)?>)">
<input type="button" class="input-button" value="5" onClick="addChar(document.forms[0].display,document.forms[0].GO, '5',<?php echo($mx)?>)">
<input type="button" class="input-button" value="6" onClick="addChar(document.forms[0].display,document.forms[0].GO, '6',<?php echo($mx)?>)"><br>
<input type="button" class="input-button" value="1" onClick="addChar(document.forms[0].display,document.forms[0].GO, '1',<?php echo($mx)?>)">
<input type="button" class="input-button" value="2" onClick="addChar(document.forms[0].display,document.forms[0].GO, '2',<?php echo($mx)?>)">
<input type="button" class="input-button" value="3" onClick="addChar(document.forms[0].display,document.forms[0].GO, '3',<?php echo($mx)?>)"><br>
<input type="button" class="input-button" value="<" onClick="deleteChar(document.forms[0].display,document.forms[0].GO)">
<input type="button" class="input-button" value="0" onClick="addChar(document.forms[0].display,document.forms[0].GO, '0',<?php echo($mx)?>)">
<input type="button" class="input-button" value="C" onClick="clr(document.forms[0].display,document.forms[0].GO)"><br>
</td>
</tr>
</table>
</form>
</td>
</tr>

<?php
}
else{
    ?>
<script type="text/javascript">
function addChar1(character){
    //alert('dsd');
    max=30;
    input=document.forms[0].display;
    gbt=document.forms[0].GO;
    ln=input.value.length;
    if (ln<max){
   //input.value= input.value.substring(0, 0 - 1);
   input.value+=character;
   //alert(tstInp(input.value));
    
    if(tstInp(input.value)){gbt.style.display='block';}
    else{gbt.style.display='none';}
    }
   /* 
    if (ln<max)
    {    
//   if (input.value.length==3 ||input.value.length==7){ input.value+="-"+character}
//    else if (input.value.length==11){ input.value+=" "+character}
//    else {input.value+=character};
        
        input.value+=character;
        if(ln>=4){
            gbt.style.display='block';
        }
        else{gbt.style.display='none';}
        
    //if (input.value.length>=max) {gbt.style.display=''};
    };*/
};

function deleteChar1() 
{
    input=document.forms[0].display;
    gbt=document.forms[0].GO;
    ln=input.value.length;
    
    input.value = input.value.substring(0, ln - 1);
    if(tstInp(input.value)){gbt.style.display='block';}
    else{gbt.style.display='none';}
    
    
//    if(ln<5){gbt.style.display='none';}
//    else{gbt.style.display='block';}
    //gbt.style.display='none';
    
//    if (input.value.length==5 ||input.value.length==9 || input.value.length==12)
//    {input.value = input.value.substring(0, input.value.length - 2)}
//    else {
//    input.value = input.value.substring(0, input.value.length - 1);
//    gbt.style.display='none';
//    }
};

function tstInp(inp){
    var pattern = new RegExp(/[А-Я]+\s+[А-Я]+\s+[А-Я]+/);
    return pattern.test(inp);
};

function chkFrm(){
    input=document.forms[0].display;
    
    input.value=input.value.replace(/([А-Я]+)\s+([А-Я]+)\s+([А-Я]+).*/,"$1 $2 $3");
    
//        var tmpst=str.value;
        var loc;
//    tmpst=tmpst.replace(/-/g,"");
//    tmpst=tmpst.replace(/ /g,"");
    <?php
    if ($vopros==0)
    {
    $lc=$PHP_SELF ."?action=23&today=". $today ."&ident=". $ident ."&fio=";
    }
    elseif ($vopros>0)
    {
    $lc=$PHP_SELF ."?action=23&vopros=". $vopros ."&ident=". $ident ."&fio=";
    }
    ?>
    loc="<?php echo $lc ?>"+input.value;
    window.location.replace(loc);
};

//            function addChar(input,gbt,character, max)
//    {
//    if (input.value.length<max)
//    {    
//    if (input.value.length==3 ||input.value.length==7) input.value+="-"+character
//    else if (input.value.length==11) input.value+=" "+character
//    else input.value+=character;
//
//    if (input.value.length>=max) {gbt.style.display=''};
//    }};
</script>
<?php
   echo '<tr>
<td class="mndata">
<h5 class="tt">'.$ti1.'</h5>';
   //$mx=25;
?>
<FORM>
    <input type="text" name="display" class="input-disp4" style="color:red;" value="" onFocus="document.forms[0].display.blur();"><br>
    <input type="button" class="input-button7" value="Й" onClick="addChar1('Й')">
    <input type="button" class="input-button7" value="Ц" onClick="addChar1('Ц')">
    <input type="button" class="input-button7" value="У" onClick="addChar1('У')">
    <input type="button" class="input-button7" value="К" onClick="addChar1('К')">
    <input type="button" class="input-button7" value="Е" onClick="addChar1('Е')">
    <input type="button" class="input-button7" value="Н" onClick="addChar1('Н')">
    <input type="button" class="input-button7" value="Г" onClick="addChar1('Г')">
    <input type="button" class="input-button7" value="Ш" onClick="addChar1('Ш')">
    <input type="button" class="input-button7" value="Щ" onClick="addChar1('Щ')">
    <input type="button" class="input-button7" value="З" onClick="addChar1('З')">
    <input type="button" class="input-button7" value="Х" onClick="addChar1('Х')">
    <input type="button" class="input-button7" value="Ъ" onClick="addChar1('Ъ')">
    <br>
    <input type="button" class="input-button7" value="Ф" onClick="addChar1('Ф')">
    <input type="button" class="input-button7" value="Ы" onClick="addChar1('Ы')">
    <input type="button" class="input-button7" value="В" onClick="addChar1('В')">
    <input type="button" class="input-button7" value="А" onClick="addChar1('А')">
    <input type="button" class="input-button7" value="П" onClick="addChar1('П')">
    <input type="button" class="input-button7" value="Р" onClick="addChar1('Р')">
    <input type="button" class="input-button7" value="О" onClick="addChar1('О')">
    <input type="button" class="input-button7" value="Л" onClick="addChar1('Л')">
    <input type="button" class="input-button7" value="Д" onClick="addChar1('Д')">
    <input type="button" class="input-button7" value="Ж" onClick="addChar1('Ж')">
    <input type="button" class="input-button7" value="Э" onClick="addChar1('Э')">
    <input type="button" class="input-button7" value="Ё" onClick="addChar1('Ё')">
    <br>
    <input type="button" class="input-button7" value="-" onClick="addChar1('-')">    
    <input type="button" class="input-button7" value="Я" onClick="addChar1('Я')">
    <input type="button" class="input-button7" value="Ч" onClick="addChar1('Ч')">
    <input type="button" class="input-button7" value="С" onClick="addChar1('С')">
    <input type="button" class="input-button7" value="М" onClick="addChar1('М')">
    <input type="button" class="input-button7" value="И" onClick="addChar1('И')">
    <input type="button" class="input-button7" value="Т" onClick="addChar1('Т')">
    <input type="button" class="input-button7" value="Ь" onClick="addChar1('Ь')">
    <input type="button" class="input-button7" value="Б" onClick="addChar1('Б')">
    <input type="button" class="input-button7" value="Ю" onClick="addChar1('Ю')">
    <!--<input type="button" class="input-button7" value="." onClick="addChar1('.')">-->
    <input type="button" class="input-button7" value="<" onClick="deleteChar1()">
    
    <br>
    <input type="button" class="input-button8" value=" " onclick="addChar1(' ')" style="margin-top:3px;"><br><br>   
    <input name="GO" type="button" class="input-button5" value="Готово" style="display:none; margin:0 auto; margin-top:3px;" onclick="chkFrm(); document.forms[0].GO.value='Ждите'">
    
</FORM>
<?php
    echo '</td></tr>';
}