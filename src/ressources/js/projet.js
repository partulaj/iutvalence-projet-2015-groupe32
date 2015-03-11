 /**
  * Fichier contenant les fonctions de manipulation des projets
  */

 /**
  * Ajout d'un projet par requête Ajax
  */
  function newProject()
  {
  	var project_name = $("#project_name").val();
  	var nb_min = $("#nb_min").val();
  	var nb_max = $("#nb_max").val();
  	var contexte = $("#contexte").val();
  	var objectif = $("#objectif").val();
  	var contrainte = $("#contrainte").val();
  	var details = $("#details").val();
    if ($("#nb_groupes").is(":checked"))
    {
      var nb_groupes = $("#nb_groupes").val();
    }
    else
    {
      var nb_groupes = "";
    }

    $.post('./ajax/createProjet.php', {
      project_name:project_name,
      nb_min:nb_min,
      nb_max:nb_max,
      contexte:contexte,
      objectif:objectif,
      contrainte:contrainte,
      details:details,
      nb_groupes:nb_groupes
    }, function(data) {
      if (data=="") 
      {
       toast('Votre projet à bien était créé',4000);
       document.location.reload(true);
     }
     else
     {
       toast('Un problème est survenu veuillez signaler le bug',4000)
     }
   });
  }

  /**
   * Modification d'un projet par requête Ajax
   */
   function editProject(num)
   {
   	var test = "projet"+num;
   	var project_name = $("#project_name"+num).val();
   	var nb_min = $("#nb_min"+num).val();
   	var nb_max = $("#nb_max"+num).val();
   	var contexte = $("#contexte"+num).val();
   	var objectif = $("#objectif"+num).val();
   	var contrainte = $("#contrainte"+num).val();
   	var details = $("#details"+num).val();
   	$.post('./ajax/updateProjet.php', {
   		no_projet:num,
   		project_name:project_name,
   		nb_min:nb_min,
   		nb_max:nb_max,
   		contexte:contexte,
   		objectif:objectif,
   		contrainte:contrainte,
   		details:details,}, function(data) {
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
