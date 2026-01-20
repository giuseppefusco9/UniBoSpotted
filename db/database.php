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

    public function getPostById($id){
        $query = "SELECT p.id, p.testo, p.immagine_path, p.categoria_id, p.user_id 
                  FROM post p 
                  WHERE p.id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
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
     * Recupera le statistiche dei post per un utente specifico (Per il grafico a torta)
     */
    public function getUserPostStats($userId){
        $query = "SELECT c.nome, COUNT(p.id) as num_post 
                  FROM post p
                  JOIN categorie c ON p.categoria_id = c.id
                  WHERE p.user_id = ? 
                  GROUP BY c.nome";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $userId);
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
     * Inserisce un nuovo commento
     */
    public function insertComment($postId, $userId, $testo){
        $query = "INSERT INTO commenti (post_id, user_id, testo, data_commento) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('iis', $postId, $userId, $testo);
        return $stmt->execute();
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
     * Registra un nuovo Utente
     */
    public function insertUser($username, $email, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO utenti (username, email, password, admin) VALUES (?, ?, ?, 0)");
        $stmt->bind_param("sss", $username, $email, $passwordHash);

        try {
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
     * Verifica Login Utente
     */
    public function checkLogin($username, $password){
        $query = "SELECT id, username, email, password, admin FROM utenti WHERE username = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('s',$username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if(password_verify($password, $user['password'])) {
                return $user;
            }
        }
        
        return false;
    }

    /**
     * Inserisce un nuovo post
     */
    public function insertPost($userId, $categoriaId, $testo, $immaginePath = null){
        $query = "INSERT INTO post (user_id, categoria_id, testo, immagine_path, data_pubblicazione) 
                  VALUES (?, ?, ?, ?, NOW())";
        
        $stmt = $this->db->prepare($query);
        // 'iiss' significa: intero, intero, stringa, stringa
        $stmt->bind_param('iiss', $userId, $categoriaId, $testo, $immaginePath);
        
        return $stmt->execute();
    }

    /**
     * Aggiorna un post esistente
     */
    public function updatePost($id, $userId, $categoriaId, $testo, $immaginePath){
        $query = "UPDATE post 
                  SET categoria_id = ?, testo = ?, immagine_path = ? 
                  WHERE id = ? AND user_id = ?";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('issii', $categoriaId, $testo, $immaginePath, $id, $userId);
        return $stmt->execute();
    }

    /**
     * Cancella un post (Se admin=TRUE allora puoi cancellare qualsiasi post)
     */
    public function deletePost($id, $userId, $admin = FALSE){
        if($admin) {
            $query = "DELETE FROM post WHERE id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('i', $postId);
        } else {
            $query = "DELETE FROM post WHERE id = ? AND user_id = ?";
            $stmt = $this->db->prepare($query);
            $stmt->bind_param('ii', $id, $userId);
        }
        return $stmt->execute();
    }

    /**
     * Cerca post per testo, categoria o username
     */
    public function searchPosts($keyword){
        // Mettiamo i % per cercare la parola ovunque nella frase
        $param = "%" . $keyword . "%";

        $query = "SELECT p.id, p.testo, p.immagine_path, p.data_pubblicazione, 
                         u.username, c.nome as nome_categoria, p.user_id 
                  FROM post p
                  JOIN utenti u ON p.user_id = u.id
                  JOIN categorie c ON p.categoria_id = c.id
                  WHERE p.testo LIKE ? OR u.username LIKE ? OR c.nome LIKE ?
                  ORDER BY p.data_pubblicazione DESC";
        
        $stmt = $this->db->prepare($query);
        // 'sss' perché cerchiamo la stringa in 3 colonne diverse
        $stmt->bind_param('sss', $param, $param, $param);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>