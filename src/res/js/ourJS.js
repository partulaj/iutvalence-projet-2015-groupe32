
function inputNumberAdd(inputToChange)
{
	var input=document.getElementById(inputToChange);
	var value=parseInt(document.getElementById(inputToChange).value)+1;
	if (value>5) 
	{
		value=5;
	}
	document.getElementById(inputToChange).value=value;
}

function inputNumberSub(inputToChange)
{
	var input=document.getElementById(inputToChange);
	var value=document.getElementById(inputToChange).value.valueOf()-1;
	if (value<0) 
	{
		value=0;
	}
	document.getElementById(inputToChange).value=value;
}

