<?php
return
    [
        'url' => 'http://',
        'domain' => 'domain.com',
        'path' => '/',
        'assets' => '/assets/',

        'theme' => 'theme-name',

        'containerClass' => 'container',

        'title' => 'Bulb',
        'subtitle' => 'Educational MVC Framework',
        'description' => '',

        'owner' => 'Mickaël DEVOLDÈRE',
        'contact' => 'contact@devoldere.net',
        'author' => 'https://devoldere.net',


        'logo' => '/assets/logo.png',
        'favicon' => '/assets/logo256.png',
        'bg' => '/assets/bg.png',
        'bgVideo' => '/assets/bg.mp4',

        'homeText' => '',

        'css' => 'default',

        'js' => [
            '/assets/js/bulb.js',
        ],

        'nav' => [
            ['Accueil', '/', null],
            ['Tutos', [
                ['PHP', 'tutoriels/php', null],
                ['C#', 'tutoriels/csharp', null],
            ],
            ],
            ['Liens', 'http://', null],
            ['À propos', 'about', null],
        ],


    ];