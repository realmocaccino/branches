<?php
namespace App\Site\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class ValidContributionScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
    	$builder->with(['game', 'user'])->has('game')->has('user');
    }
}