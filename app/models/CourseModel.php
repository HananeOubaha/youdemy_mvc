<?php
// app/models/CourseModel.php

class CourseModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getTeacherCourses($teacherId) {
        $query = "SELECT * FROM courses WHERE teacher_id = :teacher_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":teacher_id", $teacherId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStudentEnrolledCourses($studentId) {
        $query = "SELECT c.* FROM courses c 
                  JOIN enrollments e ON c.id = e.course_id 
                  WHERE e.student_id = :student_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":student_id", $studentId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}