<?php
namespace App\Site\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ModeOrderScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
		$builder->orderBy('modes.name' . config('site.locale_column_suffix'), 'desc');
    }
}