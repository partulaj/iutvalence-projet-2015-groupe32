/**
 * Fichier contenant les fonctions de manipulation des Taches
 */


/**
 * Ajout d'une tâche par requête Ajax
 */
 function newTask(no_groupe)
 {
 	var nom = $("#nom_new_tache").val();
 	var etat = $("#etat_new_tache").val();
 	var ordre = $("#ordre_new_tache").val();
 	var  groupe = no_groupe;
 	var students = [];
 	$("#list_new_tache").children("input").each(function(index, el) {
 		if($(this).is(":checked"))
 		{
 			students[index]=$(this).val();
 		}
 		else
 		{
 			students[index]="";	
 		}
 	});
 	$.post('./ajax/createTache.php', {nom_tache:nom,etat_tache:etat,ordre_tache:ordre,etudiants:students,no_groupe:groupe}, function(data) {
 		if (data!=true) 
 		{
 			toast(data,4000);
 		}
 		else
 		{
 			toast('Votre tache à bien était ajouté',4000);
 			document.location.reload(true);
 		}
 	},'json');
 }
/**
 * Modification d'une tache par requête Ajax
 */
 function editTask(num, no_groupe)
 {
 	var nom = $("#nom_tache"+num).val();
 	var etat = $("#etat_tache"+num).val();
 	var ordre = $("#ordre_tache"+num).val();
 	var students = [];
 	var  groupe = no_groupe;
 	var check =[]
 	$("#list_tache"+num).children("input").each(function(index, el) {
 		students[index]=$(this).val();
 		if($(this).is(":checked"))
 		{
 			check[index]=true;
 		}
 	});
 	$.post('./ajax/updateTache.php', {no_tache:num,nom_tache:nom,etat_tache:etat,ordre_tache:ordre,etudiants:students,change:check,no_groupe:groupe}, function(data) {
		if (data!=true) 
		{
			toast(data,4000);
		}
		else
		{
 			toast('Votre tache à bien était modifié',4000);
 			document.location.reload(true); 			
 		}
 	},'json');
 }

/**
 * Suppression d'une tache par requête Ajax
 */
 function delTask(num)
 {
 	var nom = $("#nom_tache"+num).val();
 	var students = [];
 	$("#list_tache"+num).children("input").each(function(index, el) {
 		if($(this).is(":checked"))
 		{
 			students[index]=$(this).val();
 		}
 	});
 	$.post('./ajax/deleteTache.php', {no_tache:num,etudiants:students}, function(data) {
		if (data!=true) 
		{
			toast(data,4000);
		}
		else
 		{
 			toast('Votre tache à bien était supprimé',4000);
 			document.location.reload(true);
 		}
 	},'json');
 }
