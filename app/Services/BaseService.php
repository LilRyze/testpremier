<?php

namespace App\Services;

use App\Interfaces\ServiceInterface;

class BaseService implements ServiceInterface
{
    public function all()
    {
        return $this->repository->all();
    }

    public function delete(string $id)
    {
        return $this->repository->delete($id);
    }

    public function update(string $id, array $attributes)
    {
        return $this->repository->update($id, $attributes);
    }

    public function find(string $id)
    {
        return $this->repository->find($id);
    }

    public function findCollection(string $id)
    {
        return $this->repository->findCollection($id);
    }

    public function create(array $attributes)
    {
        return $this->repository->create($attributes);
    }

    public function count()
    {
        return $this->repository->count();
    }
}
