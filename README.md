# Projet IO2
Ce projet a pour but le partage de l'expérience mathématique d'une maniere plus concrête. Notamment à l'aide du concept du "Blackboard", une partie *publique* de chaque profil des utilisateurs entièrement consacrée aux stratégies sous-jacentes (expliquer comment on jugule les erreurs d'inattention, comment s'améliorer, partager des stratégies et des idées générales d'utilités variées et vaste... ). 
Fonctionnalités du dite :
- inscription/Connexion.
- Publications.
- Likes et commentaires.
- Abonnement à des utilisateurs.
- Modification des postes et des commentaires + possibilité de suppression.
- Page Profil associé à chaque utilisateur (possibilité de s'abonner/désabonner et de voir les informations, la blackboard et les postes de l'utilisateurs).
- Fil d'actualité (avec la possibilité de choisir le critère de l'ordre).
- système pour gérer l'affichage des postes.
- système pour gérer l'affichage des commentaires.
- Une page crée pour chercher et trouver d'autres utilisateurs
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
|      -      | Page d'inscription            | Page de profil | Page d'actualité |
| ----------- |:----------------------------: | -------------- | ---------------- |
| Mohamed     | -Création des classes :Database.php, DefaultPage.php, Login.php, Register.php, Verification.php.-Création du schema mySQL       | ...            | ...              |                          
| Marius      | commentaires...               | ...            | ...              | 

Groupe 27, Marius Lecomte et Mohamed BEN EL MOSTAPHA.

