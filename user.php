<?php
class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Check if student exists
    public function studentExists($student_number) {
        $stmt = $this->pdo->prepare(
            "SELECT * FROM students WHERE student_number = ?"
        );
        $stmt->execute([$student_number]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new student
    public function addStudent($student_number, $name, $course, $year_level) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO students (student_number, name, course, year_level) VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([$student_number, $name, $course, $year_level]);
    }

    // Insert a request
    public function addRequest($student_number, $document_request) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO requests (student_number, document_request) VALUES (?, ?)"
        );
        return $stmt->execute([$student_number, $document_request]);
    }

    // Fetch all requests with student data
    public function getAllRequests() {
        $stmt = $this->pdo->query(
            "SELECT r.id, r.student_number, s.name, s.course, s.year_level, r.document_request, r.request_status, r.request_date
             FROM requests r
             JOIN students s USING(student_number)
             ORDER BY r.request_date DESC"
        );
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   // Fetch one request by its primary key (id)
        public function getRequestById($id) {
        $stmt = $this->pdo->prepare(
            "SELECT r.id, r.student_number, s.name, s.course, s.year_level, r.document_request, r.request_status, r.request_date
             FROM requests r
             JOIN students s USING(student_number)
             WHERE r.id = ?"
    );
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

}
