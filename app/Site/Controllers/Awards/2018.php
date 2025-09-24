<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('red-dead-redemption-ii')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('monster-hunter-world')
    ],
    [
        'award' => 'Tiro em Primeira Pessoa',
        'game' => Game::findBySlugOrFail('far-cry-5')
    ],
    [
        'award' => 'Luta',
        'game' => Game::findBySlugOrFail('dragon-ball-fighterz')
    ],
    [
        'award' => 'Esporte',
        'game' => Game::findBySlugOrFail('nba-2k19')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('forza-horizon-4')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('yokus-island-express')
    ],
    [
        'award' => 'Aventura Interativa',
        'game' => Game::findBySlugOrFail('detroit-become-human')
    ],
    [
        'award' => 'Melhor Indie',
        'game' => Game::findBySlugOrFail('subnautica')
    ],
    [
        'award' => 'Melhor Casual',
        'game' => Game::findBySlugOrFail('super-mario-party')
    ],
    [
        'award' => 'Melhor Portátil',
        'game' => Game::findBySlugOrFail('florence')
    ],
];
