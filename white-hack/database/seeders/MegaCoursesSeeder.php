<?php
// database/seeders/MegaCoursesSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Course, Module, Lesson};

class MegaCoursesSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            foreach ($this->courses() as $def) {
                $this->createCourseWithContent($def);
            }
        });
    }

    /**
     * Définition de 15 nouveaux cours (5 par difficulté).
     * Chaque cours : 2 modules × 2 leçons + 2 labs = 4 leçons.
     */
    private function courses(): array
    {
        return [
            /* ===================== DÉBUTANT ===================== */
            [
                'slug' => 'linux-bases-secours',
                'title' => 'Linux pour la sécu : bases indispensables',
                'level' => 'debutant',
                'duration_min' => 180,
                'description' => 'Commandes essentielles, permissions, processus et diagnostic réseau pour démarrer côté sécurité.',
                'm1' => [
                    'title' => 'Système & Permissions',
                    'lessons' => [
                        [
                            'title' => 'Fichiers, droits & sudo',
                            'lab' => false,
                            'md' => $this->mdLinuxPerms(),
                        ],
                        [
                            'title' => 'LAB : maîtriser chmod/chown et sudoers',
                            'lab' => true,
                            'md' => $this->labLinuxPerms(),
                        ],
                    ],
                ],
                'm2' => [
                    'title' => 'Réseau local & outils',
                    'lessons' => [
                        [
                            'title' => 'IP, ARP, DNS & outils de base',
                            'lab' => false,
                            'md' => $this->mdLinuxNet(),
                        ],
                        [
                            'title' => 'LAB : diagnostiquer une panne réseau',
                            'lab' => true,
                            'md' => $this->labLinuxNet(),
                        ],
                    ],
                ],
            ],
            [
                'slug' => 'tcp-udp-introduction',
                'title' => 'TCP/UDP : Introduction pratique',
                'level' => 'debutant',
                'duration_min' => 150,
                'description' => 'Comprendre les bases de TCP/UDP et savoir lire des échanges simples.',
                'm1' => [
                    'title' => 'Notions & modèles',
                    'lessons' => [
                        ['title'=>'Modèle TCP/IP vs OSI – où se situent TCP & UDP','lab'=>false,'md'=>$this->mdTcpUdpModel()],
                        ['title'=>'LAB : établir et casser une connexion TCP','lab'=>true,'md'=>$this->labTcpUdpConn()],
                    ],
                ],
                'm2' => [
                    'title' => 'Outils de terrain',
                    'lessons' => [
                        ['title'=>'netcat/socat : swiss-army knife du réseau','lab'=>false,'md'=>$this->mdNcSocat()],
                        ['title'=>'LAB : echo-serveur & port-forward','lab'=>true,'md'=>$this->labNcSocat()],
                    ],
                ],
            ],
            [
                'slug' => 'http-essentiels',
                'title' => 'HTTP Essentiels pour pentesters',
                'level' => 'debutant',
                'duration_min' => 160,
                'description' => 'Requêtes, réponses, en-têtes, cookies, sessions, et bonnes pratiques.',
                'm1' => [
                    'title' => 'Comprendre HTTP',
                    'lessons' => [
                        ['title'=>'Méthodes & codes de statut','lab'=>false,'md'=>$this->mdHttpBasics()],
                        ['title'=>'LAB : manipuler requêtes avec curl','lab'=>true,'md'=>$this->labHttpCurl()],
                    ],
                ],
                'm2' => [
                    'title' => 'Sessions & cookies',
                    'lessons' => [
                        ['title'=>'Cookies, sessions, CSRF','lab'=>false,'md'=>$this->mdHttpCookies()],
                        ['title'=>'LAB : fixer et lire un cookie','lab'=>true,'md'=>$this->labHttpCookies()],
                    ],
                ],
            ],
            [
                'slug' => 'shell-scripting-debut',
                'title' => 'Shell & Scripting : premiers pas',
                'level' => 'debutant',
                'duration_min' => 170,
                'description' => 'Automatiser les tâches fréquentes en bash : variables, boucles, pipes.',
                'm1' => [
                    'title' => 'Bases du shell',
                    'lessons' => [
                        ['title'=>'Variables, pipes & redirections','lab'=>false,'md'=>$this->mdShellBasics()],
                        ['title'=>'LAB : mini-pipeline de traitement','lab'=>true,'md'=>$this->labShellBasics()],
                    ],
                ],
                'm2' => [
                    'title' => 'Scripts sûrs',
                    'lessons' => [
                        ['title'=>'Bonnes pratiques & pièges','lab'=>false,'md'=>$this->mdShellSafety()],
                        ['title'=>'LAB : script d’audit local','lab'=>true,'md'=>$this->labShellSafety()],
                    ],
                ],
            ],
            [
                'slug' => 'dns-intro-defense',
                'title' => 'DNS : notions utiles & hygiène défensive',
                'level' => 'debutant',
                'duration_min' => 140,
                'description' => 'Résolution de noms, zones, tests de base et points durs pour l’ops.',
                'm1' => [
                    'title' => 'Le système de noms',
                    'lessons' => [
                        ['title'=>'A/AAAA, CNAME, NS, MX…','lab'=>false,'md'=>$this->mdDnsBasics()],
                        ['title'=>'LAB : diagnostiquer une résolution','lab'=>true,'md'=>$this->labDnsBasics()],
                    ],
                ],
                'm2' => [
                    'title' => 'Sécurité & hygiène',
                    'lessons' => [
                        ['title'=>'Cache, empoisonnement & protections','lab'=>false,'md'=>$this->mdDnsSec()],
                        ['title'=>'LAB : serveurs publics alternatifs','lab'=>true,'md'=>$this->labDnsSec()],
                    ],
                ],
            ],

            /* ===================== INTERMÉDIAIRE ===================== */
            [
                'slug' => 'wireshark-analyse',
                'title' => 'Analyse réseau avec Wireshark',
                'level' => 'intermediaire',
                'duration_min' => 180,
                'description' => 'Filtres, suivis de flux, profils, exports et lecture efficace des captures.',
                'm1' => [
                    'title' => 'Lire vite & bien',
                    'lessons' => [
                        ['title'=>'Filtres BPF & display filters','lab'=>false,'md'=>$this->mdWshFilters()],
                        ['title'=>'LAB : extraire un téléchargement','lab'=>true,'md'=>$this->labWshFiles()],
                    ],
                ],
                'm2' => [
                    'title' => 'Investigation',
                    'lessons' => [
                        ['title'=>'TLS, HTTP/2 & QUIC : indices utiles','lab'=>false,'md'=>$this->mdWshProto()],
                        ['title'=>'LAB : scénarios de compromission','lab'=>true,'md'=>$this->labWshIoc()],
                    ],
                ],
            ],
            [
                'slug' => 'owasp-web-fondamentaux',
                'title' => 'Sécurité Web : fondamentaux OWASP',
                'level' => 'intermediaire',
                'duration_min' => 210,
                'description' => 'Modèle menace, XSS/CSRF/IDOR, auth & sessions, input validation.',
                'm1' => [
                    'title' => 'Surface & menaces',
                    'lessons' => [
                        ['title'=>'Top 10 moderne en pratique','lab'=>false,'md'=>$this->mdOwaspTop()],
                        ['title'=>'LAB : traquer une IDOR','lab'=>true,'md'=>$this->labOwaspIdor()],
                    ],
                ],
                'm2' => [
                    'title' => 'Durcir & vérifier',
                    'lessons' => [
                        ['title'=>'Headers de sécurité & CSP','lab'=>false,'md'=>$this->mdOwaspHeaders()],
                        ['title'=>'LAB : bâtir une règle CSP','lab'=>true,'md'=>$this->labOwaspCsp()],
                    ],
                ],
            ],
            [
                'slug' => 'windows-ad-introduction',
                'title' => 'Windows & Active Directory : introduction',
                'level' => 'intermediaire',
                'duration_min' => 200,
                'description' => 'Objets AD, authentification, GPO, repères d’attaque et journalisation.',
                'm1' => [
                    'title' => 'Architecture & Auth',
                    'lessons' => [
                        ['title'=>'Kerberos/NTLM et tickets','lab'=>false,'md'=>$this->mdAdAuth()],
                        ['title'=>'LAB : parcourir un domaine','lab'=>true,'md'=>$this->labAdEnum()],
                    ],
                ],
                'm2' => [
                    'title' => 'Administration & logs',
                    'lessons' => [
                        ['title'=>'GPO & surfaces sensibles','lab'=>false,'md'=>$this->mdAdGpo()],
                        ['title'=>'LAB : recherche d’événements clés','lab'=>true,'md'=>$this->labAdLogs()],
                    ],
                ],
            ],
            [
                'slug' => 'docker-k8s-securite-intro',
                'title' => 'Sécurité Containers & Kubernetes : intro',
                'level' => 'intermediaire',
                'duration_min' => 190,
                'description' => 'Isolation, images, secrets, namespaces et points de vigilance DevSecOps.',
                'm1' => [
                    'title' => 'Docker côté sécu',
                    'lessons' => [
                        ['title'=>'Images, users, capabilities','lab'=>false,'md'=>$this->mdDockerBasics()],
                        ['title'=>'LAB : scanner une image','lab'=>true,'md'=>$this->labDockerScan()],
                    ],
                ],
                'm2' => [
                    'title' => 'Kubernetes & secrets',
                    'lessons' => [
                        ['title'=>'RBAC, namespaces & policies','lab'=>false,'md'=>$this->mdK8sRbac()],
                        ['title'=>'LAB : limiter les privilèges','lab'=>true,'md'=>$this->labK8sPolicies()],
                    ],
                ],
            ],
            [
                'slug' => 'logging-siem-pratique',
                'title' => 'Collecte & SIEM : pipeline pratique',
                'level' => 'intermediaire',
                'duration_min' => 180,
                'description' => 'Du log brut à la détection : normalisation, règles et tableaux de bord.',
                'm1' => [
                    'title' => 'Pipeline & normalisation',
                    'lessons' => [
                        ['title'=>'Formats, enrichissement, ECS','lab'=>false,'md'=>$this->mdSiemPipeline()],
                        ['title'=>'LAB : parser un log nginx','lab'=>true,'md'=>$this->labSiemParse()],
                    ],
                ],
                'm2' => [
                    'title' => 'Règles & détection',
                    'lessons' => [
                        ['title'=>'Détection IOC/IOA & faux positifs','lab'=>false,'md'=>$this->mdSiemRules()],
                        ['title'=>'LAB : construire une alerte','lab'=>true,'md'=>$this->labSiemAlert()],
                    ],
                ],
            ],

            /* ===================== AVANCÉ ===================== */
            [
                'slug' => 'redteam-ops-bases',
                'title' => 'Red Team Ops : bases opérationnelles',
                'level' => 'avance',
                'duration_min' => 240,
                'description' => 'Plan, opsec, C2, phase de préparation et exécution contrôlée.',
                'm1' => [
                    'title' => 'Préparation & OpSec',
                    'lessons' => [
                        ['title'=>'Modèle d’adversaire & OPORD','lab'=>false,'md'=>$this->mdRtoOpsec()],
                        ['title'=>'LAB : plan d’opération minimal','lab'=>true,'md'=>$this->labRtoPlan()],
                    ],
                ],
                'm2' => [
                    'title' => 'Implants & C2',
                    'lessons' => [
                        ['title'=>'Staging, beacons & canaux','lab'=>false,'md'=>$this->mdRtoC2()],
                        ['title'=>'LAB : concevoir un profil réseau','lab'=>true,'md'=>$this->labRtoProfile()],
                    ],
                ],
            ],
            [
                'slug' => 'aws-securite-avance',
                'title' => 'AWS Sécurité : principes avancés',
                'level' => 'avance',
                'duration_min' => 220,
                'description' => 'IAM, segmentation, chiffrement, détection et remédiation automatisée.',
                'm1' => [
                    'title' => 'Contrôles & identité',
                    'lessons' => [
                        ['title'=>'IAM, SCP, organisations','lab'=>false,'md'=>$this->mdAwsIam()],
                        ['title'=>'LAB : durcir une policy IAM','lab'=>true,'md'=>$this->labAwsIam()],
                    ],
                ],
                'm2' => [
                    'title' => 'Détection & réponse',
                    'lessons' => [
                        ['title'=>'CloudTrail/Config/GuardDuty','lab'=>false,'md'=>$this->mdAwsDetect()],
                        ['title'=>'LAB : réponse pilotée par events','lab'=>true,'md'=>$this->labAwsRespond()],
                    ],
                ],
            ],
            [
                'slug' => 'reverse-engineering-intro',
                'title' => 'Reverse Engineering : première approche',
                'level' => 'avance',
                'duration_min' => 230,
                'description' => 'Architecture, outils, patterns, anti-debug/anti-VM et signatures.',
                'm1' => [
                    'title' => 'Lire un binaire',
                    'lessons' => [
                        ['title'=>'Sections, symboles & strings','lab'=>false,'md'=>$this->mdReBasics()],
                        ['title'=>'LAB : identifier fonctions clés','lab'=>true,'md'=>$this->labReId()],
                    ],
                ],
                'm2' => [
                    'title' => 'Techniques & contournements',
                    'lessons' => [
                        ['title'=>'Anti-debug & packers (vue haute)','lab'=>false,'md'=>$this->mdReAnti()],
                        ['title'=>'LAB : extraire une IAT simple','lab'=>true,'md'=>$this->labReIat()],
                    ],
                ],
            ],
            [
                'slug' => 'forensics-memoire-avance',
                'title' => 'Forensics Mémoire : analyse avancée',
                'level' => 'avance',
                'duration_min' => 210,
                'description' => 'Volatility, indicateurs d’exécution, injections et timeline mémoire.',
                'm1' => [
                    'title' => 'Cartographie mémoire',
                    'lessons' => [
                        ['title'=>'Espaces, modules, handles','lab'=>false,'md'=>$this->mdForMem()],
                        ['title'=>'LAB : anomalie process & DLL','lab'=>true,'md'=>$this->labForProc()],
                    ],
                ],
                'm2' => [
                    'title' => 'Timeline & IOC',
                    'lessons' => [
                        ['title'=>'TLN, maldoc & shells','lab'=>false,'md'=>$this->mdForTln()],
                        ['title'=>'LAB : corréler artefacts','lab'=>true,'md'=>$this->labForIoc()],
                    ],
                ],
            ],
            [
                'slug' => 'privilege-escalation-cross-os',
                'title' => 'Élévation de privilèges : Linux/Windows',
                'level' => 'avance',
                'duration_min' => 240,
                'description' => 'Checklist, capabilites, SUID, services, UAC & persistence.',
                'm1' => [
                    'title' => 'Linux PrivEsc',
                    'lessons' => [
                        ['title'=>'Checklist & automations','lab'=>false,'md'=>$this->mdPrivLin()],
                        ['title'=>'LAB : exploiter un SUID','lab'=>true,'md'=>$this->labPrivLin()],
                    ],
                ],
                'm2' => [
                    'title' => 'Windows PrivEsc',
                    'lessons' => [
                        ['title'=>'Services, UAC & DLL hijack','lab'=>false,'md'=>$this->mdPrivWin()],
                        ['title'=>'LAB : service vulnérable','lab'=>true,'md'=>$this->labPrivWin()],
                    ],
                ],
            ],
        ];
    }

    private function createCourseWithContent(array $def): void
    {
        $course = Course::updateOrCreate(
            ['slug' => $def['slug']],
            [
                'title'        => $def['title'],
                'description'  => $def['description'],
                'level'        => $def['level'],
                'duration_min' => $def['duration_min'],
                'is_published' => true,
            ]
        );

        // reset modules/lessons
        $course->modules()->delete();

        // M1
        $m1 = $course->modules()->create(['title'=>$def['m1']['title'],'order'=>1]);
        $order = 1;
        foreach ($def['m1']['lessons'] as $L) {
            $m1->lessons()->create([
                'title'=>$L['title'],
                'order'=>$order++,
                'is_lab'=>$L['lab'],
                'markdown'=>$L['md'],
            ]);
        }

        // M2
        $m2 = $course->modules()->create(['title'=>$def['m2']['title'],'order'=>2]);
        $order = 1;
        foreach ($def['m2']['lessons'] as $L) {
            $m2->lessons()->create([
                'title'=>$L['title'],
                'order'=>$order++,
                'is_lab'=>$L['lab'],
                'markdown'=>$L['md'],
            ]);
        }
    }

    /* ===================== BLOCS MARKDOWN ===================== */

    private function mdLinuxPerms(): string { return <<<MD
### Objectifs
- Comprendre la *Pyramide POSIX* : **utilisateur**, **groupe**, **autres**.
- Lire `rwx` et la notation octale.
- Distinguer **UID/GID**, `sudo`, et *capabilities*.

### À retenir
- **Propriété** : `chown user:group fichier`.
- **Droits** : `chmod 640 fichier` → `rw- r-- ---`.
- **sudo** : délégation ciblée, *timestamp* et *tty_tickets*.

### Bonnes pratiques
- Principe du **moindre privilège**.
- `umask` adéquat pour des répertoires partagés.
- Journaliser les commandes admin.

MD;
    }
    private function labLinuxPerms(): string { return <<<MD
### LAB — Permissions & sudo
1. Crée un dossier partagé `grpdocs`, ajoute 2 utilisateurs à un **même groupe**.
2. Configure `umask` pour garantir `rwx` groupe / `---` autres.
3. Ajoute une entrée **sudoers** permettant l’exécution *non-interractive* de `systemctl status`.
4. Montre un court **compte-rendu** : commandes, justification des droits, vérifications.

MD;
    }
    private function mdLinuxNet(): string { return <<<MD
### IP, ARP, DNS (rappels)
- `ip a`, `ip route`, `ip neigh` (ARP), `resolvectl status`.
- DNS : itératif vs récursif, *cache*, serveurs publics.

### Outils
- `ping`, `traceroute`, `ss -lntup`, `dig`, `nslookup`.
- Captures légères : `tcpdump -i eth0 port 53 -vv`.

MD;
    }
    private function labLinuxNet(): string { return <<<MD
### LAB — Panne réseau guidée
1. Interface **UP** ? (`ip a`)
2. **Passerelle** par défaut ? (`ip route`)
3. **ICMP** vers la passerelle, puis vers `1.1.1.1`.
4. **DNS** : `dig +short example.com @1.1.1.1`.
5. Rédige 8–10 lignes : origine de la panne et preuve.

MD;
    }

    private function mdTcpUdpModel(): string { return <<<MD
### Modèles & couches
- OSI (7) vs TCP/IP (4).
- TCP : état, *3-way handshake*, fiabilité.
- UDP : *best effort*, faible latence (DNS, NTP, VoIP).

MD;
    }
    private function labTcpUdpConn(): string { return <<<MD
### LAB — Connexion TCP
- Démarre un **listener** (nc/socat) et connecte-toi.
- Observe avec `ss -tnp` puis **interromps** brutalement (RST).
- Explique la différence entre *close* ordonné vs *reset*.

MD;
    }
    private function mdNcSocat(): string { return <<<MD
### netcat / socat
- **nc -lvnp 9000** / **nc <ip> 9000**
- Port-forward : `socat TCP-LISTEN:8080,fork TCP:127.0.0.1:80`
- Copie de fichiers et *bind shells* (zone de lab).

MD;
    }
    private function labNcSocat(): string { return <<<MD
### LAB — Echo & Forward
1. Écris un **echo-server** netcat.
2. Monte un **forward** 8080→80 avec socat.
3. Vérifie via `curl` et capture `tcpdump`.

MD;
    }

    private function mdHttpBasics(): string { return <<<MD
### HTTP : Méthodes & codes
- **GET/POST/PUT/PATCH/DELETE**.
- 2xx succès, 3xx redirection, 4xx client, 5xx serveur.
- Entêtes clés : `Host`, `User-Agent`, `Accept`, `Cache-Control`.

MD;
    }
    private function labHttpCurl(): string { return <<<MD
### LAB — curl
- Reproduis une **navigation** : GET page, POST formulaire.
- Montre entêtes (`-v`, `-I`) et **corps** (`--data`, `--json`).
- Ajoute une note sur les **redirections** (`-L`).

MD;
    }
    private function mdHttpCookies(): string { return <<<MD
### Sessions & cookies
- Cookie de session **HttpOnly**, **Secure**, **SameSite**.
- CSRF : *token synchronizer* / entêtes *same-site*.
- *Session fixation* & *persistent login*.

MD;
    }
    private function labHttpCookies(): string { return <<<MD
### LAB — Cookies
- Crée un cookie signé; lis-le côté client.
- Montre un exemple de **SameSite=Lax** vs `None; Secure`.
- Décris l’impact sur une requête cross-site.

MD;
    }

    private function mdShellBasics(): string { return <<<MD
### Shell essentials
- Redirections `> >> 2>`, pipes `|`, substitutions `$( )`.
- Boucles `for/while`, tests `[` `]`.
- *trap* et *exit codes*.

MD;
    }
    private function labShellBasics(): string { return <<<MD
### LAB — Pipeline
- Enchaîne `grep | awk | sort | uniq -c | sort -nr` pour profiler un log.
- Sauvegarde dans un **rapport horodaté**.

MD;
    }
    private function mdShellSafety(): string { return <<<MD
### Sécurité des scripts
- `set -Eeuo pipefail`, *quoting*, chemins sûrs.
- Droits d’exécution et répertoires temp.
- Logs et *dry-run*.

MD;
    }
    private function labShellSafety(): string { return <<<MD
### LAB — Audit local
- Script listant comptes, sudoers, services, ports ouverts.
- Génère un **rapport Markdown**.

MD;
    }

    private function mdDnsBasics(): string { return <<<MD
### DNS en pratique
- Résolution récursive vs itérative.
- Types : **A/AAAA**, **CNAME**, **MX**, **NS**, **TXT**.
- TTL & *caching*.

MD;
    }
    private function labDnsBasics(): string { return <<<MD
### LAB — Diagnostic
- `dig +trace domaine.tld`
- Compare 2 résolveurs (public vs local) et TTL.
- Note les différences.

MD;
    }
    private function mdDnsSec(): string { return <<<MD
### Sécurité DNS
- Empoisonnement cache & *Kaminsky*.
- DNSSEC (RRSIG, DS) – limites et bénéfices.
- Liste de blocage & exfiltration DNS.

MD;
    }
    private function labDnsSec(): string { return <<<MD
### LAB — Résolveur alternatif
- Configure un résolveur tiers et mesure la latence.
- Teste l’effet sur l’**exfiltration TXT** (lab).

MD;
    }

    private function mdWshFilters(): string { return <<<MD
### Wireshark — Filtres
- BPF capture vs **display filters**.
- *Follow TCP/UDP stream*, profils, colonnes personnalisées.
- Export d’objets (HTTP, SMB…).

MD;
    }
    private function labWshFiles(): string { return <<<MD
### LAB — Extraction
- Récupère un **fichier téléchargé** dans un pcap.
- Valide son **hash** et documente la méthode.

MD;
    }
    private function mdWshProto(): string { return <<<MD
### Protocoles modernes
- TLS 1.3 : *handshake* & SNI.
- HTTP/2, QUIC : multiplexage, *streams*.
- Où chercher des **indices** malgré le chiffrement.

MD;
    }
    private function labWshIoc(): string { return <<<MD
### LAB — IoC
- Identifie une **communication suspecte**.
- Croise domaines/IP avec des feeds (lab).

MD;
    }

    private function mdOwaspTop(): string { return <<<MD
### OWASP — lecture opérationnelle
- Authn/Authz, *Broken Access*, *Injection*, *XXE*, *XSS*, *SSRF*.
- Modèle **menace → contrôle → test**.

MD;
    }
    private function labOwaspIdor(): string { return <<<MD
### LAB — IDOR
- Application de test : récupère une ressource d’autrui.
- Propose deux **mitigations** concrètes.

MD;
    }
    private function mdOwaspHeaders(): string { return <<<MD
### Durcissement HTTP
- `Content-Security-Policy`, `X-Frame-Options`, `Referrer-Policy`.
- HSTS, `Permissions-Policy`.

MD;
    }
    private function labOwaspCsp(): string { return <<<MD
### LAB — CSP
- Construis une **CSP** minimisant le risque XSS tout en gardant les fonctionnalités.
- Mesure l’impact via *report-only*.

MD;
    }

    private function mdAdAuth(): string { return <<<MD
### Kerberos & NTLM
- Tickets TGT/TGS, délégation, *SPN*.
- NTLM : *handshake* et *relay*.

MD;
    }
    private function labAdEnum(): string { return <<<MD
### LAB — Enum AD
- Enumère *users, groups, SPN*.
- Identifie des **comptes à privilèges**.

MD;
    }
    private function mdAdGpo(): string { return <<<MD
### GPO & surfaces
- GPP, *logon scripts*, héritages.
- Notions de *tiering* & *admin local*.

MD;
    }
    private function labAdLogs(): string { return <<<MD
### LAB — Logs
- Requête *Security* & *Sysmon* pour retrouver une **élévation**.
- Explique la corrélation utilisée.

MD;
    }

    private function mdDockerBasics(): string { return <<<MD
### Docker — sécurité
- Utilisateurs non-root, *capabilities*, *seccomp*.
- Secrets & registries.

MD;
    }
    private function labDockerScan(): string { return <<<MD
### LAB — Scan image
- Analyse une image (vulnérabilités, *CVE*).
- Propose une **remédiation**.

MD;
    }
    private function mdK8sRbac(): string { return <<<MD
### Kubernetes — RBAC
- Roles/Bindings, **namespaces**, quotas.
- Network policies & ingress/egress.

MD;
    }
    private function labK8sPolicies(): string { return <<<MD
### LAB — Policies
- Écris des règles pour limiter privilèges et accès réseau d’un pod.
- Prouve l’effet par tests.

MD;
    }

    private function mdSiemPipeline(): string { return <<<MD
### Pipeline de logs
- Normalisation (ECS), *parsing*, *enrichissement*.
- Sérialisation & retention.

MD;
    }
    private function labSiemParse(): string { return <<<MD
### LAB — Parser nginx
- Transforme des logs en un schéma **normalisé**.
- Ajoute *geoip* et *user-agent family*.

MD;
    }
    private function mdSiemRules(): string { return <<<MD
### Règles & détection
- IOC vs IOA, *correlation rules*, fenêtre temporelle.
- Réduction des faux positifs.

MD;
    }
    private function labSiemAlert(): string { return <<<MD
### LAB — Alerte
- Crée une alerte *brute-force SSH*.
- Documente seuils & exceptions.

MD;
    }

    private function mdRtoOpsec(): string { return <<<MD
### OpSec & préparation
- Règles de **non-perturbation**, traces, *kill-switch*.
- OPORD/allocation & ROE.

MD;
    }
    private function labRtoPlan(): string { return <<<MD
### LAB — Mini OPORD
- Rédige un plan : objectifs, contraintes, ROE.
- Spécifie l’**opsec réseau**.

MD;
    }
    private function mdRtoC2(): string { return <<<MD
### C2 & implants
- *Stagerless*, *beacons*, *jitter*, *MTU*.
- *Profile réseau* : mimer du trafic bénin.

MD;
    }
    private function labRtoProfile(): string { return <<<MD
### LAB — Profil réseau
- Conçois un profil C2 imitant un service web.
- Mesure l’**entropie** des entêtes.

MD;
    }

    private function mdAwsIam(): string { return <<<MD
### IAM avancé
- *least privilege*, conditions, *SCP* & organisations.
- *Boundary policies* & accès cross-account.

MD;
    }
    private function labAwsIam(): string { return <<<MD
### LAB — Policy durcie
- Réécris une policy trop large en *least privilege*.
- Ajoute une **condition** (IP/temps).

MD;
    }
    private function mdAwsDetect(): string { return <<<MD
### Détection AWS
- CloudTrail, Config, GuardDuty : rôles et limites.
- Datalake sécurité.

MD;
    }
    private function labAwsRespond(): string { return <<<MD
### LAB — Réponse
- Lambda déclenchée sur événement (clé exposée).
- *Tag* la ressource & coupe l’accès.

MD;
    }

    private function mdReBasics(): string { return <<<MD
### Lire un binaire
- En-têtes, sections, symboles, *strings*.
- Fonctions courantes & *calling conventions*.

MD;
    }
    private function labReId(): string { return <<<MD
### LAB — Cartographie
- Localise `main`, fonctions d’E/S, *crypto suspecte*.
- Dessine un **graph de contrôle**.

MD;
    }
    private function mdReAnti(): string { return <<<MD
### Anti-debug/VM
- *IsDebuggerPresent*, *timing attacks*, packers.
- Signatures & *unpacking* basique.

MD;
    }
    private function labReIat(): string { return <<<MD
### LAB — IAT
- Extrais et commente la **table d’import** d’un exécutable.
- Déduis le comportement général.

MD;
    }

    private function mdForMem(): string { return <<<MD
### Mémoire
- Espaces, *EPROCESS*, modules chargés, handles.
- Hints de *code injection*.

MD;
    }
    private function labForProc(): string { return <<<MD
### LAB — Proc anormal
- Repère un processus injecté.
- Justifie par artefacts mémoire.

MD;
    }
    private function mdForTln(): string { return <<<MD
### Timeline
- TLN, évènements clés, *maldocs*.
- Assemblage multi-sources.

MD;
    }
    private function labForIoc(): string { return <<<MD
### LAB — Corrélation
- Combine IoC mémoire + journaux système.
- Écris une **hypothèse d’attaque**.

MD;
    }

    private function mdPrivLin(): string { return <<<MD
### Linux privesc
- Checklist, *capabilities*, *SUID*.
- Services et timers.

MD;
    }
    private function labPrivLin(): string { return <<<MD
### LAB — SUID exploitable
- Identifie un binaire SUID vulnérable.
- Obtiens un **shell privilégié** (lab).

MD;
    }
    private function mdPrivWin(): string { return <<<MD
### Windows privesc
- Services mal configurés, UAC, **DLL hijack**.
- *Token* & *integrity levels*.

MD;
    }
    private function labPrivWin(): string { return <<<MD
### LAB — Service vulnérable
- Altère le binaire d’un service mal protégé (lab).
- Rédige les **remédiations**.

MD;
    }
}
