<?php
namespace App\Admin\Scopes;

use App\Admin\Scopes\BaseScope;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};

class SortableScope extends BaseScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $this->setTableName($model->getTable());

        $column = request('sort', 'updated_at');
        $order = request('order', 'desc');

		if($this->applyIfIsInThePage() and $columnName = $this->getColumnName($column)) {
        	$builder->orderBy($columnName, $order);
        }
    }
}
