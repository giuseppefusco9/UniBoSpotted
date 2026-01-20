<?php
require_once 'bootstrap.php';

// Disabilita output di errori strani per pulizia visuale, ma mostra quelli gravi
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<div style='font-family: sans-serif; padding: 20px; line-height: 1.6;'>";
echo "<h1>🚀 Inizio Setup Completo UniBoSpotted...</h1>";

// ==========================================
// 1. CONFIGURAZIONE DATI
// ==========================================

// --- UTENTI ---
// Password per tutti: "admin"
$usersData = [
    // GLI ADMIN
    ['user' => 'admin1',        'email' => 'admin1@unibo.it',    'pass' => 'admin', 'role' => 'admin'],
    ['user' => 'admin2',        'email' => 'admin2@unibo.it',    'pass' => 'admin', 'role' => 'admin'],
    
    // UTENTI NORMALI
    ['user' => 'MarcoRossi',    'email' => 'marco@unibo.it',     'pass' => 'user', 'role' => 'user'],
    ['user' => 'GiuliaB',       'email' => 'giulia@unibo.it',    'pass' => 'user', 'role' => 'user'],
    ['user' => 'LucaNerd',      'email' => 'luca@unibo.it',      'pass' => 'user', 'role' => 'user'],
    ['user' => 'FrancescaArt',  'email' => 'francy@unibo.it',    'pass' => 'user', 'role' => 'user'],
    ['user' => 'MatteoGym',     'email' => 'matteo@unibo.it',    'pass' => 'user', 'role' => 'user'],
    ['user' => 'SofiaErasmus',  'email' => 'sofia@unibo.it',     'pass' => 'user', 'role' => 'user'],
];

$userIDs = []; // Mappa: 'NomeUser' => ID

// ==========================================
// 2. CREAZIONE UTENTI
// ==========================================
echo "<h3>👤 1. Creazione Utenti e Admin...</h3><ul>";

// Creiamo una connessione RAW per forzare l'aggiornamento admin 
// (perché la classe DatabaseHelper non ha un metodo 'makeAdmin')
$rawDb = new mysqli("localhost", "root", "", "unibospotted", 3306);

foreach ($usersData as $u) {
    // 1. Inseriamo l'utente (di base nasce come user normale)
    $dbh->insertUser($u['user'], $u['email'], $u['pass']);
    
    // 2. Recuperiamo l'ID
    $loggedUser = $dbh->checkLogin($u['user'], $u['pass']);
    
    if ($loggedUser) {
        $userIDs[$u['user']] = $loggedUser['id'];
        
        // 3. Se deve essere ADMIN, aggiorniamo manualmente il DB
        if($u['role'] === 'admin'){
            // Controlla se la tua colonna si chiama 'admin' o 'is_admin' e adatta qui sotto
            $sql = "UPDATE utenti SET admin = 1 WHERE id = " . $loggedUser['id']; 
            $rawDb->query($sql);
            echo "<li style='color:blue'>🛠 Creato <b>SUPER ADMIN</b>: {$u['user']} (ID: {$loggedUser['id']})</li>";
        } else {
            echo "<li style='color:green'>✅ Creato Utente: <b>{$u['user']}</b> (ID: {$loggedUser['id']})</li>";
        }
    } else {
        echo "<li style='color:red'>❌ Errore creazione: {$u['user']}</li>";
    }
}
echo "</ul>";

// Recuperiamo categorie
$cats = $dbh->getCategories();
if(empty($cats)) die("<h2 style='color:red'>⚠️ Errore: Nessuna categoria nel DB!</h2>");

// ==========================================
// 3. CREAZIONE POST
// ==========================================
echo "<h3>📝 2. Creazione Post...</h3><ul>";

// cat_index: indice della categoria nell'array $cats (0, 1, 2...)
$postsData = [
    // POST 0: Chiavi perse (Marco)
    ['author' => 'MarcoRossi', 'cat_index' => 0, 'text' => 'Ragazzi ho perso le chiavi di casa zona Piazza Verdi... portachiavi a forma di pizza. Aiuto!'],
    
    // POST 1: Affitto (Giulia) - Questo avrà MOLTI commenti
    ['author' => 'GiuliaB', 'cat_index' => 1, 'text' => 'Cercasi coinquilina per singola in zona Saragozza. 400€ spese escluse. No matricole, solo gente ordinata!'],
    
    // POST 2: Avvistamento (Luca)
    ['author' => 'LucaNerd', 'cat_index' => 2, 'text' => 'Avvistata ragazza coi capelli blu in biblioteca alle 3 di notte che piangeva su Java. Ti capisco sorella.'],

    // POST 3: Lamento Mensa (Matteo)
    ['author' => 'MatteoGym', 'cat_index' => 0, 'text' => 'Ma è possibile che in mensa finiscano sempre il pollo alle 12:30? Io devo fare massa! 🍗'],

    // POST 4: Domanda Esame (Francesca)
    ['author' => 'FrancescaArt', 'cat_index' => 1, 'text' => 'Qualcuno sa quando escono i risultati di Storia dell\'Arte Medievale? Il prof è sparito.'],

    // POST 5: Erasmus (Sofia)
    ['author' => 'SofiaErasmus', 'cat_index' => 2, 'text' => 'Hello everyone! Best place for aperitivo in Bologna? 🍹'],

    // POST 6: Annuncio Admin 1
    ['author' => 'admin1', 'cat_index' => 0, 'text' => '⚠️ AVVISO: Ricordiamo a tutti di mantenere un linguaggio civile nei commenti. I troll verranno bannati.'],

    // POST 7: Festa (Marco) - Anche questo avrà commenti
    ['author' => 'MarcoRossi', 'cat_index' => 3, 'text' => 'Stasera festa a casa mia in via Zamboni! Portate da bere 🍻'],
    
    // POST 8: Admin 2 controllo
    ['author' => 'admin2', 'cat_index' => 0, 'text' => 'Ho appena ripulito lo spam. Segnalate i post sospetti col tasto apposito.'],
];

