<?php
require_once 'bootstrap.php';

// Disabilita output di errori strani per pulizia visuale
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🚀 Inizio Setup Utenti Demo...</h1>";

// 1. LISTA UTENTI DA CREARE
// La password è uguale per tutti per comodità: "admin"
$usersData = [
    ['user' => 'MarcoRossi', 'email' => 'marco@unibo.it', 'pass' => 'admin'],
    ['user' => 'GiuliaB',    'email' => 'giulia@unibo.it', 'pass' => 'admin'],
    ['user' => 'LucaNerd',   'email' => 'luca@unibo.it',   'pass' => 'admin']
];

$userIDs = []; // Qui salveremo gli ID generati (es. Marco => 5)

// --- CREAZIONE UTENTI ---
echo "<h3>1. Creazione Utenti...</h3>";
foreach ($usersData as $u) {
    // Proviamo a inserire l'utente
    // Nota: Se esiste già, insertUser fallisce ma noi proseguiamo
    $dbh->insertUser($u['user'], $u['email'], $u['pass']);
    
    // Recuperiamo l'ID usando checkLogin (il trucco per avere l'ID senza query strane)
    $loggedUser = $dbh->checkLogin($u['user'], $u['pass']);
    
    if ($loggedUser) {
        $userIDs[$u['user']] = $loggedUser['id'];
        echo "<li style='color:green'>Creato/Trovato: <b>{$u['user']}</b> (ID: {$loggedUser['id']})</li>";
    } else {
        echo "<li style='color:red'>Errore con {$u['user']}</li>";
    }
}

// Recuperiamo le categorie per assegnare i post correttamente
$cats = $dbh->getCategories();
if(empty($cats)){
    die("<h2 style='color:red'>Errore: Nessuna categoria trovata nel DB! Creale prima.</h2>");
}

// --- CREAZIONE POST ---
echo "<h3>2. Creazione Post...</h3>";

// Definiamo i post. Usiamo i nomi per capire chi posta cosa.
// cat_index: 0 = prima categoria, 1 = seconda...
$postsData = [
    [
        'author' => 'MarcoRossi', 
        'cat_index' => 0, 
        'text' => 'Ragazzi ho perso le chiavi di casa zona Piazza Verdi... portachiavi a forma di pizza. Aiuto!'
    ],
    [
        'author' => 'GiuliaB', 
        'cat_index' => 1, 
        'text' => 'Qualcuno ha gli appunti di Ingegneria del Software? Scambio con Basi di Dati!'
    ],
    [
        'author' => 'LucaNerd', 
        'cat_index' => 2, 
        'text' => 'Avvistata ragazza coi capelli blu in biblioteca alle 3 di notte che piangeva su Java. Ti capisco sorella.'
    ]
];

// Array per salvare gli ID dei post appena creati (per i commenti)
// Struttura: $postIDs[0] = ID del primo post inserito
$postIDs = []; 

foreach ($postsData as $p) {
    if (isset($userIDs[$p['author']])) {
        $uid = $userIDs[$p['author']];
        // Se la categoria esiste, prendiamo il suo ID, altrimenti usiamo la prima
        $cid = isset($cats[$p['cat_index']]) ? $cats[$p['cat_index']]['id'] : $cats[0]['id'];
        
        // Inseriamo il post
        $dbh->insertPost($uid, $cid, $p['text'], null);
        
        // Dobbiamo recuperare l'ID dell'ultimo post inserito. 
        // Poiché insertPost non lo ritorna, facciamo una query veloce specifica per questo script.
        // ATTENZIONE: Questo richiede che $db sia public o accessibile, OPPURE usiamo una logica approssimativa.
        // Per sicurezza, prendiamo l'ultimo post di quell'utente.
        $userPosts = $dbh->getPostsByAuthorId($uid);
        if(!empty($userPosts)){
            $postIDs[] = $userPosts[0]['id']; // Il post più recente (indice 0 perché ordinati per data DESC)
            echo "<li style='color:green'>Post di <b>{$p['author']}</b> inserito.</li>";
        }
    }
}

// --- CREAZIONE COMMENTI ---
echo "<h3>3. Creazione Commenti...</h3>";

// Commenti demo
// post_index: 0 = primo post creato sopra (Chiavi), 1 = secondo (Appunti), 2 = terzo (Avvistamento)
$commentsData = [
    ['author' => 'LucaNerd', 'post_index' => 0, 'text' => 'Le ho viste sul muretto del bar!'],
    ['author' => 'MarcoRossi', 'post_index' => 1, 'text' => 'Io li ho! Scrivimi in privato.'],
    ['author' => 'GiuliaB', 'post_index' => 2, 'text' => 'Ero io... maledetto NullPointerException 😭']
];

foreach ($commentsData as $c) {
    // Verifichiamo che esistano l'autore e il post
    if (isset($userIDs[$c['author']]) && isset($postIDs[$c['post_index']])) {
        
        $uid = $userIDs[$c['author']];
        $pid = $postIDs[$c['post_index']];
        
        $dbh->insertComment($pid, $uid, $c['text']);
        echo "<li style='color:green'>Commento di <b>{$c['author']}</b> aggiunto.</li>";
    }
}

echo "<hr><h1>✅ SETUP COMPLETATO!</h1>";
echo "<p>Ora puoi fare login con:</p>";
echo "<ul>";
foreach($usersData as $u){
    echo "<li>User: <b>{$u['user']}</b> / Pass: <b>{$u['pass']}</b></li>";
}
echo "</ul>";
echo "<a href='login.php'>Vai al Login</a>";
?>