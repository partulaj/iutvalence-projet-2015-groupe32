window.onload = function()
{
	$('#formDiv').hide("fast");
}
//fonction pour incrémenter le champ 'number'
function inputNumberAdd(inputToChange)
{
	var input=document.getElementById(inputToChange);
	var value=parseInt(document.getElementById(inputToChange).value)+1;
	if (value>3) 
	{
		value=3;
	}
	document.getElementById(inputToChange).value=value;
}

//fonction pour décrémenter le champ 'number'
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

//fonction qui permet d'afficher le formulaire caché
var deplier=0; // 0 le menu n'est pas déplier, 1 le menu est déplier 
function DisplayFormVisible()
{
	if(deplier==0) 
	{
		$("#formDiv").show("slow");
		deplier=1;
	}
	else
	{
		$("#formDiv").hide("slow");
		deplier=0;
	}
}