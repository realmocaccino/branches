<?php
use App\Site\Models\Game;

return [
    [
        'award' => 'Jogo do Ano',
        'game' => Game::findBySlugOrFail('resident-evil-4')
    ],
    [
        'award' => 'RPG',
        'game' => Game::findBySlugOrFail('baldurs-gate-iii')
    ],
    [
        'award' => 'RPG de Ação',
        'game' => Game::findBySlugOrFail('lies-of-p')
    ],
    [
        'award' => 'Ação & Aventura',
        'game' => Game::findBySlugOrFail('resident-evil-4')
    ],
    [
        'award' => 'Aventura',
        'game' => Game::findBySlugOrFail('cocoon')
    ],
    [
        'award' => 'Ação',
        'game' => Game::findBySlugOrFail('armored-core-vi-fires-of-rubicon')
    ],
    [
        'award' => 'Plataforma',
        'game' => Game::findBySlugOrFail('super-mario-bros-wonder')
    ],
    [
        'award' => 'Jogo Indie',
        'game' => Game::findBySlugOrFail('cocoon')
    ],
    [
        'award' => 'Jogo Multiplayer',
        'game' => Game::findBySlugOrFail('lethal-company')
    ],
    [
        'award' => 'Melhor Campanha',
        'game' => Game::findBySlugOrFail('baldurs-gate-iii')
    ],
    [
        'award' => 'Mais Divertido',
        'game' => Game::findBySlugOrFail('hi-fi-rush')
    ],
    [
        'award' => 'Melhor Visual',
        'game' => Game::findBySlugOrFail('alan-wake-ii')
    ],
    [
        'award' => 'Melhor Áudio',
        'game' => Game::findBySlugOrFail('alan-wake-ii')
    ],
    [
        'award' => 'Corrida',
        'game' => Game::findBySlugOrFail('the-crew-motorfest')
    ],
    [
        'award' => 'Esporte',
        'game' => Game::findBySlugOrFail('football-manager-2024')
    ],
    [
        'award' => 'Luta',
        'game' => Game::findBySlugOrFail('mortal-kombat-1')
    ],
];