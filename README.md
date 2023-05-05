# Projet IO2
Ce projet a pour but le partage de l'expérience mathématique. Les utilisateurs peuvent publier du contenu concernant les mathématiques (expliquer comment on jugule les erreurs d'inattention, comment s'améliorer, partager des stratégies et des idées générales d'utilités variées et vaste... ). 
Fonctionnalités du dite :
- inscription/Connexion.
- Publications.
- Likes et commentaires.
- Abonnement à des utilisateurs.
- Modification des postes et des commentaires + possibilité de suppression.
- Page Profil associé à chaque utilisateur (possibilité de s'abonner/désabonner et de voir les informations et les postes de l'utilisateurs).
- Fil d'actualité (avec la possibilité de choisir le critère de l'ordre like ou recent).
- système pour gérer l'affichage des postes (pages de 14 postes maximum).
- système pour gérer l'affichage des commentaires.
- Une page crée pour chercher et trouver d'autres utilisateurs.
- Implémentation des comptes administrateurs et des droits de chaque utilisateur.
## Set up
Pour tester le site sur un serveur locale, il faut installer xampp. 
Vous trouveriez les instructions précises [içi. ](https://drive.google.com/file/d/1pUH2w41q2nd7mExbjuDU9Ha8weh5dxPh/view?usp=sharing)
Après l'installation de xampp, suivez les instructions ci-dessous :
1. Activer le serveur mySQL et Apache à l'aide de xampp.
2. Pour Linux, vous copiez la ligne suivante au terminal : /opt/lampp/bin/mysql -u root -p. 
Pour Mac, vous copiez : /Applications/xampp/xamppfiles/bin/mysql -u root -p.
Pour Windows, \xampp\mysql\bin\mysql -u root -p.
3. saisir le mot de passe et puis tapez : source -chemin asbolu vers : schema_projet_io2.sql-.
Le fichier sql crée automatiquement un utilisateur admin de pseudo 'zayn' et de mot de passe 123.
## Contributions et répartition du travail
|      -      | Page d'inscription            | Page de profil | Page d'actualité | Page de recherche | Page de modification et suppression commentaire/poste | Page du poste/commentaire | implémentation de la sécurité et les droits de l'admin |
| ----------- |:----------------------------: | -------------- | ---------------- |
| Mohamed     | -Création des classes :Database.php, DefaultPage.php, Login.php, Register.php, Verification.php.-Création du schema mySQL. Créations des controleurs + le controleur frontal index.php   | Création de SeriesOfPosts.php et User.php et leurs controleurs            | Création de Post.php + l'implémentation avec SeriesOfPosts.php             |   implémentation avec le controleur frontal avec les paramètres GET |  création des fonctions de modification et de suppression et les controleurs des postes        |   création des vues et de controleurs et le controleur frontal post.php     | Implémentation des droits des utilisateurs avec la fonction privileges pour les pages des postes et des commentaires + sécurisation des session avec les cookies http only |
| Marius      | -HTML des pages + CSS             |    CSS +HTML + controleur frontale profile.php + les commandes SQL    | HTML et CSS        | création des fonctions de rechrche et les vues | création des fonctions de modification et de suppression des commentaires | implémentation des commentaires et les boutons d'affichage de commentaires | Implémentation de l'affichage des boutons modifier supprimer en fonction des droits de l'utilisateur |

Groupe 27, Marius Lecomte et Mohamed BEN EL MOSTAPHA.

