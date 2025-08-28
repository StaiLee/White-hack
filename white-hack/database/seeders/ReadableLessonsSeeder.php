<?php
// database/seeders/ReadableLessonsSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Course, Module, Lesson};

class ReadableLessonsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $this->seedReseaux101();
            $this->seedNmap();
        });
    }

    private function seedReseaux101(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'reseaux-101-adressage-ip-routage'],
            [
                'title'        => 'Réseaux 101 : Adressage IP & Routage',
                'description'  => 'Comprendre l’adressage IPv4/IPv6, le CIDR, le subnetting et les bases du routage/dépannage.',
                'level'        => 'debutant',
                'duration_min' => 180,
                'is_published' => true,
            ]
        );

        // Réinitialiser le contenu du cours
        $course->modules()->delete();

        // Module 1 — IPv4 & CIDR
        $m1 = $course->modules()->create([
            'title' => 'IPv4, CIDR & Subnetting',
            'order' => 1,
        ]);

        $m1->lessons()->createMany([
            [
                'title'    => 'Adressage IPv4 : bases incontournables',
                'order'    => 1,
                'is_lab'   => false,
                'markdown' => <<<'TXT'
Objectifs
- Comprendre la structure d’une adresse IPv4.
- Distinguer réseau, hôte et masque.
- Lire un préfixe CIDR.

IPv4 en bref
- 32 bits notés en 4 octets : A.B.C.D (exemple 192.168.1.10).
- Masque : indique combien de bits forment la partie réseau.
  Exemple /24 = 255.255.255.0 → 24 bits réseau, 8 bits hôte.
- CIDR : /8, /16, /24 sont fréquents, mais tout 0–32 est possible.

Réseau, broadcast, plage d’hôtes (exemple 192.168.1.10/24)
- Réseau : 192.168.1.0
- Broadcast : 192.168.1.255
- Hôtes valides : 192.168.1.1 à 192.168.1.254 (254 hôtes)

Subnetting rapide (méthode pratique)
- Nombre d’hôtes requis → choisir un préfixe qui couvre ce besoin.
- Mémo hôtes utilisables ≈ 2^(bits_hôtes) - 2.
- Besoin 30 hôtes → /27 (32 adresses, 30 utilisables).

Aperçu IPv6
- 128 bits, notation hexadécimale : 2001:db8::1.
- Pas de broadcast ; autoconfiguration fréquente (SLAAC).

Commandes utiles
- ip a
- ipcalc 192.168.1.10/24 (nécessite ipcalc)
TXT
            ],
            [
                'title'    => 'Exercices guidés de subnetting',
                'order'    => 2,
                'is_lab'   => true,
                'markdown' => <<<'TXT'
Étapes
1) Calcule réseau, broadcast et plage d’hôtes pour :
   - 10.0.0.0/26
   - 172.16.5.100/20
2) Justifie le préfixe minimal pour 500 hôtes sur un même VLAN.
3) Vérifie avec ipcalc.

Astuces mémo
- /25 = 126 hôtes ; /26 = 62 ; /27 = 30 ; /28 = 14 ; /29 = 6 ; /30 = 2.
- Pense en puissances de 2.
TXT
            ],
        ]);

        // Module 2 — Routage & dépannage
        $m2 = $course->modules()->create([
            'title' => 'Routage, DNS & Dépannage',
            'order' => 2,
        ]);

        $m2->lessons()->createMany([
            [
                'title'    => 'Passerelles, ARP, DNS & table de routage',
                'order'    => 1,
                'is_lab'   => false,
                'markdown' => <<<'TXT'
Concepts clés
- Passerelle (gateway) : route par défaut vers l’extérieur du réseau local.
- ARP : résolution IP → MAC sur le LAN.
- DNS : résolution nom de domaine → adresse IP.
- Table de routage : ensemble des routes et interfaces utilisées.

Diagnostiquer vite
- ip route (vérifier la route par défaut)
- ip neigh (cache ARP)
- resolvectl status (ou consulter /etc/resolv.conf)
- ping -c 3 1.1.1.1 (connectivité Internet)
- ping -c 3 google.com (résolution DNS)
- traceroute 8.8.8.8 (chemin jusqu’à la cible)

Cas pratiques
- Pas d’Internet : vérifier ip a, ip route, ping de la gateway, puis DNS.
- Un nom ne résout pas : dig +short nom @1.1.1.1, tester un DNS alternatif.
TXT
            ],
            [
                'title'    => 'TP : diagnostiquer une panne réseau',
                'order'    => 2,
                'is_lab'   => true,
                'markdown' => <<<'TXT'
Scénario
Une VM n’accède pas au web. À toi de localiser la panne.

Checklist
1) ip a : IP correcte ?
2) ip route : une default via existe ?
3) ping <gateway> : la passerelle répond ?
4) ping 1.1.1.1 : accès Internet ok ?
5) dig +short example.com @1.1.1.1 : DNS ok ?

