# SnowTricks

> Dépot ouvert originalement lors de mon cursus de développeur backend PHP / Symfony chez OpenClassrooms.  
> Le dernier commit publié lors de mes études : [b739e752ac0556ba73f218b578f42f3b02556101](https://github.com/leomoille/SnowTricks/commit/0e1e231fb126fcc1dbd4259d4e34db4cd59b899f)

Les commits suivants sont des améliorations et mises à jours hors du cadre de mon parcours.

## Prérequis

Pour pouvoir mettre en place SnowTricks vous aurez besoin des outils suivants : 

- PHP 8.2
- Composer
- NodeJS (et npm)
- Symfony CLI
- Docker

## 1 - Installer les dépendances PHP

Depuis un terminal dans le dossier du projet, lancez la commande suivante :

```shell
composer install
```

## 2 - Installation des dépendances JS

Depuis un terminal dans le dossier du projet, lancez la commande suivante :

```shell
npm install
```

## 3 - Démarrer le container Docker

Démarrez le container contenant la base de données, le mail catcher ainsi qu'un phpMyAdmin

```shell
docker compose up -d
```

## 4 - Charger les fixtures

Depuis un terminal dans le dossier du projet, lancez la commande suivante :

```shell
symfony console d:f:l -n
```

## 5 - Build des assets

Depuis un terminal dans le dossier du projet, lancez la commande suivante :

```shell
npm run build
```

## 5 - Démarrer le serveur local

Depuis un terminal dans le dossier du projet, lancez la commande suivante :

```shell
symfony serve -d
```

## 6 - Découvrir SnowTricks !

Une fois le serveur démarré, vous pouvez vous rendre sur [127.0.0.1](http://127.0.0.1) pour naviguer sur le site.

> Par défaut, le serveur écoute sur le port `8000` mais si ce dernier est indisponible le port sera différent. Consultez l'output du terminal pour connaitre le port utilisé.
