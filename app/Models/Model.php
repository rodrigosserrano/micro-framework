<?php

namespace App\Models;

use App\Core\Db\Connection;
use PDOException;

class Model
{
    private string $selectFields = '*';


    /** how will I never instantiate 'Model', then I can use '$this->table'
     * Ever instantiate 'User' per example, he extends 'Model', thus I start '$table' on 'ANOTHERMODEL.php'
     * @param array $data - Fields and values in array like a ['field' => 'value']
     * @throws \Exception
     */
    public function create(array $data): bool
    {
        try {
            $fields = implode(',', array_keys($data));
            $values = implode(',:', array_keys($data));
            $query = "INSERT INTO {$this->table} ({$fields}) VALUES (:{$values})";

            return Connection::conn()->prepare($query)->execute($data);
        } catch (PDOException $e) {
            throw new \Exception($e);
        }
    }

    /**
     * Returns all registries
     * @return bool|array
     * @throws \Exception
     */
    public function findAll(): bool|array
    {
        try {
            $query = "SELECT {$this->selectFields} FROM {$this->table}";

            return Connection::conn()->query($query)->fetchAll();
        } catch (PDOException $e) {
            throw new \Exception($e);
        }
    }

    /**
     * @param string $field - Receive field to search
     * @param string|int|bool|null $value - receive value to search
     * @return mixed
     * @throws \Exception
     */
    public function find(string $field, string|int|bool|null $value = '') : mixed
    {
        try {
            $query = "SELECT {$this->selectFields} FROM {$this->table} where {$field} = ";
            $query .= (is_int($value)) ? "$value" : "'$value'";

            return Connection::conn()->query($query)->fetch();
        } catch (PDOException $e) {
            throw new \Exception($e);
        }
    }

    /**
     * @param array $data - Fields and values in array like a ['field' => 'value']
     * @param array $whereCondition - like a ['id' => 2]
     * @return bool
     * @throws \Exception
     */
    public function update(array $data, array $whereCondition) : bool
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
            throw new \Exception($e);
        }
    }

    /**
     * @param string $field - Receive field to search for delete
     * @param string|int|bool|null $value - receive value from delete
     * @return bool
     * @throws \Exception
     */
    public function delete(string $field, string|int|bool|null $value = '') : bool
    {
        try {
            $query = "DELETE FROM {$this->table} WHERE {$field} = :{$field}";

            return Connection::conn()->prepare($query)->execute([$field => $value]);
        } catch (PDOException $e) {
            throw new \Exception($e);
        }
    }
}