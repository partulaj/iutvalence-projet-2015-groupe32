<?php
// Connexion au LDAP de l'IUT, retourne null si l'authentification échoue et sinon un tableau d'informations
// sur l'utilisateur :
//    array('login' => "login", 'nom' => "Prenom Nom", 'courriel' => 'Adresse électronique')
function LDAPAuthentification($login, $password) {
   $ds = ldap_connect("crozes"); 
   if (! $ds) return null;

   // Recherche pour récupérer le dn complet de l'utilisateur (et le nom et le courriel)
   $sr=ldap_search($ds, "dc=iut-valence,dc=fr", "uid=$login", array("dn", "cn", "mail"));  
   if (! $sr) return null;

   $info = ldap_get_entries($ds, $sr);
   if (! isset($info[0])) return null;

   echo "<pre>",print_r($info[0]),"</pre>";

   // Tentative de connexion avec le bon dn et le mot de passe
   $ok = ldap_bind($ds, $info[0]["dn"], $password);
   ldap_close($ds);
   if (! $ok) return null;
    
   // Dans le cas où le nom ou le mail sont absents
   $nom = (isset($info[0]['cn']))?$info[0]['cn'][0]:"";
   $courriel = (isset($info[0]['mail']))?$info[0]['mail'][0]:"";
   return array('login' => $login, 'nom' => $nom, 'courriel' => $courriel);
}
?>
