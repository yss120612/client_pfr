<!DOCTYPE html>
<html>

    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <!-- 1. ���������� ���������� jQuery -->
      <script type="text/javascript" src="/js/jquery-3.1.1.min.js"></script>
      <!-- 2. ���������� ������ moment-with-locales.min.js ��� ������ � ������ -->
      <script type="text/javascript" src="/js/bootstrap.min.js"></script>
      <!-- 4. ���������� ������ ������� "Bootstrap datetimepicker" -->
      <link rel="stylesheet" href="/css/bootstrap.min.css" />
      <!-- 6. ���������� CSS ������� "Bootstrap datetimepicker" -->  
      <link rel="stylesheet" type="text/css" href="/css/jquery.datetimepicker.min.css"/ >
      <script src="/js/jquery.datetimepicker.full.min.js" charset="utf-8"></script>

    </head>
<body>
<h1>������<h1/>
    <div class="content form-group row">
      <div class="input-group col-md-5">
        <input type="text" class="form-control" id="datetimepicker2" />
        <span class="input-group-addon">
          <span class="glyphicon glyphicon-calendar cursor-pointer" id="datetimepicker2icon"></span>
        </span>
      </div>
	  
    </div>
	
     <input type="button" value="CLICK" class="btn btn-default" onclick="clc()"></input>
<script type="text/javascript">

	$.datetimepicker.setLocale('ru');

	$('#datetimepicker2').datetimepicker({
	step:15,
	timespan: '8.00-17.00',
	dayOfWeekStart:1,
	disabledWeekDays:[0,6],
});



$('#datetimepicker2icon').click(function(){
	$('#datetimepicker2').datetimepicker('toggle');
});

function clc()
{
	var dp=$('#datetimepicker2');
	dp.datetimepicker({allowTimes:['09:00','11:00','12:00','21:00']});
	alert($('#datetimepicker2').datetimepicker('getValue'));
}

</script>
</body>
</html>