Attendu
- Un mini compte-rendu (5–10 lignes) indiquant où est la panne et pourquoi.
TXT
            ],
        ]);
    }

    private function seedNmap(): void
    {
        $course = Course::firstOrCreate(
            ['slug' => 'decouverte-reseau-avec-nmap'],
            [
                'title'        => 'Découverte Réseau avec Nmap',
                'description'  => 'Cartographier un réseau éthique : découverte d’hôtes, scans de ports, détection services/OS et scripts NSE.',
                'level'        => 'intermediaire',
                'duration_min' => 180,
                'is_published' => true,
            ]
        );

        // Réinitialiser le contenu du cours
        $course->modules()->delete();

        // Module 1 — Bases & découverte
        $m1 = $course->modules()->create([
            'title' => 'Bases, découverte d’hôtes & syntaxe',
            'order' => 1,
        ]);

        $m1->lessons()->createMany([
            [
                'title'    => 'Nmap : principes & éthique',
                'order'    => 1,
                'is_lab'   => false,
                'markdown' => <<<'TXT'
Éthique
- Toujours scanner uniquement des systèmes ou segments autorisés.

Pourquoi Nmap ?
- Dresser une cartographie rapide : qui répond ? quels ports ? quels services ?
- Ajuster l’agressivité (rapide vs complet) selon le contexte.

Syntaxe de base (rappels textuels)
- nmap <cible> : ports TCP fréquents.
- nmap -p- <cible> : tous les ports TCP.
- nmap -sV <cible> : détection de versions.
- nmap -O <cible> : détection approximative d’OS.
- nmap -A <cible> : sV + O + scripts par défaut (plus intrusif).

Découverte d’hôtes (ping sweep)
- nmap -sn 192.168.1.0/24
- Utilise ICMP/ARP (selon le lien) pour lister les IP actives.
TXT
            ],
            [
                'title'    => 'Lab : trouver les machines actives',
                'order'    => 2,
                'is_lab'   => true,
                'markdown' => <<<'TXT'
Objectif
- Lister les hôtes actifs et sélectionner des cibles pour des scans détaillés.

Étapes
1) nmap -sn 192.168.1.0/24
2) Repérer deux IP actives.
3) Valider avec ping -c 2 <ip>.

Restitution
- Liste des IP vues et latence moyenne (si pertinente).
TXT
            ],
        ]);

        // Module 2 — Scans utiles & NSE
        $m2 = $course->modules()->create([
            'title' => 'Scans efficaces, interprétation & NSE',
            'order' => 2,
        ]);

        $m2->lessons()->createMany([
            [
                'title'    => 'TCP SYN, UDP & détection de services',
                'order'    => 1,
                'is_lab'   => false,
                'markdown' => <<<'TXT'
Choisir son scan
- -sS (SYN) : rapide et fiable, par défaut en root.
- -sT (TCP connect) : sans root, plus lent.
- -sU (UDP) : long ; cibler des ports probables (53, 67, 123, 161, 500…).

Exemples
- sudo nmap -sS -p- <ip> : balayage TCP complet.
- sudo nmap -sU -p 53,67,123 <ip> : UDP ciblé.
- nmap -sV -p 22,80,443 <ip> : versions de service.
- nmap -O <ip> : détection d’OS (à recouper).

Lire les résultats
- Port open, filtered, closed. Adapter les suites (bannières, tests autorisés).
TXT
            ],
            [
                'title'    => 'Scripts NSE incontournables (éthique)',
                'order'    => 2,
                'is_lab'   => false,
                'markdown' => <<<'TXT'
NSE (Nmap Scripting Engine)
- Scripts en Lua pour enrichir la détection.
- Catégories : safe, default, auth, vuln, etc.

Exemples utiles (en zone de lab autorisée)
- nmap --script help
- nmap --script "default,safe" <ip>
- nmap --script http-title -p80 <ip>
- nmap --script ssh2-enum-algos -p22 <ip>

Conseil
- Rester sur safe/default si tu veux éviter l’intrusif.
TXT
            ],
            [
                'title'    => 'Lab : scan raisonné et mini-rapport',
                'order'    => 3,
                'is_lab'   => true,
                'markdown' => <<<'TXT'
Objectif
- Produire un mini-rapport lisible à partir d’un scan raisonné.

Étapes
1) Découverte : nmap -sn 192.168.1.0/24
2) Choisir une IP → sudo nmap -sS -p- <ip>
3) Affiner : nmap -sV -p <ports_ouverts> <ip>
4) Option : nmap --script default,safe -p <ports> <ip>

Restitution (10–15 lignes)
- Cible, ports principaux, services/versions probables.
- Interprétation prudente (pas de certitude OS).
- Idées de tests complémentaires autorisés.
TXT
            ],
        ]);
    }
}
