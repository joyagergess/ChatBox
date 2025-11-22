<?php
abstract class Model {

    protected static $table; 

    protected function get_values_type($value) {
        if (is_int($value)) return 'i';
        if (is_float($value)) return 'd';
        if (is_string($value)) return 's';
        if (is_null($value)) return 's'; 
        return 's'; 
    }

    public function create(array $data, mysqli $connection) {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));
  
        $sql = "INSERT INTO " . static::$table . " ($columns) VALUES ($placeholders)";
        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $connection->error);
        }

        $value_type = '';
        foreach ($data as $value) {
            $value_type .= $this->get_values_type($value);
        }

        $stmt->bind_param($value_type, ...array_values($data));
        return $stmt->execute();
    }


    public function update(array $data, string $primaryKey, $primaryValue, mysqli $connection) {
        $set = implode(', ', array_map(fn($key) => "$key = ?", array_keys($data)));
        $sql = "UPDATE " . static::$table . " SET $set WHERE $primaryKey = ?";
        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $connection->error);
        }

        $value_type = '';
        foreach ($data as $value) {
            $value_type .= $this->get_values_type($value);
        }
        $value_type .= $this->get_values_type($primaryValue);

        $values = array_merge(array_values($data), [$primaryValue]);
        $stmt->bind_param($value_type, ...$values);

        return $stmt->execute();
    }

    public function delete(string $primaryKey, $primaryValue, mysqli $connection) {
        $sql = "DELETE FROM " . static::$table . " WHERE $primaryKey = ?";
        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $connection->error);
        }

        $value_type = $this->get_values_type($primaryValue);
        $stmt->bind_param($value_type, $primaryValue);

        return $stmt->execute();
    }


public static function findById($primaryKeyValue, string $primaryKey, mysqli $connection) {

    $sql = "SELECT * FROM " . static::$table . " WHERE $primaryKey = ?";
    $stmt = $connection->prepare($sql);

    if (!$stmt) {
        throw new Exception("Prepare failed: " . $connection->error);
    }

    $temp = new static([]);
    $value_type = $temp->get_values_type($primaryKeyValue);

    $stmt->bind_param($value_type, $primaryKeyValue);
    $stmt->execute();
    $result = $stmt->get_result();

    $rows = [];
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    return $rows;
}


 public static function findAll(mysqli $connection) {
        $sql = "SELECT * FROM " . static::$table;
        $stmt = $connection->prepare($sql);

        if (!$stmt) {
            throw new Exception("Prepare failed: " . $connection->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $rows = [];
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }
 
}
?>
