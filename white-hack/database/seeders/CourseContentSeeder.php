<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{Course, Module, Lesson};

class CourseContentSeeder extends Seeder
{
    public function run(): void
    {
        /*
         |-----------------------------------------------------------
         | COURS 1 : Réseaux 101 — IP & Routage
         |-----------------------------------------------------------
         */
        $c1 = Course::create([
            'title'        => 'Réseaux 101 : Adressage IP & Routage',
            'slug'         => Str::slug('Réseaux 101 : Adressage IP & Routage'),
            'level'        => 'debutant',
            'duration_min' => 120,
            'description'  => 'IPv4/IPv6, CIDR, NAT/DNS, routage & diagnostic réseau.',
            'is_published' => true,
        ]);

        $c1m1 = $c1->modules()->create(['title' => 'Fondamentaux IP',      'order' => 1]);
        $c1m2 = $c1->modules()->create(['title' => 'Services & Routage',   'order' => 2]);
        $c1m3 = $c1->modules()->create(['title' => 'Pratique & Diagnostic','order' => 3]);

        // C1M1
        $c1m1->lessons()->createMany([
            [
                'title'   => 'Adressage IPv4/IPv6 & CIDR',
                'order'   => 1,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Adressage IPv4/IPv6 & CIDR

## IPv4
- 32 bits (ex. 192.168.10.42)
- CIDR : /24 = 256 adresses (254 utilisables)

**Privées (RFC1918)** : 10.0.0.0/8, 172.16.0.0/12, 192.168.0.0/16

## IPv6
- 128 bits (ex. 2001:db8::1)
- /64 courant en LAN

## Rappels CIDR
- /24 → 256 adr
- /25 → 128 adr
- /30 → 4 adr (liens P2P)

## Exos
- /26 et /27 → combien d’adresses ?
- Réseau & broadcast de 192.168.5.130/25
MD
            ],
            [
                'title'   => 'Subnetting (découpage en sous-réseaux)',
                'order'   => 2,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Subnetting (découpage)

1) Estimer les besoins (hôtes/zone)
2) Choisir un préfixe (ex. /26 = 64 adresses)
3) Plan d’adressage : réseau, 1ʳᵉ IP, dernière IP, broadcast

**Exemple (192.168.10.0/24)**
- Admin (30)  → /27 : .0 – .31
- Étudiants (110) → /25 : .128 – .255
- Infra (14) → /28 : .32 – .47

**Conseils** : garder de la marge, documenter (wiki).
MD
            ],
        ]);

        // C1M2
        $c1m2->lessons()->createMany([
            [
                'title'   => 'NAT, DNS & passerelle',
                'order'   => 1,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# NAT, DNS & passerelle

## NAT
- Masquerade : IP privées → 1 IP publique

## DNS
- Types : A/AAAA, CNAME, PTR, MX, TXT
- Outils : nslookup, dig

## Passerelle (gateway)
- Route par défaut du sous-réseau
- Vérifier : `ip route` / `route print`
MD
            ],
            [
                'title'   => 'Routage & triage d’incidents',
                'order'   => 2,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Routage & Triage

- Routage statique vs dynamique (OSPF/BGP)

**Checklist triage :**
1. IP locale : `ip a` / `ipconfig`
2. Passerelle : `ip route` / `route print`
3. DNS : `nslookup` / `dig`
4. Connectivité : `ping`, `traceroute`/`tracert`
5. Ports : `ss -lntup` / `netstat -ano`
MD
            ],
        ]);

        // C1M3
        $c1m3->lessons()->create([
            'title'   => 'Pratique : ping, traceroute, ss',
            'order'   => 1,
            'is_lab'  => true,
            'markdown'=> <<<'MD'
# TP : diagnostic simple

1. `ping <ip_vm>`
2. `traceroute <ip_vm>` / `tracert`
3. Sur la VM : `ss -lntup` (process/ports)
4. Firewall : `ufw status` / `Get-NetFirewallProfile`

**À rendre** : mini-rapport (symptômes → tests → cause)
MD
        ]);

        /*
         |-----------------------------------------------------------
         | COURS 2 : Nmap — Découverte & Interprétation
         |-----------------------------------------------------------
         */
        $c2 = Course::create([
            'title'        => 'Découverte réseau avec Nmap',
            'slug'         => Str::slug('Découverte réseau avec Nmap'),
            'level'        => 'intermediaire',
            'duration_min' => 120,
            'description'  => 'Méthodologie de scan, détection services/OS, NSE, interprétation & reporting.',
            'is_published' => true,
        ]);

        $c2m1 = $c2->modules()->create(['title' => 'Bases',                      'order' => 1]);
        $c2m2 = $c2->modules()->create(['title' => 'Techniques & Interprétation','order' => 2]);
        $c2m3 = $c2->modules()->create(['title' => 'Pratique & Rapport',         'order' => 3]);

        // C2M1
        $c2m1->lessons()->createMany([
            [
                'title'   => 'Types de scans (ping, TCP, SYN, UDP)',
                'order'   => 1,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Types de scans Nmap

- Découverte : `nmap -sn 10.0.0.0/24`
- TCP connect : `nmap -sT <cible>` (non privilégié)
- SYN (stealth) : `sudo nmap -sS <cible>`
- UDP : `sudo nmap -sU <cible>` (lent)
- Tous ports : `-p-`
- Vitesse : `-T0..5` (défaut `-T3`)
MD
            ],
            [
                'title'   => 'Services/OS & sorties',
                'order'   => 2,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Services/OS & sorties

- Versions : `-sV`
- OS (estimation) : `-O`

**Sorties :**
- lisible (par défaut)
- greppable : `-oG res.grep`
- XML : `-oX res.xml`
- tout : `-oA prefix`

**Exemple :**

sudo nmap -sS -sV -O -p- -T3 -oA scan 10.0.0.50

MD
            ],
        ]);

        // C2M2
        $c2m2->lessons()->createMany([
            [
                'title'   => 'NSE (scripts) & affinement',
                'order'   => 1,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# NSE (Nmap Scripting Engine)

- Catégories sûres : `default,safe`

nmap --script default,safe -sV <cible>

- Ciblé HTTP :

nmap --script http-title,http-headers -p80,443 <cible>

**Attention** : certains scripts peuvent être intrusifs → lab **autorisé** uniquement.
MD
            ],
            [
                'title'   => 'Lire un résultat & prioriser',
                'order'   => 2,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Interprétation & priorisation

- Ports sensibles : 22/3389/445/3306/5432/80/443…
- Associer service + version → pistes de vulnérabilités
- Priorité :
  1) Admin exposés (SSH/RDP)
  2) BDD exposées
  3) Web (énumérations dédiées)
