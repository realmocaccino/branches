<?php
namespace App\Admin\Mails;

use App\Common\Mails\BaseMail as CommonBaseMail;

class BaseMail extends CommonBaseMail
{
    public function __construct()
    {
    	parent::__construct();
    }
}
