<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Course, Module, Lesson, LabTarget};
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // 1 cours
        $c = Course::create([
            'title'         => 'Fondamentaux Réseau',
            'slug'          => Str::slug('Fondamentaux Réseau'),
            'level'         => 'debutant',
            'duration_min'  => 180,
            'description'   => 'IP, TCP/UDP, routage, nmap, wireshark.',
            'is_published'  => true,
        ]);

        // 2 modules + leçons (dont 2 labs)
        $m1 = $c->modules()->create(['title' => 'IP & Sous-réseaux', 'order' => 1]);
        $m2 = $c->modules()->create(['title' => 'Outils & Pratique',  'order' => 2]);

        $m1->lessons()->createMany([
            ['title'=>'Adressage IPv4/IPv6', 'order'=>1, 'markdown'=>'# IPv4/IPv6…'],
            ['title'=>'CIDR & Masques',      'order'=>2, 'markdown'=>'# CIDR…'],
        ]);
        $m2->lessons()->createMany([
            ['title'=>'Scanner un LAN avec nmap', 'order'=>1, 'markdown'=>'# nmap…',      'is_lab'=>true],
            ['title'=>'Captures Wireshark',       'order'=>2, 'markdown'=>'# wireshark…', 'is_lab'=>true],
        ]);

        // 1 cible pour la page "Pratique"
        LabTarget::create([
            'name'        => 'VM Linux - Lab SSH',
            'host'        => '10.0.0.50',
            'port'        => 22,
            'protocol'    => 'ssh',
            'description' => 'VM de pratique (compte dédié étudiant).',
            'enabled'     => true,
        ]);
    }
}
