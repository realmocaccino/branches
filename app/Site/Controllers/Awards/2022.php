<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Jogo do Ano',
        'game' => Game::findBySlugOrFail('god-of-war-ragnarok')
    ],
    [
        'award' => 'Indie',
        'game' => Game::findBySlugOrFail('stray')
    ],
    [
        'award' => 'Mais Divertido',
        'game' => Game::findBySlugOrFail('sonic-frontiers')
    ],
    [
        'award' => 'Melhor Visual',
        'game' => Game::findBySlugOrFail('horizon-forbidden-west')
    ],
    [
        'award' => 'Melhor Áudio',
        'game' => Game::findBySlugOrFail('horizon-forbidden-west')
    ],
    [
        'award' => 'Melhor Campanha',
        'game' => Game::findBySlugOrFail('lego-star-wars-the-skywalker-saga')
    ],
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('god-of-war-ragnarok')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('elden-ring')
    ],
    [
        'award' => 'Tiro em Primeira Pessoa',
        'game' => Game::findBySlugOrFail('call-of-duty-modern-warfare-ii')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('sonic-frontiers')
    ],
    [
        'award' => 'Aventura',
        'game' => Game::findBySlugOrFail('the-quarry')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('gran-turismo-7')
    ],
    [
        'award' => 'Esporte',
        'game' => Game::findBySlugOrFail('fifa-23')
    ],
    [
        'award' => 'Luta',
        'game' => Game::findBySlugOrFail('multiversus')
    ]
];