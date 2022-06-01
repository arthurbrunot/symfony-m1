# Projet Symfony M1 ESGI 2022

Ce projet a été réalisé par Arthur BRUNOT - M1 IW ESGI Lyon
Il s'agit d'une application Symfony utilisant une base de donnée PostgreSQL

## Installation

Afin de lancer l'application, veuillez suivre ces étapes :

### Prérequis

1. Docker et docker-compose installés sur votre machine
2. PHP installé sur votre machine
3. Composer installé sur votre machine

### Mise en place du serveur
- Pour lancer la base de données lancez : `docker-compose up -d`, un conteneur docker sera créé.
- Pour installer les dépendances lancez la commande : `composer install`
- Pour lancer le serveur PHP lancez : `symfony server:start`
- Afin de créer les tables dans la base de données tapez : `php bin/console doctrine:migrations:migrate`
- Pour charger les fixtures tapez `php bin/console doctrine:fixtures:load`
- L'application est disponible à `http://127.0.0.1:8000/`

## Identification

Par défaut un utilisateur admin est créé :

email : `admin@demo.fr`
mot de passe : `admin`

Ce compte permettra de consulter les commandes et de modifier les catalogues

Pour vous connecter en temps qu'utilisateur final, veuillez créer un compte en acédant à l'application

## PHPCS

CodeSniffer est intégré à l'application pour analyser et nettoyer le code

Pour lancer la correction du code, lancez la commande :`composer phpcs`

## Fonctionnalités
### Pour EuroPlant
L'application permet de gérer de catalogue et d'enregistrer / gérer des commandes sur un même outil

- Ajouter plusieurs catalogues à l'application
- Ajouter des produits ( Nom, descriptif, prix et image ) à un catalogue
- Afficher l'ensemble des commandes et le détail de celles-ci sur un espace sécurisé
- Ajouter une facture à une commande

### Pour le client
L'application permet de parcourir facilement les catalogues d'EuroPlant et de commander des produits, le client a également accès aux factures des commandes

- Naviguer dans les catalogues du fournisseur
- Accès à un espace sécurisé
- Ajouter des produits au panier
- Passer et visualiser une commande
- Télécharger une facture liée à une commande ( si disponible ).

## Fonctionnalités futures

### Gérer l'envoie de mail / sms en fonction des intéractions avec l'application :

Je suggère l'utilisation d'une plateforme marketing AIO du type SendInBlue. La plateforme possède une api facile d'utilisation pour répondre à ce besoin. Des librairies comme [celle-ci](https://github.com/symfony/sendinblue-mailer "celle-ci") peuvent être utilisées

### Permettre aux clients d’intégrer le système de commande dans leur SI

Si le SI d'EuroPlant possède une api il est parfaitement possible de connecter cette application à celle-ci afin de synchroniser les données.

### Paiement en ligne

Je suggère l'utilisation de Stripe et Paypal. Ces deux leaders du paiement en ligne possède des librairies destinées à PHP

### Internationalisation : proposer l’application à des clients allemands et belges

L'application peut parfaitement prendre en charge une traduction vers plusieurs langues, nous pouvons utiliser les fonctionnalités natives de symfony [expliquées ici](https://symfony.com/doc/current/translation.html "expliquées ici")

### Génération automatique des factures
Les factures peuvent être auto-générées par l'application à partir des entrées en BDD, des outils comme https://csv.thephpleague.com/ peuvent simplifier la tâche.

### Formulaires de satisfaction clients

En adéquation avec l'intégration d'une plateforme d'email et SMS, nous pouvons envoyer des formulaires de satisfaction client X jours après le passage d'une commande.