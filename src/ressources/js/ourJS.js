/**
 * Déclaration des variable globales
 */
var deplier=0;
var konami = [38, 38, 40, 40, 37, 39, 37, 39, 66, 65];
var indiceKonami = 0;
var message = [
            'Phrase 1 sur 14 : Il y a 10 types de personnes dans le monde : celles qui comprennent le binaire, et celles qui ne le comprennent pas.',
            'Phrase 2 sur 14: Microsoft : « Vous avez des questions ? Nous avons des trombones qui dansent. »',
            'Phrase 3 sur 14: Si vous ne réussissez pas du premier coup, appelez ça « version 1.0 ».',
            'Phrase 4 sur 14: $! v0u$ p0uv32 1!r3 c3c!, v0u$ 4v32 vr4!m3n7 83$0!n d3 n!qu3r',
            'Phrase 5 sur 14: La programmation aujourd’hui est une course entre les développeurs tâchant de concevoir des programmes de plus en plus nombreux et efficaces, convenant même aux imbéciles, et l’univers essayant de produire des idiots de plus en plus nombreux et efficaces. Jusqu’à présent, c’est l’univers qui gagne.',
            'Phrase 6 sur 14: Je ne suis pas asocial, Je ne suis juste pas orienté utilisateur.',
            'Phrase 7 sur 14: J’adorerais changer le monde, mais ils ne veulent pas me fournir le code source.',
            'Phrase 8 sur 14: Le manuel disait « Nécessite Windows XP ou mieux ». J’ai donc installé Linux.',
            'Phrase 9 sur 14: Les gens disent que si on joue les CD de Microsoft à l’envers, on entend des sons sataniques. Mais ce n’est rien, parce que si on le joue à l’endroit, cela installe Windows…',
            'Phrase 10 sur 14: Mes logiciels n’ont jamais de bug. Ils développent juste certaines fonctions aléatoires.',
            'Phrase 11 sur 14: Quand la vie apporte des questions, Google donne les réponses.',
            'Phrase 12 sur 14: Utiliser le meilleur : Linux pour les serveurs ,Mac pour le graphisme ,Palm pour la mobilité ,Windows pour le solitaire',
            'Phrase 13 sur 14: Windows a détecté que vous n’aviez pas de clavier. Appuyez sur ‘F9′ pour continuer.',
            'Phrase 14 sur 14: « Concept : Sur le clavier de la vie, gardez toujours un doigt sur le bouton « Echap ».'
            ];
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
 * Fonction qui affiche le formulaire
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

/**
 * Fonction qui affiche un easter egg si l'on fait le konami code
 */
$(document).keydown(function (e) {
    if (e.keyCode === konami[indiceKonami++]) {
        if (indiceKonami === konami.length) {
        	var x = Math.floor((Math.random() * 13));
            alert(message[x]); // à remplacer par votre code
            indiceKonami = 0;
        }
    } else indiceKonami = 0
});