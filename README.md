# project-php

# Technologies utilisées : 
- PHP
- Javascript
- Twig
- Less
- Ratchet (WebSockets)
- PHPMailer
- Composer
- MicroFramework

## Bilan : 
** Toute la partie administrateur fonctionne : **
Ajout, modification, suppression d'une question, de ses réponses, et des utilisateurs


Création d'une partie, ajout des joueurs ainsi que leur couleur<br>
Création d'un lien vers une partie<br>
Envoi du mail chez les joueurs<br>
Salon de jeu dynamique<br>

## Manuel d'installation : 
Voici les identifiants pour se connecter en tant qu'admin : 
username : AudHep  
psw : aqwzsx

L'administrateur a accès à la partie admin en cliquant sur son pseudo, puis "admin".<br>
Il choisit sur quelle page il souhaite se rediriger.<br>
Le panneau latéral permet de naviguer facilement entre les sections.<br>
Le bouton + en haut à droite permet d'ajouter un élément.<br>
Les opérations permettent de modifier ou supprimer un élément.<br>
On ne peut pas rentrer n'importe quelle valeur dans un input.<br>
Pour l'ajout d'une question, on l'ajoute normalement comme un utilisateur. Pour ajouter ses réponses, on clique sur le bouton + en face de son label dans le tableau.<br>
On accède aux réponses en cliquant sur "Voir les réponses".<br>

Ensuite, qu'on soit connecté en tant qu'user ou admin, on peut modifier ses identifiants, mdp... en cliquant sur son pseudo, puis profil.

Un user ne peut pas accéder à la partie admin.

## Création d'une partie

Tout utilisateur peut créer ne partie en cliquant sur jouer.<br>
Il nécessite un compte pour jouer. C'est pourquoi si l'utilisateur n'est pas connecté, il est redirigé vers la page de connection pour y renseigner ses identfiants, ou pour s'inscrire.<br>
Lorsqu'il est connecté et qu'il a cliqué sur "Jouer". Il est redirigé vers la page de création de jeu. Il y renseigne le pseudo des joueurs. Il est aidé par l'autocomplétion. Il donne à chaque joueur une couleur (qui n'est utilisable que par 1 joueur).<br>
La partie va de 2 à 6 joueurs.<br>
Il peut ensuite cliquer sur créer. Cela enverra un mail à chaque utilisateur qu'il a reneigné en créant la partie.
Le mail contient en partie le lien de la partie.

## Partie

Lorsque les joueurs ont cliqués sur le lien qu'ils ont reçus par mail, il arrivent dans la partie.<br>
La page se met à jour sans se rafraîchir grâce à Ratchet.<br>
Seul le joueur à qui c'est le tour peut joueur. Il clique sur le bouton jouer.<br>
Un modal avec les niveaux apparaît sur tous les écrans. Il choisit son niveau et répond à la question.<br>
Toute l'interaction avec la question se passe directement sur le modal. Il affiche ensuite si la réponse choisie est bonne ou mauvaise.<br>
Dans tous les cas, le Modal disparait automatiquement 3 secondes après avoir répondu, et c'est le tour du joueur suivant. 
Le pion du joueur avance ou recule si la question est bonne ou mauvaise.