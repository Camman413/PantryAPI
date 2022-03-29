<?php

namespace App\Repositories;

abstract class Repository {
    abstract protected function getAllItems();
    abstract protected function getItemById(int $id);
    abstract protected function createItem(array $details);
    abstract protected function updateItem(mixed $item, array $details);
    abstract protected function deleteItem(mixed $item);
}