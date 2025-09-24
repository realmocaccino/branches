<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('the-legend-of-zelda-breath-of-the-wild')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('horizon-zero-dawn')
    ],
    [
        'award' => 'Tiro em Primeira Pessoa',
        'game' => Game::findBySlugOrFail('wolfenstein-ii-the-new-colossus')
    ],
    [
        'award' => 'Luta',
        'game' => Game::findBySlugOrFail('injustice-2')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('forza-motorsport-7')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('hollow-knight')
    ],
];
