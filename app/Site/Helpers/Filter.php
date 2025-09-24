<?php
namespace App\Site\Helpers;

use App\Site\Repositories\FilterRepository;
use App\Common\Helpers\{EntityFinder, Support};

use Exception;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Support\Facades\Route;
use MobileDetect;

class Filter
{
	private const CACHE_DURATION = 60 * 60 * 24;
	private const CACHE_PREFIX = 'filter_';

	private $agent;
	private $cache;
	private $filterRepository;

	private $actives = [];
	private $areRatings = false;
	private $disableOrder = false;
	private $filters = [
		'platform',
		'genre',
		'characteristic',
		'theme',
		'mode',
		'developer',
		'publisher',
		'franchise'
	];
	private $initial;
	private $order;
	private $perPage;
	private $query;

	public function __construct(MobileDetect $agent, CacheRepository $cache, FilterRepository $filterRepository)
	{
		$this->agent = $agent;
		$this->cache = $cache;
		$this->filterRepository = $filterRepository;
	}

	public function areRatings($areRatings = true)
	{
		$this->areRatings = $areRatings;

		return $this;
	}

	public function disableOrder()
	{
		$this->disableOrder = true;

		return $this;
	}

	public function excludeFilter(string $excludeFilter)
	{
		$this->excludeFilters([$excludeFilter]);

		return $this;
	}

	public function excludeFilters(array $excludeFilters)
	{
		$this->filters = array_diff($this->filters, $excludeFilters);

		return $this;
	}

	public function perPage(int $perPage)
	{
		$this->perPage = $perPage;

		return $this;
	}

	public function setQuery($query)
	{
		$this->query = $query;

		return $this;
	}

	public function count()
	{
		return count(clone $this->query->get());
	}

	public function first()
	{
		return (clone $this->query)->first();
	}
	
	public function get($simplePaginate = false)
	{
		$query = clone $this->query;

		if($this->perPage) {
			if($simplePaginate or $this->agent->isMobile()) {
				$query = $query->simplePaginate($this->perPage);
			} else {
				$query = $query->paginate($this->perPage);
			}

			return $query->appends(request()->query());
		}

		return $query->get();
	}

	public function getActives()
	{
		$actives = [];
		
		foreach($this->actives as $filter => $values) {
			foreach($values as $value) {
				$actives[] = $this->buildActive($filter, $value);
			}
		}
		
		if(count($actives) or $this->initial !== '') {
			$actives[] = $this->buildRemoveActives();
		}
		
		return $actives;
	}

	public function getAlphabet()
	{
		return $this->buildAlphabet();
	}

	public function getBars()
	{
		return [
			'actives' => $this->getActives(),
			'filterBars' => $this->getFilterBars(),
			'orderBar' => $this->getOrderBar()
		];
	}

	public function getBarsWithAlphabet()
	{
		return $this->getBars() + [
			'alphabet' => $this->getAlphabet(),
		];
	}

	public function getCover($size)
	{
		if($game = $this->first()) {
			return $game->getCover($size);
		}

		return null;
	}
	
	public function getFilterBars()
	{
		$bars = [];
		
		foreach($this->filters as $filter) {
			$bars[$filter] = $this->buildBar($filter);
		}
		
		return $bars;
	}

	public function getFilters()
	{
		return array_merge($this->filters, ['initial']);
	}

	public function getOrderBar()
	{
		return $this->order ? $this->buildOrderBar() : null;
	}

	public function getQuery()
	{
		return (clone $this->query);
	}
	
	public function prepare()
	{
		$this->setActives();
		if(!$this->disableOrder) {
			$this->setOrder();
		}
		$this->setInitial();
		$this->filter();
		if($this->isInitialSet()) {
			$this->filterByInitial();
		}
		if($this->isOrderSet()) {
			$this->order();
		}

		return $this;
	}

	private function buildActive($filter, $value)
	{
		$modelInstance = $this->getModelInstance($filter);
	
		return view('site.helpers.filter.active', [
			'url' => $this->getUrlForActive($filter, $value),
			'filter' => $filter,
			'value' => $modelInstance->findBySlugOrFail($value)->{Support::getLocalizatedColumn($modelInstance, 'name')}
		]);
	}

	private function buildAlphabet()
	{
		return view('site.helpers.filter.alphabet', [
			'initials' => array_merge(range('a', 'z'), range(0, 9)),
			'url' => $this->getUrlForAlphabetLetters(),
			'currentInitial' => $this->initial
		]);
	}
	
	private function buildBar($filter)
	{
		$modelInstance = $this->getModelInstance($filter);

		$query = $this->cache->remember(self::CACHE_PREFIX . $filter, self::CACHE_DURATION, function() use($filter, $modelInstance) {
			if(in_array($filter, ['developer', 'franchise', 'publisher'])) {
				return $modelInstance->withMoreThanTwoGames()->orderBy(Support::getLocalizatedColumn($modelInstance, 'name'), 'asc')->get();
			} elseif($filter == 'platform') {
				return $modelInstance->inRelevantOrder()->get();
			} else {
				return $modelInstance->orderBy(Support::getLocalizatedColumn($modelInstance, 'name'), $filter == 'mode' ? 'desc' : 'asc')->get();
			}
		});

		return view('site.helpers.filter.bar', [
			'actives' => $this->actives[$filter],
			'filter' => $filter,
			'query' => $query
		]);
	}

	private function buildOrderBar()
	{
		return view('site.helpers.filter.order_bar', [
			'current' => $this->order,
			'orders' => $this->getOrderOptions()
		]);
	}

	private function buildRemoveActives()
	{
		$url = url()->current();
		$term = request()->query('term');
		
		if($term) $url .= '?term=' . $term;
		
		return view('site.helpers.filter.clear', [
			'url' => $url
		]);
	}

