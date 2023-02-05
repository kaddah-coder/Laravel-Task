<?php

namespace App\Repository\Eloquent;

use App\Models\Product;
use App\Repository\ProductRepositoryinterface;
use Illuminate\Database\Eloquent\Collection;


class ProductRepository extends BaseRepository implements ProductRepositoryinterface
{
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }
}
