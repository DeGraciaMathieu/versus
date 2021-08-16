## About Versus

Fight !?

### Comment lancer l'environnement de développement ?

```bash
# Installation
cp .env.example .env
docker-compose up -d

# Installation des dépendances 
docker-compose exec app composer up

# Construction des assets
docker-compose exec app yarn install
docker-compose exec app yarn run dev
```
