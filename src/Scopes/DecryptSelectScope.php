<?php

namespace DanielPardamean\MysqlEncrypt\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class DecryptSelectScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $encryptable = $model->encryptable();

        $columns = empty($columns) ? Schema::getColumnListing($model->getTable()) : $columns;

        if (empty($encryptable) || empty($columns)) {
            return $builder->addSelect(...$columns);
        }

        $select = collect($columns)->map(function($column) use ($encryptable, $model) {
            return (in_array($column, $encryptable)) ? db_decrypt($column, $model->getTable()) : $model->getTable() . '.' . $column;
        });

        return $builder->addSelect(...$select);
    }
}
