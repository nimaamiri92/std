<?php

namespace App\Repositories;

interface RepositoryInterface
{
    public function all($columns = ['*']);

    public function show(int $id);
}