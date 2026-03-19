# Déploiement

## Recommandation directe

Pour ce projet précis, le meilleur choix gratuit est:

1. InfinityFree pour cette app Laravel si tu veux du PHP + MySQL gratuit et persistant
2. Render si tu veux le déploiement le plus simple, mais avec une vraie base externe si tu veux conserver les données
3. GoogieHost seulement en secours
4. 000WebHost à éviter: le service redirige désormais vers Hostinger et n'est plus une vraie option gratuite autonome

## Pourquoi ce choix

Cette application a besoin de:

- PHP
- base de données
- formulaires
- authentification
- dashboard utilisateur/admin
- emails

Donc GitHub Pages ne convient pas pour le projet Laravel lui-même. En revanche, GitHub Pages reste parfait pour tes projets purement front comme Quiz App ou To-Do List.

## Audit des déploiements existants

Audit HTTP fait depuis le workspace.

### Déploiements OK

- 200: https://papigpt.onrender.com
- 200: https://pkeinde6.github.io/quiz-app
- 200: https://testimo.onrender.com
- 200: https://star-groupe.com
- 200: https://pkeinde6.github.io/todo-list/

### Déploiements KO ou à relancer

- 503: https://monterrain.onrender.com
- 404: https://gstockboncoin.onrender.com
- 404: https://signalementurbain.onrender.com
- 404: https://sunutontine.onrender.com
- 404: https://gestionsalaire.onrender.com
- 404: https://cheikhkeinde.onrender.com

## Choix par type de projet

### Projets statiques

À garder sur GitHub Pages:

- Quiz App
- To-Do List

### Projets Laravel/PHP dynamiques

À mettre sur InfinityFree si tu veux rester totalement gratuit:

- FolioLara
- GStockBoncoin
- SignalementUrbain
- SunuTontine
- GestionSalaire

### Projets déjà en Render mais cassés

À redéployer en priorité:

- MonTerrain
- Portfolio principal

Si tu veux aller vite sans tout migrer, tu peux aussi republier ces projets sur Render.

## Verdict sur les hébergeurs cités

### 000WebHost

- Mauvais choix aujourd'hui
- Le site redirige vers Hostinger
- Donc ce n'est plus la meilleure piste pour ton besoin gratuit

### GoogieHost

- Peut dépanner
- Gratuit et sous-domaine disponible
- Mais généralement moins stable et moins fluide qu'InfinityFree
- Je ne le choisirais pas en première option pour plusieurs projets Laravel

### InfinityFree

- Meilleur choix gratuit permanent parmi les options citées
- PHP 8.3
- MySQL/MariaDB inclus
- SSL gratuit
- Sous-domaine gratuit
- .htaccess supporté
- En contrepartie: installation Laravel plus manuelle

## Recommandation finale

### Pour ce portfolio Laravel

Le meilleur compromis est:

- InfinityFree si tu veux zéro coût récurrent et une base MySQL persistante
- Render si tu veux la mise en ligne la plus simple, mais avec une base externe sérieuse ensuite

### Pour tes autres projets

- GitHub Pages pour les projets front purs
- InfinityFree pour les projets Laravel/PHP étudiants
- Render pour les projets à démonstration rapide ou si tu veux Docker + déploiement simple

## Déploiement Render

Ce repo contient déjà un [Dockerfile](Dockerfile) et un [.env.render](.env.render).

### Avantages

- Déploiement rapide
- Build propre
- Très pratique pour des démos

### Limite actuelle

La configuration actuelle repose sur SQLite. En environnement gratuit, ça n'est pas idéal pour conserver durablement les données de dashboard, validation et progression.

### Étapes

1. Créer un nouveau Web Service sur Render depuis le repo GitHub
2. Choisir Docker
3. Définir les variables d'environnement:

```env
APP_NAME=FolioLara
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ton-app.onrender.com
MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME=FolioLara
```

4. Déployer

### Important

Si tu veux garder les projets soumis par les users, remplace SQLite par une base externe persistante.

## Déploiement InfinityFree

### Pourquoi c'est mon choix gratuit conseillé ici

- PHP + MySQL
- données persistantes
- adapté à un projet Laravel étudiant/portfolio

### Préparation du projet

Avant upload:

1. En local:

```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

2. Créer la base MySQL depuis InfinityFree
3. Mettre à jour le .env avec les identifiants MySQL

Exemple:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ton-sous-domaine.infinityfreeapp.com

DB_CONNECTION=mysql
DB_HOST=sqlXXX.infinityfree.com
DB_PORT=3306
DB_DATABASE=if0_xxxxxxxx
DB_USERNAME=if0_xxxxxxxx
DB_PASSWORD=ton_mot_de_passe

SESSION_DRIVER=file
CACHE_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=...
MAIL_PORT=587
MAIL_USERNAME=...
MAIL_PASSWORD=...
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME=FolioLara
```

### Structure à publier

Sur hébergement mutualisé, il faut généralement:

- placer le contenu de public/ dans htdocs/
- placer le reste du projet au-dessus de htdocs/
- adapter index.php pour pointer sur les bons chemins si nécessaire

### Puis lancer

Si le terminal SSH est disponible:

```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Si InfinityFree ne permet pas toutes ces commandes directement, il faudra préparer le projet en local puis uploader la version déjà buildée.

## GoogieHost

À utiliser si:

- InfinityFree te bloque sur un quota ou un compte
- tu veux juste une démo temporaire

Mais pour un portfolio Laravel avec utilisateurs et suivi de projets, je le place derrière InfinityFree.

## Ce que je ne peux pas faire sans toi

Je ne peux pas publier réellement sur Render, InfinityFree ou GoogieHost sans:

- accès au compte
- repo distant si nécessaire
- variables d'environnement réelles
- domaine ou sous-domaine choisi

## Ce que je te recommande maintenant

1. Déployer ce portfolio sur InfinityFree si tu veux du gratuit durable
2. Réactiver rapidement les apps cassées sur Render si tu veux juste remettre les démos en ligne vite
3. Garder Quiz App et To-Do List sur GitHub Pages
4. Migrer progressivement les autres Laravel cassés vers InfinityFree si tu veux tout centraliser gratuitement
