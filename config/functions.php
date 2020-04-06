<?php
/* Crée des fonctions qu'on peut appeler dans le template afin d'en afficher le contenu.
*  site_name();         -> Afficher le nom du site (config.php).
*  site_url();          -> Affiche le chemin d'accès (config.php)
*  nav_menu($sep = ''); -> Afficher le menu construit dans la fonction le parametre $sep permet d'ajouter un séparateur optionnel entre chaque element du menu. Le menu est construit avec les informations saisies (config.php)
*  page_title();        -> Affiche le nom de la page en fonction de l'URL demandée
*  page_content();      -> Affiche le contenu de la page demandée
*/

function site_name()    { echo config('name'); }

function site_url()     { echo config('site_url'); }

function nav_menu($sep = '') {
    $nav_menu = '';
    $nav_items = config('nav_menu');
    
    foreach ($nav_items as $uri => $name) {
        $url = config('site_url') . '/' . (config('pretty_uri') || $uri == '' ? '' : '?page=') . $uri;
        
        $nav_menu .= '<li><a href="' . $url . '" title="' . $name . '" class="item">' . $name . '</a></li>' . $sep;
    }

    echo trim($nav_menu, $sep);
}

function page_title() {
    $pageTitle = '';
    
    if(config('pretty_uri') == false) {
        $pageTitle = isset($_GET['page']) ? htmlspecialchars($_GET['page']) : 'Home';
    } else if(config('pretty_uri') == true ){
        $uri = trim($_SERVER["REQUEST_URI"], '/');
        $pageTitle = $uri ? htmlspecialchars($uri) : 'Home';
    }
    
    echo ucwords(str_replace('-', ' ', $pageTitle));
}

/* Récupère le contenu en fonction de la page demandée dans l'URL */
function page_content() {
    $path = '';
    $queriedPage = '';
    
    if(config('pretty_uri') == false) {
        $queriedPage = isset($_GET['page']) ? $_GET['page'] : 'home';
    } else if(config('pretty_uri') == true ){
        $uri = trim($_SERVER["REQUEST_URI"], '/');
        $queriedPage = $uri ? $uri : 'home';
    } else {
        die;
    }

    $path = getcwd() . '/' . config('content_path') . '/' . $queriedPage . '.php';

    if (! file_exists($path)) {
        $path = getcwd() . '/' . config('content_path') . '/404.php';
    }

    return include($path);
}
?>