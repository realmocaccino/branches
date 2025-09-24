<?php

namespace App\Site\Exceptions;

use App\Common\Exceptions\Handler as BaseHandler;
use App\Common\Helpers\Head;

use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class Handler extends BaseHandler
{
	protected function getHttpExceptionView(HttpExceptionInterface $e)
    {
		$this->setUpHead($e);

        return 'site.error.' . $e->getStatusCode();
    }

	private function setUpHead(HttpExceptionInterface $e)
	{
		$head = new Head();
		$head->disableSearchIndexing();

		switch($e->getStatusCode()) {
			case 404:
				$head->setTitle('Página não encontrada');
			break;
			case 500:
				$head->setTitle('Oops! Aconteceu algum erro');
			break;
			case 503:
				$head->setTitle('Estamos em uma breve manutenção');
			break;
		}

		View::share('head', $head);
	}
}
