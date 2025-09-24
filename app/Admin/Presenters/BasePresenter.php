<?php
namespace App\Admin\Presenters;

use App\Common\Presenters\BasePresenter as Presenter;
use App\Admin\Scopes\SearchableScope;
use App\Admin\Scopes\SortableScope;

use Illuminate\Support\Facades\Schema;

trait BasePresenter
{
	use Presenter;
	
	protected static function boot()
    {
        parent::boot();
        
		static::addGlobalScope(new SearchableScope);
		static::addGlobalScope(new SortableScope);
    }
    
	public function getExtensiveUpdatedAtAttribute()
    {
		return $this->updated_at->format('d M Y \à\s H:i');
    }
    
    public function filter($relationship, $column, $value)
	{
		if(isset($relationship, $column, $value)) {
			return $this->whereHas($relationship, function($query) use($relationship, $column, $value) {
				$table = Schema::hasTable($relationship) ? $relationship : $relationship . 's';
				
				$query->where($table . '.' . $column, $value);
			});
		} else {
			return $this;
		}
	}
}
