<?php
namespace App\Admin\Scopes;

use Illuminate\Support\Facades\Schema;

class BaseScope
{
    protected $tableName;
    private $qualifiedSeparator = '.';

    protected function applyIfIsInThePage()
    {
        return $this->tableName == request()->path();
    }

    protected function getColumnName($column)
    {
        if($this->hasColumn($column)) {
            return $this->tableName . $this->qualifiedSeparator . $column;
        } elseif($localizedColumn = $this->getLocalizedColumn($column)) {
            return $localizedColumn;
        }

        return null;
    }

    private function getLocalizedColumn($column)
    {
        $localizedColumn = $column . '_' . config('app.locale');

        if($this->hasColumn($localizedColumn)) {
            return $this->tableName . $this->qualifiedSeparator . $localizedColumn;
        }

        return null;
    }

    private function hasColumn($column)
    {
        return Schema::hasColumn($this->tableName, $column);
    }

    protected function setTableName($tableName)
    {
        $this->tableName = $tableName;
    }
}