<?php

namespace App\Repositories;

abstract class Repository {
    abstract protected function getAllItems();
    abstract protected function getItemById($id);
    abstract protected function createItem(array $details);
    abstract protected function updateItem($id, array $details);
    abstract protected function deleteItem($id);
}