function checkSpaceInSubmit(idName)
{
	var name;
	name = document.getElementById(idName).value;
	
	name= name.replace(/^\s*/, "").replace(/\s*$/, "");
	document.getElementById(idName).value = name;
	if(name == "") 
	{
		alert("Bạn không thể nhập toàn dấu cách!");
		return false;
	}
	else
	{
		
	}
}

function exportExcel(formID)
{
	$('#action').val('Xuất Excel');
	$('#'+formID).submit();
}
function checkSpaceInKeyUp(idName)
{
	var name;
	name = document.getElementById(idName).value;
	
	name= name.replace(/^\s*/, "").replace(/\s*$/, "");
	document.getElementById(idName).value = name;
}
﻿function checkFullname(idName)
{
	var name;
	name = document.getElementById(idName).value;
	
	name= name.replace(/^\s*/, "").replace(/\s*$/, "");
	document.getElementById(idName).value = name;
	if(name == "") 
	{
		alert("Bạn không thể nhập họ và tên toàn dấu cách!");
		return false;
	}
	else
	{
		
	}
}

function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

//﻿function checkUsername(idName,idFullname)
//{
//	var name;
//	var fullname;
//	name = document.getElementById(idName).value;
//	fullname = document.getElementById(idFullname).value;
//	
//	name= name.replace(/^\s*/, "").replace(/\s*$/, "");
//	document.getElementById(idName).value = name;
//	fullname= fullname.replace(/^\s*/, "").replace(/\s*$/, "");
//	document.getElementById(idFullname).value = fullname;
//	if(name == "") 
//	{
//		alert("Bạn không thể nhập tên tài khoảns toàn dấu cách!");
//		return false;
//	};
//	if(fullname == "") 
//	{
//		alert("Bạn không thể nhập họ và tên toàn dấu cách!");
//		return false;
//	}
//	
//}
