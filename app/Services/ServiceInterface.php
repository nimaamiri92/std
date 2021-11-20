<?php

namespace App\Services;

interface ServiceInterface
{
    public function store(array $data);

    public function update(array $data, $id);

    public function destroy($id): void;
}