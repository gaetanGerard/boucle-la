# TODO
## Checkout
1) Design de la page de checkout voir woocommerce

## Email
1. Créer un template d'email pour la newsletter dans le même style que celui pour les commandes

## Page to Design
1) form-add-payment-method -> pourrais être utiliser a vérifier dans quel cas de figure
2) form-reset-password -> à vérifier dans quel cas de figure pourrais être utiliser
3) payment-methods -> à vérifier dans quel cas de figure serait utiliser
4) Observer les fichier dans woocommerce/checkout pour voire les fichier qui pourrait être utiliser sur le site
5) lorsque je valide une commande je vais sur plusieurs fichier comme par exemple woocommerce/checkout/thankyou.php

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
- Intégration du style pour la page de login/register
- Régler problème de redirection pour les pages panier sur le home et ouverture du cart-panel
- Page mot de passe oublié et success (Desktop & Responsive) -- FAIT --
- Design de la page 404 (Desktop & Responsive) -- FAIT --
- Pour le compte design de la page Tableau de bord/Commandes/Adresse/ détails du compte (Desktop & Responsive) -- FAIT --
- Mis en place d'une conditions si aucune commande n'a jamais été passé pour montrer un design tout simple et une bouton pour aller sur le /
- Design de toutes les pages en lien direct avec le compte utilisateurs, Design de la page review-order  (Desktop & Responsive) -- FAIT --

# BUG
- DE temps en temps lorsque je suis en invité sur le site si j'ajoute un produits et que je j'ajoute autant de produit aussi rapidement que possible je suis rediriger vers la page de login de l'admin
- Sur carte cadeau dans le panier si montant = 0 alors retirer carte cadeau du panier

# Limitations
## Nextend Login With social
Nextend me permet d'utiliser des provider de login comme google, facebook (que je n'ai pas pu mettre en place pour l'instant car une connection en https est obligatoire) le plugin est gratuit pour les besoins mais a des limitations au niveau de ses possibilité, lorsque j'ajoute un bouton login with il est automatiquement ajouter au login form de woocommerce et n'est pas possible de le détacher d'ou la raison pour laquel je ne peux appliquer le design initial. Je ne peux pas non plus ajouter le bouton des réseaux sociaux pour s'inscrire car il s'agit d'une feature premium

# Test Feature
- Email & Newsletter : J'ai déployer un docker avec Mailhog pour tester en local l'envoie d'email et la souscription à la newsletter tout fonctionne comme je l'attends et les emails sont bien envoyer
  **TEST FAIT** email bien envoyer, inscription à la newsletter fonctionnel
- Panier : Test qu'il est possible de modifier les quantités du panier de manière asynchrone et de les enlever du panier si nécessaire
  **TEST FAIT** Il est possible de modifier les auntité de produit et pour une carte cadeau de modifier le prix de la carte
- Produit : Test des différents états produit (stock/rupture) veiller a ce que un produit ne puisse être ajouter au panier si en rupture
 **TEST FAIT** Ajout au panier désactiver si rupture
- Carte Cadeau : Test de soumission du formulaire pour ajouter une carte cadeau au panier, modifications du prix de la carte cadeau dans le panier
  **TEST FAIT** Création d'une carte cadeau avec un code personnalisé et une validité
- Login/Register : **TEST FAIT** il est possible de se connecter avec google ou avec email/password, il est également possible de créer un compte avec google ou avec le formulaire d'inscription
-  Commandes: **TEST FAIT** vérifier qu'il est possible d'effectuer des commandes et vérifier que l'email avec le code cadeau est envoyer une fois le payement effectuer

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

-> J'ai intégrer une solution développer à l'aide de l'IA pour créer une carte cadeau et envoyer des emails une fois le payement réceptionner

## Registration Page
1. J'utilise un champs select avec les informations des pays ajouter en dur idéalement se serait plus interéssant d'avoir la possibilité d'ajouter les pays dans le select via le customiseur

## Améliorations a effectuer

### Tailwind (DONE)
- J'ai rencontrer un bug avec tailwind en switchant de page sur certaines les classes ne sont plus utilisé et le style devient cassé
- j'ai du non seulement installer le plugin wordpress mais également importer les styles via le CDN

**Solutions** :
Tailwind à été complètement enlver du code ainsi que le plugin tailpress pour devenir indépendant à cet solution

## Intégrer beaucoup plus d'option dans le customiseur

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


## Admin

1. Ajouter la possibilité de customiser la page 404 natif texte et image