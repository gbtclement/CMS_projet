<?php 

include __DIR__ . 'config/database.php';
include __DIR__ . 'src/models/Page.php';

class PageController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Afficher toutes les pages
    public function index() {
        $pages = Page::getAll($this->pdo);
        include '../views/ListPage.php'; // Vue pour lister les pages
    }

    // Afficher une page spécifique
    public function show($id) {
        $page = Page::findById($this->pdo, $id);
        if ($page) {
            include '../views/ListPage.php'; // Vue pour afficher une page
        } else {
            echo "Page non trouvée";
        }
    }

    // Créer une nouvelle page
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            if (!empty($title) && !empty($content)) {
                Page::create($this->pdo, $title, $content);
                header('Location: index.php?action=createPage'); // Redirection après création
                exit;
            }
        }
        include '../views/CreatePage.php'; // Vue du formulaire de création
    }
}

?>