$postIDs = []; // Salviamo gli ID dei post creati per indicizzarli (0, 1, 2...)

foreach ($postsData as $index => $p) {
    if (isset($userIDs[$p['author']])) {
        $uid = $userIDs[$p['author']];
        // Se l'indice categoria esiste ok, altrimenti usa la 0
        $catIndex = $p['cat_index'] % count($cats); 
        $cid = $cats[$catIndex]['id'];
        
        $dbh->insertPost($uid, $cid, $p['text'], null);
        
        // Recuperiamo ID post appena messo
        $userPosts = $dbh->getPostsByAuthorId($uid);
        if(!empty($userPosts)){
            $postIDs[$index] = $userPosts[0]['id']; 
            echo "<li>Post #$index di <b>{$p['author']}</b> inserito.</li>";
        }
    }
}
echo "</ul>";

// ==========================================
// 4. CREAZIONE COMMENTI
// ==========================================
echo "<h3>💬 3. Creazione Commenti (Discussioni)...</h3><ul>";

$commentsData = [
    // Discussione sul POST 0 (Chiavi)
    ['post_idx' => 0, 'author' => 'LucaNerd', 'text' => 'Le ho viste sul muretto del bar!'],
    ['post_idx' => 0, 'author' => 'MarcoRossi', 'text' => 'Grande Luca! Arrivo subito.'],

    // Discussione sul POST 1 (Affitto - Molti commenti)
    ['post_idx' => 1, 'author' => 'FrancescaArt', 'text' => 'Ciao! È disponibile per brevi periodi?'],
    ['post_idx' => 1, 'author' => 'GiuliaB', 'text' => 'No, minimo 12 mesi.'],
    ['post_idx' => 1, 'author' => 'SofiaErasmus', 'text' => 'Is it ok for Erasmus students?'],
    ['post_idx' => 1, 'author' => 'GiuliaB', 'text' => 'Sorry Sofia, landlords want italian guarantor :('],
    ['post_idx' => 1, 'author' => 'MatteoGym', 'text' => '400 spese escluse è un furto comunque.'],
    ['post_idx' => 1, 'author' => 'admin1', 'text' => 'Matteo, evita commenti non costruttivi grazie.'],

    // Discussione sul POST 2 (Avvistamento)
    ['post_idx' => 2, 'author' => 'GiuliaB', 'text' => 'Ero io... maledetto NullPointerException 😭'],
    ['post_idx' => 2, 'author' => 'LucaNerd', 'text' => 'Coraggio, passa a Python!'],

    // Discussione sul POST 3 (Mensa)
    ['post_idx' => 3, 'author' => 'MarcoRossi', 'text' => 'Vai al kebabbaro che fai prima.'],

    // Discussione sul POST 5 (Erasmus)
    ['post_idx' => 5, 'author' => 'MarcoRossi', 'text' => 'Go to Via del Pratello!'],
    ['post_idx' => 5, 'author' => 'FrancescaArt', 'text' => 'Giardini Margherita is nice too.'],

    // Discussione sul POST 6 (Admin)
    ['post_idx' => 6, 'author' => 'LucaNerd', 'text' => 'Ricevuto capo 🫡'],
    ['post_idx' => 6, 'author' => 'admin2', 'text' => 'Confermo, stiamo monitorando.'],
    
    // Discussione sul POST 7 (Festa)
    ['post_idx' => 7, 'author' => 'MatteoGym', 'text' => 'Posso portare le proteine in polvere?'],
    ['post_idx' => 7, 'author' => 'MarcoRossi', 'text' => 'Ahah fai quello che vuoi basta che porti gente!'],
];

foreach ($commentsData as $c) {
    if (isset($userIDs[$c['author']]) && isset($postIDs[$c['post_idx']])) {
        $uid = $userIDs[$c['author']];
        $pid = $postIDs[$c['post_idx']];
        
        $dbh->insertComment($pid, $uid, $c['text']);
        echo "<li>Commento di <b>{$c['author']}</b> su Post #{$c['post_idx']} aggiunto.</li>";
    }
}
echo "</ul>";

echo "<hr><div style='background:#f0f0f0; padding:15px; border-radius:10px;'>";
echo "<h2>✅ SETUP COMPLETATO CON SUCCESSO!</h2>";
echo "<p>Ecco alcuni account per testare:</p>";
echo "<ul>";
echo "<li>👑 <b>Admin:</b> admin1 / admin</li>";
echo "<li>👑 <b>Admin:</b> admin2 / admin</li>";
echo "<li>👤 <b>Utente:</b> MarcoRossi / user</li>";
echo "<li>👤 <b>Utente:</b> GiuliaB / user</li>";
echo "</ul>";
echo "<a href='login.php' style='display:inline-block; padding:10px 20px; background: #dc3545; color:white; text-decoration:none; border-radius:5px; font-weight:bold;'>Vai al Login</a>";
echo "</div>";
echo "</div>";
?>