	private function canOrderBasedOnPlatform()
	{
		return $this->order and $this->isListPage();
	}

	private function clearOriginalOrders()
	{
		$eloquentQuery = $this->query->getQuery();
		
		if(method_exists($eloquentQuery, 'getQuery')) {
			$eloquentQuery->getQuery()->orders = null;
		} else {
			$eloquentQuery->orders = null;
		}
	}

	private function filter()
	{
		$this->query = $this->query->distinct();

		foreach($this->actives as $filter => $values) {
			if($values) {
				switch($filter) {
				    case 'characteristic':
						$this->filterRepository->addCharacteristicsToQuery($this->query, $values);
					break;
					case 'developer':
						$this->filterRepository->addDevelopersToQuery($this->query, $values);
					break;
					case 'franchise':
						$this->filterRepository->addFranchisesToQuery($this->query, $values);
					break;
					case 'genre':
						$this->filterRepository->addGenresToQuery($this->query, $values);
					break;
					case 'mode':
						$this->filterRepository->addModesToQuery($this->query, $values);
					break;
					case 'platform':
						if($this->areRatings) {
							$this->filterRepository->addPlatformsToQueryBasedOnRatings($this->query, $values);
						} else {
							$this->filterRepository->addPlatformsToQuery($this->query, $values);	
							if($this->canOrderBasedOnPlatform()) {
								$this->clearOriginalOrders();
								$this->filterRepository->orderBasedOnPlatform($this->query, $values);
							}
						}
					break;
					case 'publisher':
						$this->filterRepository->addPublishersToQuery($this->query, $values);
					break;
					case 'theme':
						$this->filterRepository->addThemesToQuery($this->query, $values);
					break;
				}
			}
		}
	}

	private function filterByInitial()
	{
		$this->filterRepository->filterByInitial($this->query, $this->initial);
	}

	private function getModelInstance($filter)
	{
		if(!$modelInstance = EntityFinder::getModelInstanceByString($filter)) {
			throw new Exception(sprintf('Model %s does not exist.', $filter));
		}

		return $modelInstance;
	}

	private function getOrderOptions()
	{
		return [
		    'latest' => trans('helpers/filter.orders_latest'),
		    'older' => trans('helpers/filter.orders_older'),
		    'best-rated' => trans('helpers/filter.orders_best_rated'),
		    'worst-rated' => trans('helpers/filter.orders_worst_rated'),
		    'crescent-name' => trans('helpers/filter.orders_crescent_name'),
		    'descending-name' => trans('helpers/filter.orders_descending_name')
	    ];
	}

	private function getUrlForAlphabetLetters()
	{
		return preg_replace('/&?initial\=./', '', url()->full()) . (url()->current() == url()->full() ? '?' : '&');
	}

	private function getUrlForActive($filter, $value)
	{
		return preg_replace('/&?page\=[0-9]/', '', preg_replace("/&?$filter\[[0-9]?\]\=$value/", '', urldecode(url()->full())));
	}

	private function isDefaultOrder()
	{
		return $this->order == 'default';
	}

	private function isInitialSet()
	{
		return $this->initial !== '';
	}

	private function isListPage()
	{
		return Route::currentRouteName() != 'list';
	}

	private function isNextReleasesList()
	{
		return strstr(url()->full(), 'next-releases');
	}

	private function isOrderSet()
	{
		return $this->order;
	}

	private function order()
	{
		if(!$this->isDefaultOrder()) {
			$this->clearOriginalOrders();
		}
	
		switch($this->order) {
			case 'crescent-name':
				$this->filterRepository->orderByNameAscendent($this->query);
			break;
			case 'descending-name':
				$this->filterRepository->orderByNameDescendent($this->query);
			break;
			case 'latest':
				if($this->isNextReleasesList()) {
					$this->filterRepository->orderByReleaseAscendent($this->query);
				} else {
					$this->filterRepository->orderByReleaseDescendent($this->query);
				}
			break;
			case 'older':
				if($this->isNextReleasesList()) {
					$this->filterRepository->orderByReleaseDescendent($this->query);
				} else {
					$this->filterRepository->orderByReleaseAscendent($this->query);
				}
			break;
			case 'best-rated':
				if($this->areRatings) {
					$this->filterRepository->orderByBestRated($this->query);
				} else {
					if(isset($this->actives['platform']) and $this->actives['platform']) {
						$scoreColumn = 'filter_platform_game.score';
						$totalColumn = 'filter_platform_game.total';
					} else {
						$scoreColumn = 'games.score';
						$totalColumn = 'games.total_ratings';
					}
					$this->filterRepository->orderByBestRatedSettingColumns($this->query, $scoreColumn, $totalColumn);
				}
			break;
			case 'worst-rated':
				if($this->areRatings) {
					$this->filterRepository->orderByWorstRated($this->query);
				} else {
					if(isset($this->actives['platform']) and $this->actives['platform']) {
						$scoreColumn = 'filter_platform_game.score';
						$totalColumn = 'filter_platform_game.total';
					} else {
						$scoreColumn = 'games.score';
						$totalColumn = 'games.total_ratings';
					}
					$this->filterRepository->orderByWorstRatedSettingColumns($this->query, $scoreColumn, $totalColumn);
				}
			break;
		}
	}

	private function setActives()
	{
		foreach($this->filters as $filter) {
			$this->actives[$filter] = request()->query($filter) ?: [];
		}
	}

	private function setInitial()
	{
		$this->initial = (string) request()->query('initial');
	}

	private function setOrder()
	{
		$this->order = request()->query('order') ?? 'default';
	}
}