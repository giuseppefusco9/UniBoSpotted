<?php
class DatabaseHelper {
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port){
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connessione fallita: " . $this->db->connect_error);
        }        
    }

    /**
     * Recupera tutte le categorie
     */
    public function getCategories() {
        $stmt = $this->db->prepare("SELECT * FROM categorie");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Recupera i Post con Autore e Categoria
     */
    public function getPosts($n = -1){
        $query = "SELECT p.id, p.testo, p.immagine_path, p.data_pubblicazione, 
                         u.username, c.nome as nome_categoria 
                  FROM post p
                  JOIN utenti u ON p.user_id = u.id
                  JOIN categorie c ON p.categoria_id = c.id
                  ORDER BY p.data_pubblicazione DESC";
        
        if($n > 0){
            $query .= " LIMIT ?";
        }
        
        $stmt = $this->db->prepare($query);

        if($n > 0){
            $stmt->bind_param('i', $n);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPostsByAuthorId($author_id) {
        $query = "SELECT p.id, p.testo, p.immagine_path, p.data_pubblicazione, 
                         c.nome as nome_categoria 
                  FROM post p
                  JOIN categorie c ON p.categoria_id = c.id
                  WHERE p.user_id = ?
                  ORDER BY p.data_pubblicazione DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $author_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Recupera i commenti per un post specifico
     */
    public function getComments($post_id) {
        $query = "SELECT c.testo, c.data_commento, u.username 
                  FROM commenti c 
                  JOIN utenti u ON c.user_id = u.id 
                  WHERE c.post_id = ? 
                  ORDER BY c.data_commento ASC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $post_id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Recupera le categorie più usate (Per i 'Trend')
     */
    public function getTopCategories() {
        $query = "SELECT c.id, c.nome, COUNT(p.id) AS num_post 
                  FROM categorie c 
                  LEFT JOIN post p ON c.id = p.categoria_id 
                  GROUP BY c.id, c.nome 
                  ORDER BY num_post DESC 
                  LIMIT 5";
                  
        $stmt = $this->db->prepare($query);
        
        if (!$stmt) {
            die("Errore nella query getTopCategories: " . $this->db->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    /**
     * Verifica Login Utente
     */
/**
     * Verifica Login Utente (Accetta sia Username che Email)
     */
    public function checkLogin($username, $password){
        // Modifichiamo la query per cercare sia nel campo username CHE nel campo email
        $query = "SELECT id, username, password, ruolo FROM utenti WHERE username = ? OR email = ?";
        
        $stmt = $this->db->prepare($query);
        
        // --- BLOCCO DEBUG IMPORTANTE ---
        // Se la preparazione fallisce, questo ci dirà ESATTAMENTE perché.
        if (!$stmt) {
            die("Errore nella query SQL (checkLogin): " . $this->db->error);
        }
        // -------------------------------

        // Bindiamo due parametri stringa ('ss'):
        // Passiamo $username due volte perché la query ha due punti di domanda (?)
        // Uno per 'username = ?' e uno per 'email = ?'
        $stmt->bind_param('ss', $username, $username);
        
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            // Verifica hash password
            if(password_verify($password, $row['password'])){
                return $row;
            }
        }
        return false;
    }
}
?>