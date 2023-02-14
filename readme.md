# SnowTricks

## Prérequis
Pour pouvoir mettre en place SnowTricks vous aurez besoin des outils suivants : 
- PHP 7.4
- Composer
- NodeJS (et npm)
- Un mail catcher (comme [MailHog](https://github.com/mailhog/MailHog) par exemple)

## 1 - Installer les dépendances
Depuis un terminal dans le dossier du projet, lancez la commande suivante :

```shell
$ composer install
```

## 2 - Connecter la base de données
Une fois `composer install` lancé, éditez le fichier `.env` pour y ajouter la configuration à la base de données.
> Par défaut, le fichier `.env` est configuré pour *MySQL* avec l'utilisateur *root* sans mot de passe. La base de données sera nommée *snowtricks*.
```dotenv
DATABASE_URL="mysql://root:@localhost:3306/snowtricks"
```

## 3 - Configurer la base de données
Une fois le fichier `.env` configuré, lancez la commande suivante pour initialiser la base de données :
```shell
$ php bin/console doctrine:database:create
```

Maintenant que la base de données est créée, vous pouvez lancer les fixtures :
```shell
$ php bin/console doctrine:fixtures:load
```

## 4 - Lancer le serveur
Vous pouvez maintenant lancer la commande suivante pour mettre en place le CSS et le Javascript : 

```shell
$ npm run build
```

Puis le serveur Web de *Symfony* : 

```shell
$ php bin/console server:start
```

## 5 - Découvrir SnowTricks !

Une fois le serveur lancé, vous pouvez vous rendre sur [127.0.0.1](http://127.0.0.1) pour naviguer sur le site.

## Autres points
Il est possible que vous ayez à configurer un *mail catcher* pour recevoir les mails d'activations de comptes ou de modification de mot de passe.
Vous pouvez configurer les paramètres du mailer dans le fichier `.env` :
```dotenv
MAILER_DSN=smtp://localhost:1025
```