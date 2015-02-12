/**
 * Déclaration des variable globales
 */
var deplier=0;

/**
 * Fonction qui se lance au démarrage
 */
$(document).ready(function () 
{
	$('#formDiv').hide("fast");
});

/**
 * Fonction qui incrémente la valeur d'un input
 * @param inputToChange : id de l'input à incrémenter
 */
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

/**
 * Fonction qui décrémente la valeur d'un input
 * @param inputToChange : id de l'input à décrémenter
 */
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

/**
 * Fonction qui affiche 
 */ 
function DisplayFormVisible()
{
	if(deplier==0) 
	{
		$("#formDiv").slideDown("slow");
		deplier=1;
	}
	else
	{
		$("#formDiv").slideUp("slow");
		deplier=0;
	}
}