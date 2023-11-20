<?php
include_once("db.php"); // Include the file with the Database class

class StudentDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function displayAll(){
        try {
            $sql = "SELECT * FROM student_details LIMIT 10"; // Modify the table name to match your database
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Create a student detail entry and link it to a student
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO student_details(student_id, contact_number, street, zip_code, town_city, province) VALUES(:student_id, :contact_number, :street, :zip_code, :town_city,:province);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_id', $data['student_number']);
            $stmt->bindParam(':contact_number', $data['contact_num']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM student_details WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Check if any rows were affected (record deleted)
            if ($stmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (student_id not found)
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    // Other CRUD methods for student details
}

?>