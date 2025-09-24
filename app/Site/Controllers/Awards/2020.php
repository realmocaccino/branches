<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Jogo do Ano',
        'game' => Game::findBySlugOrFail('final-fantasy-vii-remake')
    ],
    [
        'award' => 'Mais Divertido',
        'game' => Game::findBySlugOrFail('fall-guys-ultimate-knockout')
    ],
    [
        'award' => 'Melhor Visual',
        'game' => Game::findBySlugOrFail('final-fantasy-vii-remake')
    ],
    [
        'award' => 'Melhor Áudio',
        'game' => Game::findBySlugOrFail('doom-eternal')
    ],
    [
        'award' => 'Melhor Campanha',
        'game' => Game::findBySlugOrFail('final-fantasy-vii-remake')
    ],
    [
        'award' => 'Ação e Aventura',
        'game' => Game::findBySlugOrFail('ghost-of-tsushima')
    ],
    [
        'award' => 'Rpg de Ação',
        'game' => Game::findBySlugOrFail('final-fantasy-vii-remake')
    ],
    [
        'award' => 'Tiro em Primeira Pessoa',
        'game' => Game::findBySlugOrFail('doom-eternal')
    ],
    [
        'award' => 'Esporte',
        'game' => Game::findBySlugOrFail('efootball-pes-2021')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('crash-bandicoot-4-its-about-time')
    ],
    [
        'award' => 'Melhor Indie',
        'game' => Game::findBySlugOrFail('genshin-impact')
    ],
    [
        'award' => 'Melhor Multiplayer',
        'game' => Game::findBySlugOrFail('fall-guys-ultimate-knockout')
    ]
];