<?php
require_once 'config/db_config.php';

class User {
    public $id;
    public $username;
    public $email;
    public $password;
    public $ruolo;
    public $stato;
    public $ultimo_accesso;
    public $data_creazione;

    // Ricerca un utente tramite email o username
    public static function findByEmailOrUsername($input) {
        $pdo = getDBConnection();
        $query = $pdo->prepare("SELECT * FROM utenti WHERE email = ? OR username = ?");
        $query->execute([$input, $input]);
        $query->setFetchMode(PDO::FETCH_CLASS, 'User');
        return $query->fetch();
    }

    // Controlla se l'email e/o lo username esistono già
    public static function existsByEmailOrUsername($email, $username) {
        $pdo = getDBConnection();
        $query = $pdo->prepare("SELECT email, username FROM utenti WHERE email = ? OR username = ?");
        $query->execute([$email, $username]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return [
            'emailExists' => $result && $result['email'] === $email,
            'usernameExists' => $result && $result['username'] === $username
        ];
    }

    // Salva un nuovo utente
    public function save() {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO utenti (username, email, password, ruolo, stato) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$this->username, $this->email, $this->password, $this->ruolo, $this->stato]);
    }

    // Aggiorna il timestamp dell'ultimo accesso
    public function updateLastAccess() {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("UPDATE utenti SET ultimo_accesso = NOW() WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}
?>
