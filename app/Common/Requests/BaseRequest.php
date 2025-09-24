<?php
namespace App\Common\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
	protected $trim = true;
	
	protected $trimExcept = [
		'password'
	];
	
	protected function getTrimmedInput(array $input)
    {
        if($this->trim)
        {
            array_walk_recursive($input, function(&$item, $key)
            {
                if(is_string($item) && !in_array($key, $this->trimExcept))
                {
                    $item = trim($item);
                }
            });
        }
 
        return $input;
    }
    
    public function input($key = null, $default = null)
    {
        $input = $this->getInputSource()->all() + $this->query->all();
        $input = $this->getTrimmedInput($input);
 
        return data_get($input, $key, $default);
    }
}
