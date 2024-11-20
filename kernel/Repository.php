<?php

namespace Sthom\Kernel;

use Sthom\Kernel\DbContext;

/**
 * Cette classe est un repository générique
 * Elle permet de faire des requêtes SQL sur une table
 * Elle permet de mapper les résultats sur un objet d'une classe passée en paramètre
 */
class Repository
{
    private \PDO $connexion;
    private string $model;
    private string $table;
    private ?string $sql;
    private ?\PDOStatement $request;

    /**
     * Le constructeur de la classe Repository
     * Elle prend en paramètre le namespace de la classe pour laquelle on veut faire des requêtes SQL vers la table correspondante
     * @param string $namespace
     *
     * @return void
     */
    public function __construct(string $namespace)
    {
        $this->table = $this->setTable($namespace);
        $this->model = $namespace;
        $this->connexion = DbContext::getConnexion();
    }


    /**
     * Cette méthode supprimer un enregistrement dans la table associé à la classe passé en paramètr
     *
     * @param object $entity
     *
     */
    public final function delete(int $id): void {
        $query = SqlBuilder::prepareDelete($this->table, $id);
        $this->sql = $query['sql'];
        $this->prepare($query['values']);
    }

    /**
     *
     * Cette méthode permet de récupérer un enregistrement de la table en fonction de son id
     * Elle retourne un objet du type de la classe passée en paramètre
     *
     * @param int $id
     * @return object|null
    */
    public final function getById(int $id): ?object
    {
        return $this->getByAttributes(['id' => $id], false);
    }

    /**
     * Récupère tous les enregistrements de la table associée à la classe
     *
     * @return array|null
     */
    public final function getAll(): ?array
    {
        return $this->getByAttributes([]);
    }

    /**
     * Cette méthode récupère les enregistrements en fonction des paramètres passés en arguments
     * @param array $attributes un tableau associatif avec commé clé le nom de la colonne et comme valeur la valeur recherché
     */
    public final function getByAttributes(array $attributes, bool $all = true): mixed
    {
        $query = SqlBuilder::prepareSelect($this->table, $attributes);
        $this->sql = $query['sql'];
        $this->prepare($query['values']);

        return $this->getResult($all);
    }

    /**
     * Cette méthode permet de créer un enregistrement dans la table associé à la classe passé en paramètre
     *
     * @param object $entity
     *
     */
    public final function insert(object $entity): void
    {
        $query = SqlBuilder::prepareInsert($entity, $this->table);
        $this->sql = $query['sql'];
        $this->prepare($query['values']);
    }


    /**
     * Cette méthode permet de mettre à jour un enregistrement dans la table associé à la classe passé en paramètre
     *
     * @param object $entity
     *
     */
    public final function update(object $entity): void
    {
        $query = SqlBuilder::prepareUpdate($entity, $this->table);
        $this->sql = $query['sql'];
        $this->prepare($query['values']);
    }


    /**
     * Cette méthode permet de préparer une requête SQL et l'exécuter avec les arguments passés en paramètre
     * et le SQL créé dans les méthodes de cette classe
     *
     * @param object $entity
     *
     */
    public final function prepare(?array $args = null): void
    {
        // avoid date format issue
        foreach ($args as $key => $value) {
            if ($value instanceof \DateTimeInterface) {
                $args[$key] = $value->format('Y-m-d H:i:s');
            } else if (is_bool($value)) {
                $args[$key] = $value ? 1 : 0;
            } else if (is_null($value)) {
                $args[$key] = null;
            } else {
                $args[$key] = $value;
            }
        }
        $args = SqlBuilder::sanitize($args);
        $this->request = $this->connexion->prepare($this->sql);
        $this->request->execute($args);
    }

    /**
     * Cette méthode permet de récupérer le résultat d'une requête SQL
     * Elle retourne un tableau d'objet si le paramètre $all est à true
     *
     * @param bool $all
     * @return mixed
     */
    private function getResult(bool $all = true): mixed
    {
        $result = $this->fetchAll();
        if ($result) {
            if ($all === true) {
                return $result;
            }
            return $result[0];
        } else {
            return null;
        }
    }

    /**
     * Cette méthode permet de récupérer tous les enregistrements de la table
     * Elle retourne un tableau d'objet
     *
     * @return array
     */
    public function fetchAll(): array
    {
        return $this->request->fetchAll(\PDO::FETCH_CLASS, $this->model);
    }



    /**
     *
     * Cette méthode permet de déterminer le nom de la table à adresser
     * Elle prend en paramètre le namespace de la classe
     * Elle retourne le nom de la table SQL correspondant à la classe PHP
     *
     * @param string $namespace
     * @return string
     */
    private function setTable(string $namespace): string
    {
        $parts = explode('\\', $namespace); // on sépare les parties du namespace
        return strtolower($parts[count($parts) - 1]); // on récupère le dernier élément du tableau qui est le nom du modèle
    }

}