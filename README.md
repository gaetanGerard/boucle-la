# TODO

## Page Login/Register
1) Intégrer le style au page de login/register

## Checkout
1) Design de la page de checkout voir woocommerce

## Page compte
1) Intégrer le style à la page du compte
2) Design d'une page pour suivi commandes

# DONE

- Panier (Desktop & Responsive)  -- FAIT --
- Acceuil (Desktop & Responsive) -- FAIT --
- Boutique avec catégories et filtre (Desktop & Responsive) -- FAIT --
- Page produit (Desktop & Responsive) -- FAIT --
- Update Admin pour ajout composition dans les produits -- FAIT --
- Page Carte cadeau (Desktop & Responsive) -- FAIT --
- Page à propos (Desktop & Responsive) -- FAIT --
- Page Contact (Desktop & Responsive) -- FAIT --
- Design d'une page de succès si inscris à la newsletter (Desktop & Responsive) -- FAIT --
- Création d'un Formulaire de Login et d'inscription
- Ajout de la possibilité de se connecter avec Google
- Travail sur les fonctionnalité de la page mon-compte

# Test Feature
- Email & Newsletter : J'ai déployer un docker avec Mailhog pour tester en local l'envoie d'email et la souscription à la newsletter tout fonctionne comme je l'attends et les emails sont bien envoyer
- Panier : Test qu'il est possible de modifier les quantités du panier de manière asynchrone et de les enlever du panier si nécessaire
- Produit : Test des différents états produit (stock/rupture) veiller a ce que un produit ne puisse être ajouter au panier si en rupture
- Carte Cadeau : Test de soumission du formulaire pour ajouter une carte cadeau au panier, modifications du prix de la carte cadeau dans le panier

# TO IMPROVE

## Carte cadeaux
Pour l'instant j'utilise une carte cadeau entièrement créer mais cet solution pose un problème sur la génération
d'une carte cadeau qui soit unique donc avec un code unique, une date d'expiration pour l'instant ma solution ne
fait pas sa, je pourrais le faire moi-même mais celà me prendra plusieurs semaines (voire peut-être mois) de développement, la solution que je pourrais envisager serait l'utilisation du plugin YTH Gift Card de woo-commerce
celà implique plusieurs avantage
1.  chaque carte cadeau aura un code générer dynamiquement
2.  chaque carte cadeau aura une date d'expiration
3.  une plus grande sécurité car plugin maintenu par une équipe de dev dédié

et plusieurs inconvénients
1. je perdrais en flexibilité sur ce qui est possible de faire avec une solution construite
2. je serais limité sur le design de la page et sur la solution actuel qui m'oblige a intégré le thème

-> Prochaines étapes : discuter avec le client sur la solution qu'elle préfère

## Améliorations a effectuer

### Tailwind
- J'ai rencontrer un bug avec tailwind en switchant de page sur certaines les classes ne sont plus utilisé et le style devient cassé
- j'ai du non seulement installer le plugin wordpress mais également importer les styles via le CDN

**Solutions** :
1. Je pourrais télécharger le fichier minifier de tailwind et le mettre dans un dossier d'assets
2. Je devrais me débarasser de tout les importset plugins pour épurer le thème et ne conserver que les fichiers minifier
3. Tailwind possède certains avantages non négligeable mais il serait également envisageable de le laisser tomber entièrement

***Solutions que j'envisage*** J'envisage une solution Hybride donc j'aurais un fichier minifier de tailwind et un fichier scss Pourquoi ? car lorsque je développe le thème mettre le code scss est beaucoup plus simple facile et supprime tout problème d'import des classes tailwind, néanmoins lorsque je créer une page j'utilise tailwind dans l'éditeur gutenberg pour ajouter des styles facilement.


**Problème principales** Avec cet solution je suis confronté à un très gros problème s'est celui que le client en modifiant les pages pourrais casser le thème (et le fera).

Par conséquent cet solution ne doit être considérer que comme temporaire elle ne peux pas être maintenu car elle part du principe que l'utilisateur ne touchera à rien ce qui est un risque.

#### Solution à long termes
Pour moi la solution à long termes serait :

1. De laisser tomber complètement tailwind au profit du scss
2. de construire des blocks pour l'éditeur degutenberg qui utiliserais le style de bo_theme et par conséquent qui n'impliquerais plus de cutomiser le css dans l'éditeur gutenberg

## Intégrer beaucou plus d'option dans le customiseur

L'intérêt principal de Wordpress réside dans le fait de pouvoir construire un site sans avoir à écrire une ligne de code, bien sur en tant que développeur je ne suis pas gêné par celà mais le client final lui ne devrait pas avoir à passer une minute dans un éditeur de texte à rajouter du css ou a demander à une intelligence artificielle de régler un problème, par conséquent il faut utiliser la feature du customiseur.

à l'heure actuel le customiseur n'est la que pour le footer, le header ainsi que pour un peu de style surtout pour les boutons et les liens

L'objectifs étant d'uniformiser le style et de permettre à l'utilisateur de facilement et rapidement changer les couleurs d'un bouton ou la couleur du fond du header/footer, évidemment cet fonctionnalité doit s'étendre sur beaucoup plus d'éléments.

1. La typographie ->  l'utilisateur doit pouvoir choisir une typographie parmis une liste
2. Typographie -> L'utilisateur doit pouvoir uploader une nouvelle font (lien ? fichier ? -> fichier serait le plus sur)
3. Couleur l'utilisateur devrait pouvoir sélectionner une palette de couleur la solution actuel donne trop de choix et il faudrait limiter les couleurs à 2/3 couleurs principals, une couleur de fond et une couleur pour aller sur ce fond (exemple fond noir texte blanc) voire à la limite trouver un moyen de calculer une couleur de texte  je pense qu'il serait également interéssant de donner des informations sur l'utilisation de couleur 1/2/3 fond 1 / texte 1 / success / error / warning
4. Le style des boutons je devrais pouvoir sélectionner différents style de bouton par exemple un bouton natif à wordpress / un bouton sans arrondi / un bouton seulement outlined / un bouton avec une drop shadow -> la question réside dans savoir si certaines options pourrait être mélanger ?
5. les réseaux sociaux il faudrait les définir dans le customiseur et les utiliser dans le site en partant des valeurs ajouter a cet endroit
6. le menu mobile -> permettre à l'utilisateur de l'ouvrir à gauche ou à droite de l'écran (droite serait le défaut)
7. les input de type texte/select textarea devrait adopter un style similaire au bouton ? ou alors devrait être configurable en suivant plusieurs principe de design comme par exemple le material design de google
8. page à propos j'utilise des classes CSS about-block et about-block-img-centered il faudrait voire pour créer des blocs dédiés