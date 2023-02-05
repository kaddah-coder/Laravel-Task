<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;


interface ProductRepositoryinterface extends EloquentRepositoryInterface
{
    public function all(): Collection;
}
