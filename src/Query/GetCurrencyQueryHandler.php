<?php

namespace App\Query;

use App\Repository\CurrencyRepository;
use App\Service\CurrencyService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class GetCurrencyQueryHandler implements MessageHandlerInterface
{
	private CurrencyService $service;
	private CurrencyRepository $repository;

	public function __construct( CurrencyService $service, CurrencyRepository $repository ) {

		$this->service = $service;
		$this->repository = $repository;
	}
	public function __invoke( GetCurrencyQuery $query )
	{
		$ratesTable = $this->service->getExchangeRatesTable($query->getTable());
		$this->service->createOrUpdateCurrency($ratesTable);

		return [
			'rates'        => $this->repository->findAll(),
			'tableNumber'  => $ratesTable->no,
			'updatingDate' => $ratesTable->effectiveDate
		];
	}
}