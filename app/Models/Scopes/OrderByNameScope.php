<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Bài 5: Global Scope - Tự động sắp xếp sinh viên theo tên tăng dần
 */
class OrderByNameScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $builder->orderBy('student_name', 'asc');
    }
}
