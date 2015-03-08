/**
 * Déclaration des variable globales
 */
 var konami = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
 var indiceKonami = 0;
 var message = [
 'Phrase 1 sur 13 : Il y a 10 types de personnes dans le monde : celles qui comprennent le binaire, et celles qui ne le comprennent pas.',
 'Phrase 2 sur 13: Microsoft : « Vous avez des questions ? Nous avons des trombones qui dansent. »',
 'Phrase 3 sur 13: Si vous ne réussissez pas du premier coup, appelez ça « version 1.0 ».',
 'Phrase 4 sur 13: $! v0u$ p0uv32 1!r3 c3c!, v0u$ 4v32 vr4!m3n7 83$0!n d3 n!qu3r',
 'Phrase 5 sur 13: La programmation aujourd’hui est une course entre les développeurs tâchant de concevoir des programmes de plus en plus nombreux et efficaces, convenant même aux imbéciles, et l’univers essayant de produire des idiots de plus en plus nombreux et efficaces. Jusqu’à présent, c’est l’univers qui gagne.',
 'Phrase 6 sur 13: Je ne suis pas asocial, Je ne suis juste pas orienté utilisateur.',
 'Phrase 7 sur 13: J’adorerais changer le monde, mais ils ne veulent pas me fournir le code source.',
 'Phrase 8 sur 13: Le manuel disait « Nécessite Windows XP ou mieux ». J’ai donc installé Linux.',
 'Phrase 9 sur 13: Les gens disent que si on joue les CD de Microsoft à l’envers, on entend des sons sataniques. Mais ce n’est rien, parce que si on le joue à l’endroit, cela installe Windows…',
 'Phrase 10 sur 13: Mes logiciels n’ont jamais de bug. Ils développent juste certaines fonctions aléatoires.',
 'Phrase 11 sur 13: Quand la vie apporte des questions, Google donne les réponses.',
 'Phrase 12 sur 13: Utiliser le meilleur : Linux pour les serveurs ,Mac pour le graphisme ,Palm pour la mobilité ,Windows pour le solitaire',
 'Phrase 13 sur 13: Windows a détecté que vous n’aviez pas de clavier. Appuyez sur ‘F9′ pour continuer.'
 ];


/**
 * Fonction qui se lance au démarrage
 */
 $(document).ready(function () 
 {
 	$(".button-collapse").sideNav();
 	$('select').material_select();
 	$('.hide').fadeOut("fast");
 	$(".dropdown-button").dropdown({hover:false});
 	$('.modal-trigger').leanModal();

 	(function($) {
 		$.fn.spinner = function() {
 			this.each(function() {
 				var el = $(this);

	  // add elements
	  el.wrap('<span class="spinner"></span>');     
	  el.before('<span class="sub">-</span>');
	  el.after('<span class="add">+</span>');

	  // substract
	  el.parent().on('click', '.sub', function () {
	  	if (el.val() > parseInt(el.attr('min')))
	  		el.val( function(i, oldval) { return --oldval; });
	  });

	  // increment
	  el.parent().on('click', '.add', function () {
	  	if (el.val() < parseInt(el.attr('max')))
	  		el.val( function(i, oldval) { return ++oldval; });
	  });
	});
 		};
 	})(jQuery);
 	$('input[class=number]').spinner();

	/**
	 * Fonction qui déplie un élément cacher
	 */
	 function deplier(el)
	 {
	 	el.slideToggle("slow");
	 }

	 /**
	  * Lien dépliant
	  */
	  $(".slide-link").click(function(event) {
	  	$elem=$(this);
	  	var nom =$elem.children().attr('class'); 
	  	if (nom=="mdi-hardware-keyboard-arrow-down") 
	  	{
	  		$elem.children().removeClass();
	  		$elem.children().addClass('mdi-hardware-keyboard-arrow-up');
	  	}
	  	if(nom=='mdi-hardware-keyboard-arrow-up')
	  	{
	  		$elem.children().removeClass();
	  		$elem.children().addClass('mdi-hardware-keyboard-arrow-down');
	  	}
	  	$hidden = $elem.parent().parent().parent().children(".hide");
	  	deplier($hidden);
	  });


	});

