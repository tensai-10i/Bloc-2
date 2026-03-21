<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RessourceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('ressources')->insert([
            [
                'title' => 'Gérer le stress au quotidien',
                'content' => 'Techniques simples pour réduire le stress : respiration, organisation et pauses actives.',
                'type' => 'article',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => '5 exercices de respiration',
                'content' => 'Apprenez à contrôler votre respiration pour calmer l’anxiété rapidement.',
                'type' => 'guide',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Comprendre ses émotions',
                'content' => 'Identifier, nommer et accepter ses émotions pour mieux les gérer.',
                'type' => 'article',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Routine bien-être du matin',
                'content' => 'Construire une routine matinale pour démarrer la journée avec énergie.',
                'type' => 'guide',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Podcast : lâcher prise',
                'content' => 'Un podcast pour apprendre à relativiser et lâcher prise.',
                'type' => 'podcast',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'title' => 'Vidéo : méditation guidée',
                'content' => 'Séance de méditation guidée pour débutants.',
                'type' => 'video',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}