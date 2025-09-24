<?php
namespace App\Site\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
    	$table = $model->getTable();
    	
		if(Schema::hasColumn($table, 'status'))
		{
			$builder->where($table . '.status', 1);
		}
    }
}
