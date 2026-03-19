# FolioLara

Portfolio Laravel avec vitrine animée, dashboard TailAdmin, rôles superadmin/user, workflow de soumission de projets et formulaire de contact par email.

## Fonctionnalités

- Vitrine portfolio avec animations GSAP
- Dashboard TailAdmin adapté au design public
- Deux rôles: superadmin et user
- Soumission de projets par les utilisateurs connectés
- Validation, rejet et suivi de progression par le superadmin
- Formulaire de contact avec envoi d'email
- Filtrage des projets approuvés sur la vitrine

## Stack

- Laravel 10
- PHP 8.1+
- Blade
- Tailwind CSS
- Vite
- SQLite en configuration Render actuelle
- MySQL possible pour hébergement mutualisé

## Installation locale

```bash
composer install
npm install
copy .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

## Comptes et rôles

- Le premier utilisateur peut être défini comme superadmin
- Les nouveaux inscrits sont créés avec le rôle user
- Le superadmin valide les projets et met à jour leur progression dans le dashboard

## Déploiement

Le guide complet est dans [DEPLOYMENT.md](DEPLOYMENT.md).

Résumé rapide:

- Meilleur gratuit simple pour projets statiques: GitHub Pages
- Meilleur gratuit permanent pour Laravel étudiant/portfolio avec MySQL: InfinityFree
- Plus simple pour déployer vite avec Docker: Render
- 000WebHost n'est plus une vraie option gratuite autonome
- GoogieHost reste un plan B, mais moins fiable que InfinityFree

## État actuel des liens publics audités

- OK: PapiGPT
- OK: Quiz App
- OK: TestImo
- OK: Star Group
- OK: To-Do List
- KO/à redéployer: MonTerrain, GStockBoncoin, SignalementUrbain, SunuTontine, GestionSalaire, portfolio principal cheikhkeinde.onrender.com

## Points importants avant production

- Configurer les variables MAIL_* dans l'environnement cible
- Vérifier APP_URL
- Lancer les migrations sur la base cible
- Pour Render en SQLite, les données sont fragiles lors des redéploiements
- Pour un vrai usage formulaire + dashboard + projets, préférer une base MySQL persistante
