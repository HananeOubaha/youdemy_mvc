<?php
abstract class BaseCourse {
   
    protected $db;
    protected $id;
    protected $title;
    protected $description;
    protected $content;
    protected $teacher_id;
    protected $category_id;
    protected $created_at;
    protected $status; 

    
    public function __construct($db, $id = null, $title = null, $description = null, $content = null, $teacher_id = null, $category_id = null, $created_at = null, $status = 'pending') {
        $this->db = $db;
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->content = $content;
        $this->teacher_id = $teacher_id;
        $this->category_id = $category_id;
        $this->created_at = $created_at;
        $this->status = $status;
    }

    public function getId() { return $this->id; }
    public function getTitle() { return $this->title; }
    public function getDescription() { return $this->description; }
    public function getContent() { return $this->content; }
    public function getTeacherId() { return $this->teacher_id; }
    public function getCategoryId() { return $this->category_id; }
    public function getCreatedAt() { return $this->created_at; }
    public function getStatus() { return $this->status; } 

    public function setTitle($title) { $this->title = $title; }
    public function setDescription($description) { $this->description = $description; }
    public function setContent($content) { $this->content = $content; }
    public function setTeacherId($teacher_id) { $this->teacher_id = $teacher_id; }
    public function setCategoryId($category_id) { $this->category_id = $category_id; }
    public function setCreatedAt($created_at) { $this->created_at = $created_at; }
    public function setStatus($status) { $this->status = $status; }

    abstract public function create($title, $description, $content, $teacher_id, $category_id);

    abstract public function displayCourseDetails();

    public function getAllCourses($page = 1, $limit = 9) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT c.*, u.username as teacher_name, cat.name as category_name 
                 FROM courses c 
                 LEFT JOIN users u ON c.teacher_id = u.id 
                 LEFT JOIN categories cat ON c.category_id = cat.id 
                 WHERE c.status = 'active' 
                 ORDER BY c.created_at DESC
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour rechercher des cours par mot-clé
    public function searchCourses($keyword) {
        $keyword = "%$keyword%";
        $query = "SELECT c.*, u.username as teacher_name, cat.name as category_name 
                 FROM courses c 
                 LEFT JOIN users u ON c.teacher_id = u.id 
                 LEFT JOIN categories cat ON c.category_id = cat.id 
                 WHERE c.title LIKE :keyword OR c.description LIKE :keyword
                 ORDER BY c.created_at DESC";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour obtenir les cours par catégorie
    public function getCoursesByCategory($category_id, $page = 1, $limit = 9) {
        $offset = ($page - 1) * $limit;
        $query = "SELECT c.*, u.username as teacher_name, cat.name as category_name 
                 FROM courses c 
                 LEFT JOIN users u ON c.teacher_id = u.id 
                 LEFT JOIN categories cat ON c.category_id = cat.id 
                 WHERE c.category_id = :category_id
                 ORDER BY c.created_at DESC
                 LIMIT :limit OFFSET :offset";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":category_id", $category_id, PDO::PARAM_INT);
        $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour récupérer tous les cours en attente de validation
    public function getAllCoursesByStatus($status = null) {
        $query = "SELECT c.*, u.username as teacher_name, cat.name as category_name 
                  FROM courses c 
                  LEFT JOIN users u ON c.teacher_id = u.id 
                  LEFT JOIN categories cat ON c.category_id = cat.id 
                  WHERE c.content_type = :content_type"; // Filtrer par type de cours
    
        if ($status !== null) {
            $query .= " AND c.status = :status";
        }
    
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":content_type", $this->content_type);
    
        if ($status !== null) {
            $stmt->bindParam(":status", $status);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour valider un cours
    public function validateCourse($courseId) {
        $query = "UPDATE courses SET status = 'active' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $courseId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Méthode pour suspendre un cours
    public function suspendCourse($courseId) {
        $query = "UPDATE courses SET status = 'suspended' WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $courseId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Méthode pour supprimer un cours
    public function deleteCourse($courseId) {
        $query = "DELETE FROM courses WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $courseId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>

