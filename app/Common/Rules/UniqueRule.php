<?php
namespace App\Common\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueRule implements Rule
{
	protected $table;
	protected $column;
	protected $ignoreId;
    protected $furtherCondition;

    public function __construct($table, $column, $ignoreId = null)
    {
        $this->table = $table;
        $this->column = $column;
        $this->ignoreId = $ignoreId ?: request('id', null);
    }

    public function passes($attribute, $value)
    {
    	$total = DB::table($this->table)
    				->where($this->column, $value)
    				->whereNull('deleted_at')
    				->when($this->ignoreId, function($query) {
    					return $query->where('id', '!=', $this->ignoreId);
    				})
    				->when($this->furtherCondition, function($query) {
    					return $query->whereRaw($this->furtherCondition);
    				})
    				->count();
    	
        return (bool) ($total === 0);
    }

    public function message()
    {
        return trans('validation.unique');
    }

    public function withFurtherCondition($column, $operator, $value)
    {
        $this->furtherCondition = $column . ' ' . $operator . ' ' . $value;

        return $this;
    }
}