<?php

namespace App\Models;

use App\Core\Db\Connection;
use App\Core\Http\Request;
use PDOException;

class Model
{
    private string $_selectFields = '*';
    private string $_query = '';
    private int $_page = 1;

    /** how will I never instantiate 'Model', then I can use '$this->table'
     * Ever instantiate 'User' per example, he extends 'Model', thus I start '$table' on 'ANOTHERMODEL.php'
     * @param array $data - Fields and values in array like a ['field' => 'value']
     * @throws \Exception
     */
    public function create(array $data): int
    {
        try {
            $fields = implode(',', array_keys($data));
            $values = implode(',:', array_keys($data));
            $query = "INSERT INTO {$this->table} ({$fields}) VALUES (:{$values})";

            $conn = Connection::conn();

            $conn->prepare($query)->execute($data);

            return $conn->lastInsertId();
        } catch (PDOException $e) {
            throw new \Exception($e, 500);
        }
    }

    /**
     * Returns all registries
     * @return Model
     * @throws \Exception
     */
    public function findAll(): Model|array
    {
        $this->_query = "SELECT {$this->_selectFields} FROM {$this->table} ";
        return $this;
    }

    /**
     * @param string $field - Receive field to search
     * @param string|int|bool|null $value - receive value to search
     * @return mixed
     * @throws \Exception
     */
    public function find(string $field, string|int|bool|null $value = ''): mixed
    {
        try {
            $value = (is_int($value)) ? $value : "'$value'";
            $query = "SELECT {$this->_selectFields} FROM {$this->table} WHERE $field = $value";

            return Connection::conn()->query($query)->fetch();
        } catch (PDOException $e) {
            throw new \Exception($e, 500);
        }
    }

    /**
     * @param array $data - Fields and values in array like a ['field' => 'value']
     * @param array $whereCondition - like a ['id' => 2]
     * @return bool
     * @throws \Exception
     */
    public function update(array $data, array $whereCondition): bool
    {
        try {
            $query = "UPDATE {$this->table} SET ";
            foreach ($data as $field => $value) {
                $query .= "$field = :$field,";
            }

            $query = rtrim($query, ',');

            $query .= " where ";
            foreach ($whereCondition as $field => $value) {
                $query .= "$field = :$field and ";
            }

            $query = substr_replace($query, "", -5);

            $data = array_merge($data, $whereCondition);

            return Connection::conn()->prepare($query)->execute($data);
        } catch (PDOException $e) {
            throw new \Exception($e, 500);
        }
    }

    /**
     * @param string $field - Receive field to search for delete
     * @param string|int|bool|null $value - receive value from delete
     * @return bool
     * @throws \Exception
     */
    public function delete(string $field, string|int|bool|null $value = ''): bool
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE {$field} = :{$field}";

            return Connection::conn()->prepare($query)->execute([$field => $value]);
        } catch (PDOException $e) {
            throw new \Exception($e, 500);
        }
    }

    /********* UTILS METHODS ******
     * @throws \Exception
     */

    public function get(): array
    {
        try {
            return Connection::conn()->query($this->_query)->fetchAll();
        } catch (PDOException $e) {
            throw new \Exception($e, 500);
        }
    }

    public function select(array $columns = []): static
    {
        if (!empty($columns)) $this->_selectFields = implode(', ', $columns);

        $this->_query = "SELECT {$this->_selectFields} FROM {$this->table} ";

        return $this;
    }

    public function where(string $field, string|int|null $value = '', string $operator = '='): static
    {
        if (in_array($operator, ['like', 'ilike'])) $value = "'%$value%'";

        if (!is_int($value)) {
            if (!str_contains($value, "'")) {
                $value = "'$value'";
            }
        }

        $this->_query .= (!str_contains($this->_query, 'WHERE')) ? "WHERE $field $operator $value" : " AND $field $operator $value";

        return $this;
    }


    /**
     * Simple paginante
     * @param int $perPage
     * @return $this
     */
    public function paginate(int $perPage): static
    {
        if (array_key_exists('page', Request::queryString())) {
            $this->_page = Request::queryString()['page'];
        }

        $offset = ($this->_page - 1) * $perPage;
        $this->_query .= "limit $perPage offset $offset";

        return $this;
    }
}