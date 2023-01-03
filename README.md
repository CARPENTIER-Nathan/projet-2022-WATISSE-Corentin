# projet-2022-WATISSE-Corentin
projet-2022-Touklak0s created by GitHub Classroom


Le forum est un espace de discussion ouvert à plusieurs participants. Les discussions y sont archivées ce qui permet une communication asynchrone. Les discussions sont modérées. Cas d'utilisation 




1.1. Un internaute se connecte au site La page d'accueil est constituée de la liste des thèmes ouverts sur le forum, la liste est paginée (max 5 thèmes/page). Pour chaque thème la date et l'heure de la dernière discussion est indiquée, ainsi que le nombre de discussions. 
Connection
Liste des thèmes (5 par pages max)
Date + Heure de la dernière discussion pour chaque thèmes
Nombre de discussions



1.2. Un internaute clic sur un thème La liste des discussions s'affiche dans l'ordre chronologique. Les informations (pseudo, date, heure) accompagnent chaque discussion. Si l'internaute est authentifié en haut et en bas de la liste, il peut accéder à l'ajout d'une discussion. La pagination est accessible en haut et en bas de page (max 10 discussion/page) 
Affichage pour chaque thèmes des discussions dans l'ordre chronologique
SI AUTHENTIFIE possibilité de créer une nouvelle discussion dans ce thème
Liste des discussions (10 par pages max)



1.3. Un internaute peut s'inscrire au site. Accès au formulaire d'inscription à partir de la première page, (le formulaire n'est pas présent dans la première page) les infos demandées sont : - le email - et password avec double vérification - le pseudo - le nom, le prénom, l'âge, tel (tous non obligatoire) - ville (non obligatoire) (avec suggestion ou auto-complétion) - le captcha. Tant que le formulaire n'est pas correctement rempli, la validation boucle sur le même formulaire avec les infos sur les erreurs Après la validation de son inscription, L'internaute reçoit un mail avec une URL permettant de confirmer son inscription, l'internaute a une journée pour confirmer son inscription. Après la validation de son inscription, il est redirigé sur la page consultée avant l'accès au formulaire
Formulaire d’inscription
Email + MDP (2 vérif) + Pseudo
Nom, Prénom,  ge, Tel, et Ville (pas obligatoire) 
Ville -> autocomplétion / recommandations
Captcha
Mail de verification
Boucle tant que tout n’est pas good + info sur les erreurs
Réceptions d’une URL par mail permettant de confirmer l’inscription
Valide 1 journée
Après validation, redirections vers la page consulté avant le formulaire ou la homepage



 1.4. Un internaute accède à son compte. Accès au formulaire d'authentification à partir de la première page. Formulaire apparaît sous forme de boîte de dialogue - log (le mail) - pass En cas de succès, son pseudo apparaît en haut de toutes les pages, on reste sur la même page. Si il est sur la liste des discussions, la possibilité d'ajouter une discussion apparaît. Un nouveau lien est apparu pour lui permettre de modifier son profil. Le nombre de connexions est indiqué en haut de page. (Ajax - intervalle 15 secondes) En cas d'échec retour au formulaire avec message d'information. Après 3 échecs temps de latence affichage de l'erreur puis 5 secondes plus tard formulaire.
Accès aux formulaires d’authentification via boîte de dialogue (email && pass)
Si sur liste des discussions -> possibilité d’ajouter une discussion (bouton disponible)
Accès à un lien permettant la modification du profile
Le nombre de personne connecté est affiché en haut de page
Si échec lors du login 
3 essaies, après cooldown pour réessayer plus tard


 1.5. Un futur participant confirme son inscription Dans l’e-mail demandant la confirmation de l'inscription, il y a une URL qui active l'accès Si le futur participant l'active, il arrive sur une page de remerciement et un mot l'invite à s'authentifier. Tant que la confirmation n'est pas faite l'authentification ne marche pas 
Envoie du mail de vérification
URL qui active le compte
Tant que le compte n’est pas vérifiée, le compte n’est pas utilisable
Message redirigeant vers le formulaire d’authentification 


1.6. Un participant ajoute une discussion. Une zone de saisie avec les actions apparaît progressivement en fin de discussion. Deux choix possibles sur cette zone de saisie : Fermer, Enregistrer. Fermer fait disparaître la zone et les boutons. Enregistrer remplace la zone et les boutons par le texte saisie. (max 5000 caractères)
Fermer ne sauvegarde pas le travail est renvoie à la liste des discussions du thème
Enregistrer sauvegarde le travail et le publie dans la liste des discussions du thème


 1.7. Un participant se déconnecte de son compte En haut à droite déconnexion, il revient à la homepage  
Bouton de déconnexion avec redirection homepage


1.8. Un modérateur se connecte à son compte. Sur chaque page apparaît en plus de ce qu'il y a pour un participant, la possibilité d'ajouter un thème, de lister les participants. Sur chaque discussion la possibilité de la supprimer ou de la modifier apparaît. 
Nouveau lien menu ADMIN, 
Ajouter / Supprimer thème 
Lister les participants
Supprimer / Modifier les discussions


1.9. Un modérateur supprime ou modifie une discussion La suppression en deux temps, vérification de la suppression, suppression effective. La modification est identique à l'ajout sauf que la zone est pré-remplie avec la discussion existante. 
Suppression en deux temps
Clique sur le bouton supprimer
Confirmation
Modification
Zone pré-rempli par la discussions existante

1.10. Le modérateur se déconnecte de son compte En haut à droite déconnexion, il revient à la homepage
Déconnexion par le même bouton que les users

Git
Test
Style
