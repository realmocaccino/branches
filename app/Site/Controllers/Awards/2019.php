<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Jogo do Ano',
        'game' => Game::findBySlugOrFail('resident-evil-2')
    ],
    [
        'award' => 'Melhor Visual',
        'game' => Game::findBySlugOrFail('mortal-kombat-11')
    ],
    [
        'award' => 'Melhor Áudio',
        'game' => Game::findBySlugOrFail('gears-5')
    ],
    [
        'award' => 'Melhor Campanha',
        'game' => Game::findBySlugOrFail('metro-exodus')
    ],
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('devil-may-cry-5')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('tom-clancys-the-division-2')
    ],
    [
        'award' => 'Tiro em Primeira Pessoa',
        'game' => Game::findBySlugOrFail('metro-exodus')
    ],
    [
        'award' => 'Luta',
        'game' => Game::findBySlugOrFail('super-smash-bros-ultimate')
    ],
    [
        'award' => 'Esporte',
        'game' => Game::findBySlugOrFail('efootball-pes-2020')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('crash-team-racing-nitro-fueled')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('super-mario-maker-2')
    ],
    [
        'award' => 'Melhor Multiplayer',
        'game' => Game::findBySlugOrFail('apex-legends')
    ],
    [
        'award' => 'Melhor Portátil',
        'game' => Game::findBySlugOrFail('call-of-duty-mobile')
    ]
];
