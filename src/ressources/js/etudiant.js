/**
 * Fichier contenant les fonctions de manipulation des étudiants
 */
/**
 * Suppression d'étudiants par requâte ajax
 */
function delStudent()
{
	var indiceListeSupp=0;
	var liste = $("#list-etudiants").children('li');
	var listeSupp = [];
	liste.each(function(index, el) {
		var listComponent = $(el).children();

		if(listComponent.eq(0).hasClass('red'))
		{
			var login = listComponent.eq(3).text();
			listeSupp[indiceListeSupp] = login;
			indiceListeSupp++;
		}
	});
	$.post('./ajax/deleteEtudiants.php', {array: listeSupp}, function(data) 
	{
		if (data!=true) 
		{
			toast(data,4000);
		}
		else
		{
			toast("Les étudiants sélectionné ont bien étaient supprimé");
			document.location.reload(true);
		}
	},'json');
}

/**
 * Rafrachissement de la liste des étudiants par requête ajax
 */
function refreshAll()
{
	$.getJSON('./ajax/getAllEtudiants.php',{},function(json) 
	{
		if (json==null) 
		{
			toast('Un problème est survenu veuillez signaler le bug',4000)
		}
		else
		{
			$("#all>table").empty();
			$("#all>table").append('<tr><th>Login</th><th>Nom</th><th>Prénom</th><th>Groupe</th><th>Mail</th></tr>');
			for (var i = 0; i < json.length; i++) 
			{
				var current = json[i];
				if (current.no_groupe==null) 
				{
					current.no_groupe='';
				}
				$("#all>table>tbody").append(	'<tr>\
												<td>'+current.login_etudiant+'</td>\
												<td>'+current.nom_etudiant+'</td>\
												<td>'+current.prenom_etudiant+'</td>\
												<td>'+current.no_groupe+'</td>\
												<td><a href="mailto:'+current.mail_etudiant+'">Lui écrire</a></td>\
												</tr>');
			};
			
		}
	});
}

/**
 * Rafraichisssement de la liste des étudiants sans projets par requête ajax
 */
function refreshSP()
{
	$.getJSON('./ajax/getAllSansProjets.php',{},function(json) 
	{
		if (json==null) 
		{
			toast('Un problème est survenu veuillez signaler le bug',4000)
		}
		else
		{
			$("#sp").empty();
			$("#sp").append('<table class="responsive-table bordered hoverable hide"><tr><th>Nom</th><th>Prénom</th><th>Mail</th></tr></table>');
			for (var i = 0; i < json.length; i++) 
			{
				var current = json[i];
				$("#sp>table>tbody").append('<tr><td>'+current.nom_etudiant+'</td><td>'+current.prenom_etudiant+'</td><td><a href="mailto:'+current.mail_etudiant+'">Lui écrire</a></td></tr>');
			};
			$("#sp>table").removeClass('hide');
		}
	});
}

/**
 * Rafraichissement de la liste des étudiants sans voeux par requêt ajax
 */
function refreshSV()
{
	$.getJSON('./ajax/getAllSansVoeux.php',{},function(json) 
	{
		if (json==null) 
		{
			toast('Un problème est survenu veuillez signaler le bug',4000)
		}
		else
		{
			$("#sv").empty();
			$("#sv").append('<table class="responsive-table bordered hoverable hide"><tr><th>Nom</th><th>Prénom</th><th>Mail</th></tr></table>');
			for (var i = 0; i < json.length; i++) 
			{
				var current = json[i];
				$("#sv>table>tbody").append('<tr><td>'+current.nom_etudiant+'</td><td>'+current.prenom_etudiant+'</td><td><a href="mailto:'+current.mail_etudiant+'">Lui écrire</a></td></tr>');
			};
			$("#sv>table").removeClass('hide');
		}
	});
}

/**
 * Rafraichissement de la liste des étudiants par requête ajax avec possibilité de supprimer les étudiants
 */
function refreshSE()
{
	$.getJSON('./ajax/getAllEtudiants.php',{},function(json) 
	{
		if (json==null) 
		{
			toast('Un problème est survenu veuillez signaler le bug',4000)
		}
		else
		{
			$("#se>ul").empty();
			for (var i = 0; i < json.length; i++) 
			{
				var current = json[i];
				$("#se>ul").append('<li class="collection-item avatar row">\
					<i class="mdi-social-school grey circle clickable-item"></i>\
					<span class="title nom_etudiant col s3">'+current.nom_etudiant+'</span>\
					<span class="title prenom_etudiant col s3">'+current.prenom_etudiant+'</span>\
					<span class="login_etudiant col s3">'+current.login_etudiant+'</span>\
					</li>');
			};
			$(".clickable-item").click(function()
			{
				$(this).toggleClass("grey mdi-social-school");
				$(this).toggleClass("red mdi-content-clear");
			});
			$(".clickable-item").css('cursor', 'pointer');
			
		}
	});
}

/**
 * Changement de groupe de 2 étudiants par requête ajax
 */
function switchGroup()
{
	var etu1 = $("#switchEtu1").val();
	var etu2 = $("#switchEtu2").val();
	$.post('./ajax/switchGroup.php', {etudiant1:etu1,etudiant2:etu2}, function(data)
	{
		if (data!=true) 
		{
			toast(data,4000);
		}
		else
		{
			toast('Le changement de groupe a bien été fait',4000);
			document.location.reload(true);
		}
	},'json');
}