<?php
namespace App\Admin\Scopes;

use App\Admin\Scopes\BaseScope;

use Illuminate\Database\Eloquent\{Builder, Model, Scope};

class SearchableScope extends BaseScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $this->setTableName($model->getTable());

        $column = request('search_column');
    	$term = request('search_term');

		if($term and $this->applyIfIsInThePage() and $columnName = $this->getColumnName($column)) {
        	$builder->where($columnName, 'LIKE', '%' . $term . '%');
        }
    }
}
