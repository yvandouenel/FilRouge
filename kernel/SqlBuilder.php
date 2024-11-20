<?php

namespace Sthom\Kernel;

class SqlBuilder
{

    static public function prepareSelect(string $table, array $fields = []): array
    {
        $sql = "SELECT ";
        if (!empty($fields)) {
            $keys = array_keys($fields);
            $sql .= " *";
            $sql .= " FROM $table";
            $sql .= " WHERE ";
            $sql .= implode(" = ? AND ", $keys);
            $sql .= " = ?";
        } else {
            $sql .= "* FROM $table";
        }
        return ["sql" => $sql, "values" => array_values($fields)];
    }


    static public function prepareInsert(object $class, string $table): array
    {
        $data = self::getClassData($class);
        $sql = "INSERT INTO " . $table . " (";
        $sql .= implode(", ", array_keys($data));
        $sql .= ") VALUES (";
        $sql .= implode(", ", array_fill(0, count($data), "?"));
        $sql .= ")";
        return ["sql" => $sql, "values" => array_values($data)];
    }

    /**
     * Prépare une requête UPDATE SQL à partir d'un objet et d'un nom de table
     *
     * @param object $class L'objet contenant les données
     * @param string $table Le nom de la table
     * @return array Tableau contenant la requête SQL et les valeurs ["sql" => string, "values" => array]
     */
    static public function prepareUpdate(object $class, string $table): array
    {
        $data = self::getClassData($class, true);

        // Extraction de l'ID et préparation des données
        $id = $data['id'];
        unset($data['id']);

        // Construction de la requête SQL
        $sql = sprintf(
            "UPDATE %s SET %s WHERE id = ?",
            $table,
            implode(" = ?, ", array_keys($data)) . " = ?"
        );

        // Préparation des valeurs
        $values = array_values($data);
        $values[] = $id;

        return [
            "sql" => $sql,
            "values" => $values
        ];
    }


    public static function prepareDelete(string $table, int $id): array
    {
        $sql = "DELETE FROM $table WHERE id = ?";
        return ["sql" => $sql, "values" => [$id]];
    }

    /**
     * Récupère les données d'un objet via la réflexion
     *
     * @param object $class L'objet à analyser
     * @param bool $modify Si true, inclut l'ID dans les données
     * @return array Les données de l'objet
     * @throws \ReflectionException
     * @throws \Exception Si l'entité n'est pas complètement initialisée
     */
    static private function getClassData(object $class, bool $modify = false): array
    {
        $reflection = new \ReflectionClass($class);
        $properties = $reflection->getProperties();
        $data = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();

            if (!$modify && $propertyName === 'id') {
                continue;
            }

            if (!$property->isInitialized($class) && !$modify) {
                throw new \Exception("Entity not fullfilled");
            }

            $data[$propertyName] = $property->getValue($class);
        }

        return $data;
    }





    public static function sanitize(array $data): array
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            $sanitized[$key] = htmlspecialchars($value);
        }
        return $sanitized;
    }

}