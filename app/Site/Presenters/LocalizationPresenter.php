<?php
namespace App\Site\Presenters;

use Illuminate\Support\Facades\Schema;

trait LocalizationPresenter
{
    private function hasLocalizatedColumn($column)
	{
	    return Schema::hasColumn($this->getTable(), $column . config('site.locale_column_suffix'));
	}

    public function getDescriptionAttribute()
    {
        return $this->attributes['description' . ($this->hasLocalizatedColumn('description') ? config('site.locale_column_suffix') : null)];
    }

    public function getNameAttribute()
    {
        return $this->attributes['name' . ($this->hasLocalizatedColumn('name') ? config('site.locale_column_suffix') : null)];
    }
    
    public function getTitleAttribute()
    {
        return $this->attributes['title' . ($this->hasLocalizatedColumn('title') ? config('site.locale_column_suffix') : null)];
    }
    
    public function getTextAttribute()
    {
        return $this->attributes['text' . ($this->hasLocalizatedColumn('text') ? config('site.locale_column_suffix') : null)];
    }
}
