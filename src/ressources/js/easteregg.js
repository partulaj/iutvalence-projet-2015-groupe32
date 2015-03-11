/**
 * Fichier contenant un easter egg
 */

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
