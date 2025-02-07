<?php
class CourseController {
    private $course;
    private $categoryModel;

    public function __construct($db) {
        // Initialisation des modèles
        $this->course = new CourseText($db); 
        $this->course = new CourseVideo($db);
        $this->categoryModel = new CategoryModel($db);
    }

    // Afficher la liste des cours
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Récupérer les catégories
        $categories = $this->categoryModel->getAllCategories();

        // Récupérer les cours
        if ($search) {
            $courses = $this->course->searchCourses($search);
        } elseif ($category) {
            $courses = $this->course->getCoursesByCategory($category, $page);
        } else {
            $courses = $this->course->getAllCourses($page);
        }

        // Charger la vue
        include 'app/views/courses/index.php';
    }
}
?>