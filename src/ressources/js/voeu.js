/**
 * Fichier contanant les fonction de manipulation des voeux
 */

/**
 * Ajout d'un voeu par requête Ajax
 */
 function ajoutVoeu(num)
 {
 	var p = $("#priorite"+num).val();
 	if (p=="0")
 	{
 		return toast("Vous ne pouvez pas ajouter un voeu avec une priorité de 0", 4000);
 	}
 	$.post('./ajax/createVoeu.php', {no_projet: num, priorite:p}, function(data) 
 	{
 		if (data=="") 
 		{
 			toast('Le projet a était ajouté à vos Voeux',4000);
 			document.location.reload(true);
 		}
 		else
 		{
 			toast('Un problème est survenu veuillez signaler le bug',4000)
 		}
 	});
 }
/**
 * Modification d'un Voeu par requête Ajax
 */
 function editVoeu(num, login)
 {
 	var priorite = $("#priorite"+num).val();
 	$.post('./ajax/updateVoeu.php', {priorite: priorite,no_projet: num, login:login}, function(data) 
 	{
 		if (data=="") 
 		{
 			toast('Votre projet à bien était modifié',4000);
 			document.location.reload(true);
 		}
 		else
 		{
 			toast('Un problème est survenu veuillez signaler le bug',4000)
 		}
 	});
 }

 /**
  * Suppression d'un voeu par requête Ajax
  */
  function delVoeu(num, login)
  {
  	var test = ""+num+" "+login;
  	$.post('./ajax/deleteVoeu.php', {no_projet: num,login:login}, function(data, textStatus, xhr) 
  	{
  		if (data=="") 
  		{
  			toast('Votre voeu à bien était suprimé',4000);
  			document.location.reload(true);
  		}
  		else
  		{
  			toast('Un problème est survenu veuillez signaler le bug',4000)
  		}
  	});
  }