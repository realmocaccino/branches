<?php
namespace App\Site\Controllers;

use App\Site\Helpers\AwardsHelper;

use Illuminate\Http\Request;

class AwardsController extends BaseController
{
    protected $awardsHelper;

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->awardsHelper = new AwardsHelper($request->year);
        $this->abortIfAwardFileDoesNotExist();
    }

    public function index()
	{
		$this->head->setTitle('Melhores de ' . $this->awardsHelper->getYear());
		$this->head->setDescription('Confira os melhores jogos de  ' . $this->awardsHelper->getYear() . ' de acordo com as avaliações dos usuários');

		return $this->view('awards.index', [
		    'awards' => $this->awardsHelper->getAwards(),
            'currentYear' => $this->awardsHelper->getYear(),
		    'years' => $this->awardsHelper->getYears()
		]);
	}

    private function abortIfAwardFileDoesNotExist()
    {
        if (!$this->awardsHelper->doesAwardFileExist()) {
            abort(404);
        }
    }
}