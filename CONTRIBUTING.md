# Contribution

Bienvenue et merci de vouloir contribuer sur ce projet.  
Pour commencer votre contribution dans les meilleures conditions, veuillez discuter de votre besoin à travers les [issues](https://github.com/noobgamecontest/versus/issues).

## Écriture du code

1. Nous respectons les [PSR-1](https://www.php-fig.org/psr/psr-1/) et [PSR-12](https://www.php-fig.org/psr/psr-12/)
2. Veilliez à ce que votre code soit tester
3. Afin de faciliter la revue de code, privilégiez des petits développements

## Lancer l'application

Un environnement Docker est disponible pour la phase de développement.  
Voici comment procéder à son installation :

```bash
# Installation
cp .env.example .env
docker-compose up -d

# Installation des dépendances 
docker-compose exec app composer up

# Construction des assets
docker-compose exec app yarn install
docker-compose exec app yarn run dev

# Remise à zero de l'application (bdd, seeds ...)
docker-compose exec make fresh
```

## Schéma de la base de donnée

Voici le schéma de la base de donnée :

![dbdiagram](https://github.com/noobgamecontest/versus/blob/master/art/dbdiagram.png)

## Gitflow

Voici comment les branches sont gérées :

![gitflow](https://github.com/noobgamecontest/versus/blob/master/art/gitflow.png)
