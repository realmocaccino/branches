<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('uncharted-4-a-thiefs-end')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('dark-souls-iii')
    ],
    [
        'award' => 'Tiro em Primeira Pessoa',
        'game' => Game::findBySlugOrFail('doom')
    ],
    [
        'award' => 'Luta',
        'game' => Game::findBySlugOrFail('the-king-of-fighters-xiv')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('forza-horizon-3')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('super-mario-maker-2')
    ]
];
