<?php

namespace App\Interfaces;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * Get all instances of model
     *
     * @return Collection|Model[]
     */
    public function all();

    /**
     * create a new record in the database
     *
     *
     * @throws Exception
     */
    public function create(array $data): ?Model;

    /**
     * update record in the database
     *
     * @return mixed
     */
    public function update(array $data, $id): bool;

    /**
     * remove record from the database
     */
    public function delete($id): bool;

    /**
     * show the record with the given id
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function show($id, bool $purge = false);

    /**
     * Get the associated model
     */
    public function getModel(): Model;

    /**
     * Associated Dynamically  model
     *
     * @return void
     */
    public function setModel(Model $model);

    /**
     * Eager load database relationships
     */
    public function with($relations): Builder;

    public function getQueryBuilder(): Builder;

    /**
     * Get the first Model meet this criteria
     *
     *
     * @throws Exception
     */
    public function findFirstWhere(string $column, string $operator, $value): ?Model;

    /**
     * Get the all Model meet this criteria
     *
     * @return Collection|null
     *
     * @throws Exception
     */
    public function findAllWhere(string $column, string $operator, $value, array $with = []);

    /**
     * Get the all Model Columns Collection
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function findColumn(string $column);

    /**
     * Handle All catch Exceptions
     *
     *
     * @throws Exception
     */
    public function handleException($exception);

    /**
     * @return mixed
     */
    public function paginateWith(array $filters = [], array $eagerRelations = []);

    /**
     * Restore any Soft-Deleted Table Row/Model
     *
     * @return mixed
     */
    public function restore($id): bool;
}
