<?php

namespace App\Repositories;

abstract class Repository {
    abstract protected function getAllItems();
    abstract protected function getItemById(int $id);
    abstract protected function createItem(array $details);
    abstract protected function updateItem(int $id, array $details);
    abstract protected function deleteItem(int $id);
}