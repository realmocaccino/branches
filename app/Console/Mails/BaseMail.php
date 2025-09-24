<?php
namespace App\Console\Mails;

use App\Common\Mails\BaseMail as CommonBaseMail;

class BaseMail extends CommonBaseMail
{
    public function __construct()
    {
    	parent::__construct();
    }
}