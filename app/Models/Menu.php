<?php

namespace App\Models;

class Menu
{
    protected array $items = [];
    
    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function getItems(): array
    {
        return $this->items;
    }
    
    public function addItems(array $items): void
    {
        $this->items = array_merge($this->items, $items);
    }
}
