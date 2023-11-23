<?php
include_once("db.php"); // Include the Database class file

class Province {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
		$recordsPerPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $offset = ($page - 1) * $recordsPerPage;
		
        try {
            $sql = "SELECT * FROM province p";

            if (!empty($search)) {
                $searchParam = "%$search%";
                $sql .= "
                            WHERE p.name LIKE :searchParam
                        ";
            }

            $sql .= " ORDER BY p.name LIMIT :limit OFFSET :offset";

            $stmt = $this->db->getConnection()->prepare($sql);

            if (!empty($search)) {
                $stmt->bindParam(':searchParam', $searchParam, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', $recordsPerPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors (log or display)
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
	
	public function displayAll() {
		try {
            $sql = "SELECT * FROM province";

            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors (log or display)
            throw $e; // Re-throw the exception for higher-level handling
        }
	}

    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO province(name) VALUES(:name);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':name', $data['name']);

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

            $sql = "SELECT * FROM province WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $province = $stmt->fetch(PDO::FETCH_ASSOC);

            return $province;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE province SET
                    name = :name
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindValue(':id', $data['id']);
            $stmt->bindValue(':name', $data['name']);

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
            $sql = "DELETE FROM province WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Check if any rows were affected (record deleted)
            if ($stmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (province_id not found)
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
	
	public function getProvinceCount() {
        $conn = $this->db->getConnection();

        $search = isset($_GET['search']) ? $_GET['search'] : '';

        try {
            $sql = "SELECT COUNT(*) as total FROM province p";

            if (!empty($search)) {
                $searchParam = "%$search%";
                $sql .= "
                            WHERE p.name LIKE :searchParam
                        ";
            }

            $stmt = $conn->prepare($sql);

            if (!empty($search)) {
                $stmt->bindParam(':searchParam', $searchParam, PDO::PARAM_STR);
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
}

?>
