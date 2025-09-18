# WhiteHack — Dossier & Plateforme pédagogique (RNCP 36061, N6)

**Projet** : WhiteHack — plateforme pédagogique pour l’apprentissage de la cybersécurité (cours, labs vulnérables, CTF).  
**Auteur** : Staïli Ilyes — B3 Cybersécurité — Ynov Campus — Année 2025

---

## ⚙️ Résumé
WhiteHack est une plateforme web (Laravel) couplée à des environnements pratiques (VM / labs) accessibles via tunnel sécurisé. L’objectif : offrir des parcours progressifs (cours → labs → évaluation) conformes aux compétences RNCP 36061. Le projet inclut une stack complète : application Laravel, reverse-proxy Nginx, orchestration de labs (snapshot/restore), VPN/tunnels pour accès sécurisé, supervision (Prometheus / Grafana) et centralisation des logs (ELK).

---

## ✅ Fonctionnalités principales
- Catalogue de cours (Markdown) et leçons (modules/lessons).
- Dashboard de progression, badges, scores CTF.
- Module « Practice » : accès sécurisé aux machines vulnérables (NoVNC / Guacamole ou tunnel).
- Orchestration : démarrage/clone/rollback des VMs labs depuis images/snapshots.
- Authentification + rôles (Étudiant / Mentor / Admin).
- Supervision : Prometheus (metrics) + Grafana (dashboards).
- Centralisation des logs : ELK (Elasticsearch / Logstash / Kibana).
- RGPD : minimisation des données et rétention configurable.

---

## Architecture (haut niveau)
Utilisateur (navigateur)  
    └─ HTTPS → Nginx (reverse-proxy) ──> Laravel (auth, orchestration)  
                          │  
                          ├─ NoVNC / Guacamole (GUI web pour VMs)  
                          ├─ WireGuard / OpenVPN (optionnel pour accès réseau)  
                          └─ Orchestrator (libvirt / LXC / Docker) → VM lab (snapshot)  

Supervision: Prometheus (node_exporter) → Grafana  
Logs: Nginx / Laravel → Logstash → Elasticsearch → Kibana  

---

## Installation (développement / démonstration locale)

### Prérequis
- PHP ≥ 8.x, Composer  
- Node.js / npm (pour assets)  
- Nginx  
- MySQL / MariaDB (ou SQLite pour MVP)  
- Git  
- (Optionnel) libvirt/docker pour labs  

### Étapes
```bash
# cloner
git clone <repo> whitehack
cd whitehack

# copier .env (exemple)
cp .env.example .env

# installer dépendances PHP
composer install --no-dev --prefer-dist

# clé app
php artisan key:generate

# config / cache (dev)
php artisan migrate --force
php artisan db:seed --class=CourseContentSeeder

# assets
npm install
npm run dev

# lancer serveur
php artisan serve --host=127.0.0.1 --port=8000
```

---

## Exemple .env (extraits)
APP_NAME=WhiteHack  
APP_ENV=local  
APP_KEY=base64:...  
APP_URL=http://localhost:8000  

DB_CONNECTION=sqlite  
DB_DATABASE=/full/path/database.sqlite  

---

## Seeder : ajouter / modifier des leçons
- Le seeder principal : `database/seeders/CourseContentSeeder.php`.  
- Les leçons sont ajoutées via `createMany([...])` avec `title`, `order`, `is_lab`, `markdown`.  

Commande utile :
```bash
php artisan migrate:fresh --seed --seeder=CourseContentSeeder
```

---

## Déploiement — Raspberry Pi (MVP)
1. Installer dépendances (nginx, php-fpm, sqlite, git, composer).  
2. Cloner repo et setup `.env`.  
3. Configurer Nginx (reverse-proxy + SSL).  
4. Activer ufw (firewall) + fail2ban.  

---

## VPN & accès aux labs
### WireGuard / OpenVPN
- Fournit accès réseau sécurisé aux VM.  
- Profil généré automatiquement, distribué à l’étudiant.  

### NoVNC / Guacamole
- L’étudiant clique « Se connecter » → ouverture d’une session graphique dans le navigateur.  
- Avantage : zéro configuration côté étudiant.  

---

## Supervision & logs
- **Prometheus** : collecte métriques.  
- **Grafana** : dashboards et alertes.  
- **ELK** : centralisation et analyse des logs.  

---

## Sécurité
- HTTPS (TLS avec Nginx + certbot).  
- UFW (pare-feu) : règles strictes.  
- Fail2ban : blocage IP après bruteforce.  
- Séparation des rôles / données minimisées (RGPD).  

---

## Workflow utilisateur
- Étudiant : choisit cours → lance lab → accès sécurisé GUI/VPN → pratique → reset VM (snapshot).  
- Mentor : crée cours et valide contenus.  
- Admin : supervise, sauvegarde, gère sécurité.  

---

## Sauvegardes
- Dumps réguliers DB (sqlite ou mysql).  
- Snapshots VM.  
- Tests de restauration périodiques.  

---

## Git & pratiques
- Branches : `main`, `develop`, `feat/*`.  
- Workflow : feature → PR → merge.  

Commandes utiles :
```bash
git log --oneline --graph --decorate --all
```

---

## Dépannage
- **500** : logs Laravel.  
- **Migrations** : vérifier DB.  
- **NoVNC** : vérifier proxypass WebSocket.  
- **VPN** : vérifier clé publique/privée.  

---



