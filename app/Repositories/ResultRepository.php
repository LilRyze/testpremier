<?php

namespace App\Repositories;

use App\Models\Result;

class ResultRepository extends BaseRepository
{
    public function __construct(Result $model)
    {
        $this->model = $model;
    }
}