MD
            ],
        ]);

        // C2M3
        $c2m3->lessons()->create([
            'title'   => 'Pratique : stratégie & rapport',
            'order'   => 1,
            'is_lab'  => true,
            'markdown'=> <<<'MD'
# TP Nmap : stratégie & rapport

1. `-sn` pour détecter les hôtes up
2. `-sS -p-` sur une cible
3. `-sV -O` pour le détail
4. `--script default,safe` si pertinent

**À rendre (1 page)** : commandes + résultats clés + risques & contre-mesures
MD
        ]);

        /*
         |-----------------------------------------------------------
         | COURS 3 : Sécurité Web — Injections SQL (éthique)
         |-----------------------------------------------------------
         */
        $c3 = Course::create([
            'title'        => 'Sécurité Web : Injections SQL (éthique)',
            'slug'         => Str::slug('Sécurité Web : Injections SQL (éthique)'),
            'level'        => 'intermediaire',
            'duration_min' => 150,
            'description'  => 'Comprendre, détecter en lab et surtout prévenir les injections SQL.',
            'is_published' => true,
        ]);

        $c3m1 = $c3->modules()->create(['title' => 'Concepts & Risques',   'order' => 1]);
        $c3m2 = $c3->modules()->create(['title' => 'Détection en lab',     'order' => 2]);
        $c3m3 = $c3->modules()->create(['title' => 'Prévention',           'order' => 3]);

        // C3M1
        $c3m1->lessons()->createMany([
            [
                'title'   => 'Rappel SQL & vecteurs',
                'order'   => 1,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Rappel SQL & vecteurs

- SQL : langage d’interaction BDD (SELECT/INSERT/UPDATE/DELETE)
- Injection SQL : entrée non maîtrisée **concaténée** à la requête

**Vecteurs** : formulaires (login/recherche), paramètres d’URL, cookies, API  
**Impacts** : fuite, altération, parfois RCE
MD
            ],
            [
                'title'   => 'Types d’injection',
                'order'   => 2,
                'is_lab'  => false,
                'markdown'=> <<<'MD'
# Types d’injection

- In-band (ex. UNION)
- Blind booléenne (vrai/faux)
- Time-based (latence induite : SLEEP/pg_sleep/WAITFOR)

**Signes** : erreurs SQL, variations de contenu/temps de réponse
MD
            ],
        ]);

        // C3M2
        $c3m2->lessons()->createMany([
            [
                'title'   => 'Détection & validation (lab)',
                'order'   => 1,
                'is_lab'  => true,
                'markdown'=> <<<'MD'
# Détection & validation (lab)

1. Tester des caractères spéciaux : `'` et `"` → erreurs affichées ?
2. Tests booléens : `AND 1=1` vs `AND 1=2`
3. Time-based si rien ne sort : MySQL `SLEEP(3)`, PostgreSQL `pg_sleep(3)`, MSSQL `WAITFOR DELAY '0:0:3'`

📌 Toujours en **lab autorisé** uniquement.
MD
            ],
            [
                'title'   => 'UNION & extraction contrôlée (lab)',
                'order'   => 2,
                'is_lab'  => true,
                'markdown'=> <<<'MD'
# UNION & extraction (lab)

1) Déterminer le nombre de colonnes (ORDER BY / NULL, …)  
2) Faire correspondre les types  
3) Extraction contrôlée : `UNION SELECT 'ok', version(), user()` …

🎯 Objectif pédagogique : comprendre pour **mieux prévenir**.
MD
            ],
        ]);

        // C3M3
        $c3m3->lessons()->create([
            'title'   => 'Prévention (requêtes préparées)',
            'order'   => 1,
            'is_lab'  => false,
            'markdown'=> <<<'MD'
# Prévention (le plus important)

- Requêtes **préparées/paramétrées** (jamais de concaténation)
- Moindre privilège SQL pour l’app
- Journaliser & alerter (patterns anormaux)
- Tester régulièrement (staging/lab)

**Laravel** : Query Builder/Eloquent paramètrent automatiquement les entrées utilisateur.
MD
        ]);
    }
}