/**
 * Ajout d'un voeu par requête Ajax
 */
 function ajoutVoeu(num)
 {
 	var p = $("#priorite"+num).get(0).value;
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
  * Ajout d'un projet par requête Ajax
  */
  function newProject()
  {
  	var project_name = $("#project_name").get(0).value;
  	var nb_min = $("#nb_min").get(0).value;
  	var nb_max = $("#nb_max").get(0).value;
  	var contexte = $("#contexte").get(0).value;
  	var objectif = $("#objectif").get(0).value;
  	var contrainte = $("#contrainte").get(0).value;
  	var details = $("#details").get(0).value;
    if ($("#nb_groupes").is(":checked"))
    {
      var nb_groupes = $("#nb_groupes").get(0).value;
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
   	var project_name = $("#project_name"+num).get(0).value;
   	var nb_min = $("#nb_min"+num).get(0).value;
   	var nb_max = $("#nb_max"+num).get(0).value;
   	var contexte = $("#contexte"+num).get(0).value;
   	var objectif = $("#objectif"+num).get(0).value;
   	var contrainte = $("#contrainte"+num).get(0).value;
   	var details = $("#details"+num).get(0).value;
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

/**
 * Modification d'un Voeu par requête Ajax
 */
 function editVoeu(num, login)
 {
 	var priorite = $("#priorite"+num).get(0).value;
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

/**
 * Ajout d'une tâche par requête Ajax
 */
 function newTask(no_groupe)
 {
 	var nom = $("#nom_new_tache").get(0).value;
 	var etat = $("#etat_new_tache").get(0).value;
 	var ordre = $("#ordre_new_tache").get(0).value;
  var  groupe = no_groupe;
 	var students = [];
 	$("#list_new_tache").children("input").each(function(index, el) {
 		if($(this).is(":checked"))
 		{
 			students[index]=$(this).get(0).value;
 		}
 	});
 	$.post('./ajax/createTache.php', {nom_tache:nom,etat_tache:etat,ordre_tache:ordre,etudiants:students,no_groupe:groupe}, function(data) {
 		if (data=="") 
 		{
 			toast('Votre tache à bien était ajouté',4000);
 			document.location.reload(true);
 		}
 		else
 		{
 			toast('Un problème est survenu veuillez signaler le bug',4000)
 		}
 	});
 }
/**
 * Modification d'une tache par requête Ajax
 */
 function editTask(num, no_groupe)
 {
 	var nom = $("#nom_tache"+num).get(0).value;
 	var etat = $("#etat_tache"+num).get(0).value;
 	var ordre = $("#ordre_tache"+num).get(0).value;
 	var students = [];
  var  groupe = no_groupe;
 	var check =[]
 	$("#list_tache"+num).children("input").each(function(index, el) {
 		students[index]=$(this).get(0).value;
 		if($(this).is(":checked"))
 		{
 			check[index]=true;
 		}
 	});
 	$.post('./ajax/updateTache.php', {no_tache:num,nom_tache:nom,etat_tache:etat,ordre_tache:ordre,etudiants:students,change:check,no_groupe:groupe}, function(data) {
 		if (data=="") 
 		{
 			toast('Votre tache à bien était modifié',4000);
 			document.location.reload(true);
 		}
 		else
 		{
 			toast('Un problème est survenu veuillez signaler le bug',4000)
 		}
 	});
 }

/**
 * Suppression d'une tache par requête Ajax
 */
 function delTask(num)
 {
 	var nom = $("#nom_tache"+num).get(0).value;
 	var etat = $("#etat_tache"+num).get(0).value;
 	var ordre = $("#ordre_tache"+num).get(0).value;
 	var students = [];
 	$("#list_tache"+num).children("input").each(function(index, el) {
 		if($(this).is(":checked"))
 		{
 			students[index]=$(this).get(0).value;
 		}
 	});
 	$.post('./ajax/deleteTache.php', {no_tache:num,nom_tache:nom,etat_tache:etat,ordre_tache:ordre,etudiants:students}, function(data) {
 		if (data=="") 
 		{
 			toast('Votre tache à bien était supprimé',4000);
 			document.location.reload(true);
 		}
 		else
 		{
 			toast('Un problème est survenu veuillez signaler le bug',4000)
 		}
 	});
 }

/**
 * Fonction qui affiche un easter egg si l'on fait le konami code
 */
 $(document).keydown(function (e) {
 	if (e.keyCode === konami[indiceKonami++]) {
 		if (indiceKonami === konami.length) {
 			var x = Math.floor((Math.random() * 13));
			alert(message[x]);
			indiceKonami = 0;
		}
	} else indiceKonami = 0
});

