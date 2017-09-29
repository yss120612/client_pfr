<?php
setlocale(LC_ALL, 'ru_RU.CP1251');

//класс кабинка
class K 
{
var $PhN;//физ. номер
var $priem;//прием
var $rec_priem;//по записи
var $spec_name;//фио специалиста
//var $vid_name;//фио специалиста в таблице
var $t_nach;//время начала приема;
var $t_fin;//время конца приема;
//var $t_osv;//расчетное время освобождения кабинки;

function K($A1,$A3,$A4,$A5,$A6)
 {
  $this->PhN=$A1;
  $this->priem=$A3;
  $this->rec_priem=$A4;
  $this->spec_name=$A5;
  $this->t_nach=$A6;
//  $this->vid_name=$A7;
//  $this->t_osv=$A8;
 }

}//end class K

//класс посетитель
class P
{
var $NID;//1 физ. посетителя номер
var $NK;//2 физ. номер кабинки
var $type_obr;//3 вид обращения
var $type_obr_st;//3 вид обращения
var $fio1;//4 фамилия
var $fio2;//5 имя
var $fio3;//6 отчество
var $order;//7 очередь
var $otr;//отработано
var $predvar;//8 предв. запись
var $predvar_id;//8 предв. запись N
var $lchet;//9 lchet
var $pens_n;//10 ПЕНС НОМЕР
var $t_prihod;//11 время визита
var $d_prihod;//12 дата визита
var $t_priem_s;//13 время начала приема
var $t_priem_f;//14 время конца приема
var $clr;//14
var $t_calc_priem;//расчетное время приема
var $t_dt;
var $zakaz;


function P($A0,$A1,$A2,$A3,$A4,$A5,$A6,$A7,$A8,$A9,$A10,$A11,$A12,$A14,$A15)
 {
  $this->fio1=$A0;
  $this->NK=$A1;
  $this->otr=$A2;
  $this->NID=$A3;
  $this->type_obr=$A4;
  $this->clr=$A4;
  $this->fio2=$A5;
  $this->fio3=$A6;
  $this->lchet=$A7;
  $this->pens_n=$A8;
  $this->order=$A9;
  $this->d_prihod=$A10;
  $this->t_prihod=$A11;
  $this->predvar=$A12;
  $this->t_priem_s= $A14;
  $this->t_priem_f= $A15;
  $this->t_dt=0;
  $this->zakaz=0;
  $this->type_obr_st="";
 }
 function SetDT()
 {
  $this->t_dt=round((strtotime($this->t_prihod)-strtotime($this->t_calc_priem))/60);
  if ($this->t_dt<0 && $this->predvar=='1')
  {
   $this->clr="Red";
   $this->t_dt=-$this->t_dt;
  }
 }
 
 function GetFam()//Возвр. фамилия и.о.
 {
  $tmp=strtoupper(substr($this->fio1,0,1)).strtolower(substr($this->fio1,1));
  
  if ($this->fio1<>"" && $this->fio2<>""  && $this->fio3<>"")
  {
   $tmp .= " ". strtoupper(substr($this->fio2,0,1)) .".". strtoupper(substr($this->fio3,0,1)) .".";
  }
  else
  {
; // $tmp=$this->fio1<>"";
  }
  return $tmp;
  
 }
//function get_time_osv()//расчетное время освобождения кабинки
// {
 // return date( "H:i:s" ,$this->t_nach+$this->t_for_osv*60);
 //}
}//end class 


//порядковый номер в массиве кабинки номер NoX
function GetKab($NoX,$KX)
{
for ($ix=0;$ix<count($KX);$ix++)
if ($KX[$ix]->PhN==$NoX) return $ix;
return -1;
}

//объект посетитель номер очереди OX в кабинку NoX
function GetPos($NoX,$OX,$KX)
{
for ($ix=0;$ix<count($KX);$ix++)
if (($KX[$ix]->NK==$NoX) && ($KX[$ix]->order==$OX)) return $KX[$ix];
return NULL;
}


//объект посетитель по идентификатору ID
function GetPosID($NIDX,$KX)
{
for ($ix=0;$ix<count($KX);$ix++)
if ($KX[$ix]->NID==$NIDX) return $KX[$ix];
return NULL;
}
?>