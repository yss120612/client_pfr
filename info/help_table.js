function ResetAll() {
	var cs = document.getElementsByTagName('input');
	for (i=0; i < cs.length; i++) {
		if (cs[i].type == 'checkbox') {
			cs[i].checked = false;
		}
	}
}

function ShowLevel(row,lv) {
	var i = row.rowIndex;
	var tTable = row.parentNode.parentNode;
	var lev=0;
	while(true){
		i+=1;
		row = tTable.rows[i];
		if (!row) {break;}
		lev=GetLevel(row);
		if (lev<=lv) {break;}
		if (lev==lv+1)
		{
		row.style.display = 'table-row';
		if ((row.querySelector('td input')) && row.querySelector('td input').checked) {
				ShowLevel(row,lv+1);
		}
		}
	}
	
}

function HideLevel(row,lv) {
	var i = row.rowIndex;
	var tTable = row.parentNode.parentNode;
	var lev=0;
	while (true) {
		i+=1;
		row = tTable.rows[i];
		if (!row) {break;}
		lev=GetLevel(row);
		if (lev<=lv) {break;}
		row.style.display = 'none';
	}
}

function GetLevel(row)
{
	var l=0;
	var str=row.className;
	var idx=str.indexOf("lev");
	if (idx>=0)
	{
		l=str.substr(idx+3,1)*1;
	}
	return l;
}

function sh(el) {
	var row = el.parentNode.parentNode;
	if (!row) {return;}
	var lv = GetLevel(row);
	if (lv==0) {return;}
	
	if (row.querySelector('td input').checked) {
		ShowLevel(row,lv);
	} else {
		HideLevel(row,lv);
	}
}

function SwapAll(b) {
	var tbl = document.getElementsByClassName('treetable')[0];
	for (i=1; i < tbl.rows.length; i++) {
		if (tbl.rows[i].className.indexOf('lev1') <0) {
			if (b) {tbl.rows[i].style.display = 'table-row';}
			else {tbl.rows[i].style.display = 'none';}
		}

		if (tbl.rows[i].querySelector('td input')) {tbl.rows[i].querySelector('td input').checked = b;}
	}
}
