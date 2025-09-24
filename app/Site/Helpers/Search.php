<?php
namespace App\Site\Helpers;

use App\Site\Repositories\SearchRepository;
use App\Common\Helpers\Number;

class Search
{
	protected $searchRepository;

	protected $fromUsers = false;
	protected $perPage;
	protected $query;
	protected $term;

	public function __construct(SearchRepository $searchRepository)
	{
		$this->searchRepository = $searchRepository;
	}

	public function fromUsers($fromUsers = true)
	{
		$this->fromUsers = $fromUsers;

		return $this;
	}

	public function setTerm($term)
	{
		$this->term = trim($term);

		return $this;
	}

	public function perPage($perPage)
	{
		$this->perPage = $perPage;

		return $this;
	}

	public function count()
	{
		$this->setQuery();

		return (clone $this->query)->count();
	}

	public function get()
	{
		$this->setQuery();
		
		return (clone $this->query)->paginate($this->perPage)->appends(request()->query());
	}

	public function getQuery()
	{
		$this->setQuery();
		
		return (clone $this->query);
	}

	protected function setQuery()
	{
		if($this->query) {
			return;
		}
		$this->query = $this->fromUsers ? $this->searchRepository->getUsersQuery($this->term) : $this->searchRepository->getGamesQuery(
			$this->term,
			$this->getTermInRoman($this->term),
			$this->getTermOfFranchise($this->term)
		);
	}

	private function getTermInRoman($term)
	{
		return Number::checkArabic($term) ? trim(Number::arabic2roman($term)) : null;
	}

	private function getTermOfFranchise($term)
	{
		$termWithoutVersion = trim(preg_replace('/\d+$/', '', $term));
		
		if($franchise = $this->searchRepository->getFranchise($termWithoutVersion)) {
			preg_match('/\d+$/', $term, $version);
			
			if($version) {
				return $franchise->name . ' ' . Number::arabic2roman($version[0]);
			}
			
			return $franchise->name;
		}
		
		return null;
	}
}