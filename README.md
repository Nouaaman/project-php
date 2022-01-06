# project-php

# Technologies utilisées : 
- PHP
- Javascript
- Twig
- Less
- Ratchet (WebSockets)
- PHPMailer
- Composer

## Bilan : 
** Toute la partie administrateur fonctionne : **
Ajout, modification, suppression d'une question, de ses réponses, et des utilisateurs


Création d'une partie, ajout des joueurs ainsi que leur couleur
Création d'un lien vers une partie
Envoi du mail chez les joueurs
Salon de jeu dynamique 

## Manuel d'installation : 
Voici les identifiants pour se connecter en tant qu'admin : 
pseudo
mdp

L'administrateur a accès à la partie admin en cliquant sur son pseudo, puis "admin".
Il choisit sur quelle page il souhaite se rediriger.
Le panneau latéral permet de naviguer facilement entre les sections.
Le bouton + en haut à droite permet d'ajouter un élément.
Les opérations permettent de modifier ou supprimer un élément.
On ne peut pas rentrer n'importe quelle valeur dans un input.
Pour l'ajout d'une question, on l'ajoute normalement comme un utilisateur. Pour ajouter ses réponses, on clique sur le bouton + en face de son label dans le tableau.
On accède aux réponses en cliquant sur "Voir les réponses".

Ensuite, qu'on soit connecté en tant qu'user ou admin, on peut modifier ses identifiants, mdp... en cliquant sur son pseudo, puis profil.

Un user ne peut pas accéder à la partie admin.

## Création d'une partie

Tout utilisateur peut créer ne partie en cliquant sur jouer.
Il nécessite un compte pour jouer. C'est pourquoi si l'utilisateur n'est pas connecté, il est redirigé vers la page de connection pour y renseigner ses identfiants, ou pour s'inscrire.
Lorsqu'il est connecté et qu'il a cliqué sur "Jouer". Il est redirigé vers la page de création de jeu. Il y renseigne le pseudo des joueurs. Il est aidé par l'autocomplétion. Il donne à chaque joueur une couleur (qui n'est utilisable que par 1 joueur).
La partie va de 2 à 6 joueurs.
Il peut ensuite cliquer sur créer. Cela enverra un mail à chaque utilisateur qu'il a reneigné en créant la partie.
Le mail contient en partie le lien de la partie.

## Partie

Lorsque les joueurs ont cliqués sur le lien qu'ils ont reçus par mail, il arrivent dans la partie.
La page se met à jour sans se rafraîchir grâce à Ratchet.
Seul le joueur à qui c'est le tour peut joueur. Il clique sur le bouton jouer.
Un modal avec les niveaux apparaît sur tous les écrans. Il choisit son niveau et répond à la question.