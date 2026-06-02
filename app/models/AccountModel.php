<?php
class AccountModel
{
    private $conn;
    private $table_name = "account";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getAccountByUsername($username)
    {
        $query = "SELECT * FROM account WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    function save($username, $name, $password, $role="user") {
        $query = "INSERT INTO " . $this->table_name . " (username, password, role)
        VALUES (:username, :password, :role)";
        $stmt = $this->conn->prepare($query);

        // Làm sạch dữ liệu
        $name = htmlspecialchars(strip_tags($name));
        $username = htmlspecialchars(strip_tags($username));

        // Gán dữ liệu vào câu lệnh
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);

        // Thực thi câu lệnh
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getAccountByEmail($email)
    {
        $query = "SELECT * FROM account WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountByGoogleId($google_id)
    {
        $query = "SELECT * FROM account WHERE google_id = :google_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':google_id', $google_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function getAccountByGithubId($github_id)
    {
        $query = "SELECT * FROM account WHERE github_id = :github_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':github_id', $github_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function createSocialAccount($username, $email, $google_id, $github_id)
    {
        $query = "INSERT INTO " . $this->table_name . " (username, password, role, email, google_id, github_id)
        VALUES (:username, :password, :role, :email, :google_id, :github_id)";
        $stmt = $this->conn->prepare($query);

        $password = password_hash(bin2hex(random_bytes(10)), PASSWORD_BCRYPT);
        $role = "user";

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':google_id', $google_id);
        $stmt->bindParam(':github_id', $github_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
