# Le Rond Point

# C'est quoi le-rondpoint.org ?

Ce site internet met en lumière une mémoire vivante du mouvement des Gilets jaunes, ainsi que ses suites. C’est un outil participatif, nourri par les personnes ayant participé au mouvement ou qui en ont été proches. Ce site rassemble et organise des Traces produites lors du mouvement. Ce sont autant : les doléances qui nous ont été volées, les chansons que nous avons scandées, les tracts et les journaux que nous avons imprimés, les banderoles que nous avons brandies, et tant d’autres choses qui racontent ce mouvement. Toutes ces traces sont dispersées, peu visibles, et vouées à se perdre avec le temps. Rassemblons-les et rendons-les visibles !

# Installation

## Prerequisits

* PHP 8.4 installed globally on the machine (or see .php-version file for updated version)
* Minio installed globally on the machine (`brew install minio` for mac)
* Symfony Cli installed globally on the machine [https://symfony.com/download](https://symfony.com/download)
* Nothing else (SGBD is sqlite)

=======
## Setup

```bash
git clone git@github.com:tcheymol/lerondpoint.git
cd lerondpoint
symfony composer install
```

Setup DB and fixtures
```bash
touch var/data.db
symfony console doctrine:migrations:migrate
symfony console app:enable-app
symfony console app:load-data --all
symfony server:ca:install
symfony server:start -d
```

First App start
```
symfony server:ca:install
symfony server:start -d
```

## Create the bucket
* browse [http://localhost:9000](http://localhost:9000)
* login as minioadmin/minioadmin
* create a bucket named lerondpoint

If wou want you can create an admin user
```bash
symfony console app:create-user user@mail.com password --admin
```

## Now start the app
```bash
symfony server:start -d
symfony console sass:build --watch
```

you can now browse the app at [https://localhost:8000/home](https://localhost:8000/home)

## Tests

Créer la base de données de test et appliquer les migrations :
```bash
touch var/data.test.db
APP_ENV=test symfony console doctrine:migrations:migrate --no-interaction
```

Lancer les tests :
```bash
make test
```

## Deploy
for the deploy script to work, you need to create a `~/.ssh/config` file with a host named `rp`

```bash
Host rp
    HostName {server ip}
    User www-data
```
