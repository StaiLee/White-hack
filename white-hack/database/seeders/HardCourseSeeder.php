<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\{Course, Module, Lesson};

class HardCourseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $course = Course::firstOrCreate(
                ['slug' => 'pentest-avance-web-privesc'],
                [
                    'title'        => 'Pentest Avancé : Web & PrivEsc',
                    'description'  => "Approche offensive avancée : recon ciblée, exploitation raisonnée (OWASP), élévation de privilèges Linux/Windows et pivot. Orientation méthodo + pratiques guidées.",
                    'level'        => 'avance',      // -> dégradé ROUGE (level-hard)
                    'duration_min' => 240,
                    'is_published' => true,
                ]
            );

            // reset propre du contenu
            $course->modules()->delete();

            // Module 1 — Recon & Attack Surface
            $m1 = $course->modules()->create([
                'title' => 'Recon & Attack Surface',
                'order' => 1,
            ]);

            $m1->lessons()->createMany([
                [
                    'title'    => 'Reconnaissance avancée',
                    'order'    => 1,
                    'is_lab'   => false,
                    'markdown' => <<<'TXT'
Objectifs
- Construire une vision “graph” de la cible (assets, sous-domaines, technos)
- Prioriser l’attaque par surface et risque

Pistes
- DNS/bruteforce : amass, subfinder, shuffledns
- Tech stack : httpx, webanalyze, wappalyzer
- Captures/states : aquatone, gowitness
- Wordlists ciblées et permutations
- Corrélation : map résultats → hypothèses d’attaque

Commandes mémo (zone autorisée uniquement)
- subfinder -d target.tld | httpx -sc -td -title
- amass enum -passive -d target.tld
- gowitness file -f hosts.txt -P out/
TXT
                ],
                [
                    'title'    => 'Lab : Recon outillé & priorisation',
                    'order'    => 2,
                    'is_lab'   => true,
                    'markdown' => <<<'TXT'
But
- Produire une shortlist exploitable (3 à 5 vecteurs “haute valeur”)

Étapes
1) Enum sous-domaines + statut HTTP + titres
2) Détecter techno et chemins “intéressants” (panels, /admin, /api, ws,…)
3) Score des cibles (impact × faisabilité)
4) Synthèse 10–15 lignes (hypothèses d’exploitation)

Livrable attendu
- Tableau des findings (host, service, notes)
- Top 3 cibles avec justification
TXT
                ],
            ]);

            // Module 2 — Exploitation & PrivEsc
            $m2 = $course->modules()->create([
                'title' => 'Exploitation & PrivEsc',
                'order' => 2,
            ]);

            $m2->lessons()->createMany([
                [
                    'title'    => 'Exploitation raisonnée (OWASP)',
                    'order'    => 1,
                    'is_lab'   => false,
                    'markdown' => <<<'TXT'
Rappels focalisés
- AuthZ/IDOR, Access Control misconfig
- Injection (SQLi, SSTI), désérialisation
- Exposition secrets, path traversal, RCE “by design”
- SSRF → pivot interne
- Uploads (content-type, polyglotte, path trick)

Approche
- Hypothèse → PoC minimal → validation par logs/télémétrie
- Toujours limiter l’impact (éthique) et journaliser
TXT
                ],
                [
                    'title'    => 'Lab : PrivEsc Linux (GTFOBins/Capabilities)',
                    'order'    => 2,
                    'is_lab'   => true,
                    'markdown' => <<<'TXT'
But
- Passer d'un shell utilisateur à root via privesc “propres”

Checklist
- sudo -l
- getcap -r / 2>/dev/null
- find / -perm -4000 -type f 2>/dev/null
- env, PATH, $LD_PRELOAD / $LD_LIBRARY_PATH
- Services locaux en clair (systemctl, netstat/ss)

Aide mémoire (zone de lab uniquement)
- GTFObins : recherche binaire présent sur la machine
- cap_setuid+ep sur un binaire custom → eUID=0 si mal config
TXT
                ],
                [
                    'title'    => 'Lab : PrivEsc Windows (Services & Tokens)',
                    'order'    => 3,
                    'is_lab'   => true,
                    'markdown' => <<<'TXT'
But
- Élévation via services faibles, DLL hijacking, tokens

Pistes
- winPEAS/Seatbelt → collecte
- Services non protégés (permissions, binaire modifiable)
- UAC/Token Impersonation selon contexte

Rappel éthique
- Tenir un journal des actions et indicateurs collectés
TXT
                ],
            ]);
        });
    }
}
