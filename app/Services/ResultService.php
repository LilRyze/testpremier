<?php

namespace App\Services;

use App\Repositories\ResultRepository;

class ResultService extends BaseService
{
    public function __construct(ResultRepository $repository)
    {
        $this->repository = $repository;
    }
}
