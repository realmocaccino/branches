<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Jogo do Ano',
        'game' => Game::findBySlugOrFail('it-takes-two')
    ],
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('kena-bridge-of-spirits')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('persona-5-strikers')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('forza-horizon-5')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('it-takes-two')
    ],
];