<?php

/* Liste les configurations nécessaires au fichier functions.php
*  name         -> Nom global du site internet
*  site_url     -> Chemin d'accès pours les liens, les fichiers styles et les fichiers scripts
*  pretty_uri   -> Determine si l'url doit être SEO Friendly (false / true)
*  nav_menu     -> Permet d'assigner un titre de page à un nom de fichier pour la construction du menu
*  content_path -> Renseigne le dossier où se trouvent les fichiers du thème
*/

function config($key = '') {
    $config = [
        'name'         => 'Intégration',
        'site_url'     => 'http://'. $_SERVER['HTTP_HOST'],
        'pretty_uri'   => true,
        'nav_menu'     => [
            ''         => 'Home',
            'about-us' => 'About Us',
            'products' => 'Products',
            'contact'  => 'Contact',
            'test'     => 'Test',
        ],
        'content_path' => 'app',
    ];

    return isset($config[$key]) ? $config[$key] : null;
}
?>