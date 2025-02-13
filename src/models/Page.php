<?php
// La classe Page pour interagir avec la table `pages` de la base de données

class Page {
    private $id;
    private $title;
    private $content;
    private $created_at;

    // Constructeur
    public function __construct($title, $content, $id = null, $created_at = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->created_at = $created_at;
    }

    // Getter et Setter
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getCreatedAt() {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) {
        $this->created_at = $created_at;
    }

    // Méthodes pour interagir avec la base de données
    public static function createPage(PDO $pdo, $title, $content) {
        $stmt = $pdo->prepare("INSERT INTO pages (title, content) VALUES (:title, :content)");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':content', $content);
        $stmt->execute();
    }

    public static function getAllPages(PDO $pdo) {
        $stmt = $pdo->query("SELECT * FROM pages");
        $pages = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $pages[] = new Page($row['title'], $row['content'], $row['id'], $row['created_at']);
        }
        return $pages;
    }

    public static function findByIdPage(PDO $pdo, $id) {
        $stmt = $pdo->prepare("SELECT * FROM pages WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new Page($row['title'], $row['content'], $row['id'], $row['created_at']);
        }
        return null;
    }
    
    public static function updatePage(PDO $pdo, $id, $title, $content) {
        $stmt = $pdo->prepare("UPDATE pages SET title = :title, content = :content WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        return $stmt->execute();
    }
    
    public static function deletePage(PDO $pdo, $id) {
        $stmt = $pdo->prepare("DELETE FROM pages WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
    
}
?>
