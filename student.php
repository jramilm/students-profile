<?php
include_once("db.php"); // Include the file with the Database class

class Student {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO students(student_number, first_name, middle_name, last_name, gender, birthday) VALUES(:student_number, :first_name, :middle_name, :last_name, :gender, :birthday);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_number', $data['student_number']);
            $stmt->bindParam(':first_name', $data['first_name']);
            $stmt->bindParam(':middle_name', $data['middle_name']);
            $stmt->bindParam(':last_name', $data['last_name']);
            $stmt->bindParam(':gender', $data['gender']);
            $stmt->bindParam(':birthday', $data['birthday']);

            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
             
            if($stmt->rowCount() > 0)
            {
                return $this->db->getConnection()->lastInsertId();
            }

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM students JOIN student_details sd ON student_number = sd.student_id WHERE students.id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE students JOIN student_details sd ON student_number = sd.student_id SET
                    student_number = :student_number,
                    student_id = :student_number,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    gender = :gender,
                    birthday = :birthday,
                    contact_number = :contact_number,
                    street = :street,
                    town_city = :town_city,
                    province = :province,
                    zip_code = :zip
                    WHERE students.id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindValue(':id', $data['id']);
            $stmt->bindValue(':student_number', $data['student_number']);
            $stmt->bindValue(':first_name', $data['first_name']);
            $stmt->bindValue(':middle_name', $data['middle_name']);
            $stmt->bindValue(':last_name', $data['last_name']);
            $stmt->bindValue(':gender', $data['gender']);
            $stmt->bindValue(':birthday', $data['birthday']);
            $stmt->bindValue(':contact_number', $data['contact_num']);
            $stmt->bindValue(':town_city', $data['town_city']);
            $stmt->bindValue(':province', $data['province']);
            $stmt->bindValue(':street', $data['street']);
            $stmt->bindValue(':zip', $data['zip']);

            // Execute the query
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM students WHERE id = :id";
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

    public function displayAll(){
        try {
            $sql = "SELECT * FROM students LIMIT 10"; // Modify the table name to match your database
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

    public function displayAllWithDetails(){
        $conn = $this->db->getConnection();

        $recordsPerPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $offset = ($page - 1) * $recordsPerPage;

        try {
            $sql = "SELECT * FROM students s JOIN student_details sd ON student_number = sd.student_id";

            if (!empty($search)) {
                $searchParam = "%$search%";
                $sql .= "
                            WHERE (CONCAT(s.last_name, ' ', s.first_name) LIKE :searchParam1 OR
                            CONCAT(s.first_name, ' ', s.last_name) LIKE :searchParam2 OR
                            s.student_number LIKE :searchParam3 OR
                            sd.contact_number LIKE :searchParam4 OR
                            sd.street LIKE :searchParam5 OR
                            s.middle_name LIKE :searchParam6)
                        ";
            }

            $sql .= " ORDER BY s.student_number LIMIT :limit OFFSET :offset";

            $stmt = $conn->prepare($sql);

            if (!empty($search)) {
                $stmt->bindParam(':searchParam1', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam2', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam3', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam4', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam5', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam6', $searchParam, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function getStudentsCount() {
        $conn = $this->db->getConnection();

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        try {
            $sql = "SELECT COUNT(*) as total FROM students s JOIN student_details sd ON student_number = sd.student_id";

            if (!empty($search)) {
                $searchParam = "%$search%";
                $sql .= "
                            WHERE (CONCAT(s.last_name, ' ', s.first_name) LIKE :searchParam1 OR
                            CONCAT(s.first_name, ' ', s.last_name) LIKE :searchParam2 OR
                            s.student_number LIKE :searchParam3 OR
                            sd.contact_number LIKE :searchParam4 OR
                            sd.street LIKE :searchParam5 OR
                            s.middle_name LIKE :searchParam6)
                        ";
            }

            $stmt = $conn->prepare($sql);

            if (!empty($search)) {
                $stmt->bindParam(':searchParam1', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam2', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam3', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam4', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam5', $searchParam, PDO::PARAM_STR);
                $stmt->bindParam(':searchParam6', $searchParam, PDO::PARAM_STR);
            }

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result[0]['total'];
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function getGenderData(){
        try {
            $sql = "SELECT gender, COUNT(*) as count FROM students GROUP BY gender";
            $stmt= $this->db->getConnection()->query($sql);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getPopulationData() {
        try {

            $sql = "
                    SELECT
                        p.name as province_name,
                        tc.name as town_name,
                        COUNT(sd.id) as count
                    FROM
                        student_details sd
                    JOIN
                        town_city tc ON sd.town_city = tc.id
                    JOIN
                        province p ON sd.province = p.id
                    GROUP BY
                        p.name, tc.name
                   ";

            $stmt = $this->db->getConnection()->query($sql);
            // print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getBirthYearData() {
        try {
            $sql = "
                    SELECT
                        YEAR(birthday) as birth_year,
                        COUNT(id) as count
                    FROM
                        students
                    GROUP BY
                        birth_year
                  ";

            $stmt = $this->db->getConnection()->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
 
    /*
        sample simple tests
    */
    public function testCreateStudent() {
        $data = [
            'student_number' => 'S12345',
            'first_name' => 'John',
            'middle_name' => 'Doe',
            'last_name' => 'Smith',
            'gender' => '1',
            'birthday' => '1990-01-15',
        ];

        $student_id = $this->create($data);

        if ($student_id !== null) {
            echo "Test passed. Student created with ID: " . $student_id . PHP_EOL;
            return $student_id;
        } else {
            echo "Test failed. Student creation unsuccessful." . PHP_EOL;
        }
    }

    public function testReadStudent($id) {
        $studentData = $this->read($id);

        if ($studentData !== false) {
            echo "Test passed. Student data read successfully: " . PHP_EOL;
            print_r($studentData);
        } else {
            echo "Test failed. Unable to read student data." . PHP_EOL;
        }
    }

    public function testUpdateStudent($id, $data) {
        $success = $this->update($id, $data);

        if ($success) {
            echo "Test passed. Student data updated successfully." . PHP_EOL;
        } else {
            echo "Test failed. Unable to update student data." . PHP_EOL;
        }
    }

    public function testDeleteStudent($id) {
        $deleted = $this->delete($id);

        if ($deleted) {
            echo "Test passed. Student data deleted successfully." . PHP_EOL;
        } else {
            echo "Test failed. Unable to delete student data." . PHP_EOL;
        }
    }
}

?>