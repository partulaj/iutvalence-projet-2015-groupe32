/**
 * Fichier contanant les fonction de manipulation des voeux
 */

/**
 * Ajout d'un voeu par requête Ajax
 */
 function ajoutVoeu(num)
 {
 	var p = $("#priorite"+num).val();
 	$.post('./ajax/createVoeu.php', {no_projet: num, priorite:p}, function(data) 
 	{
 		if (data!=true) 
 		{
 			toast(data,4000);
 		}
 		else
 		{
 			toast('Le projet a était ajouté à vos Voeux',4000);
 			document.location.reload(true);
 		}
 	},'json');
 }
/**
 * Modification d'un Voeu par requête Ajax
 */
 function editVoeu(num, login)
 {
 	var priorite = $("#priorite"+num).val();
 	$.post('./ajax/updateVoeu.php', {priorite: priorite,no_projet: num, login:login}, function(data) 
 	{
 		if (data!=true) 
 		{
 			toast(data,4000);
 		}
 		else
 		{
 			toast('Votre voeu à bien était modifié',4000);
 			document.location.reload(true);
 		}
 	},'json');
 }

 /**
  * Suppression d'un voeu par requête Ajax
  */
  function delVoeu(num, login)
  {
  	var test = ""+num+" "+login;
  	$.post('./ajax/deleteVoeu.php', {no_projet: num,login:login}, function(data, textStatus, xhr) 
  	{
		if (data!=true) 
		{
			toast(data,4000);
		}
		else
		{
  			toast('Votre voeu à bien était supprimé',4000);
  			document.location.reload(true);
  		}
  	},'json');
  }