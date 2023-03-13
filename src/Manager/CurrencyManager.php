<?php

namespace App\Manager;

use App\Query\GetCurrencyQuery;
use App\Service\CurrencyService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CurrencyManager
{
	private MessageBusInterface $messenger;
	private CurrencyService $service;

	public function __construct( CurrencyService $service, MessageBusInterface $messenger ) {

		$this->messenger = $messenger;
		$this->service = $service;
	}
	public function getExchangeRatesTable( string $table ): JsonResponse {
		$envelope = $this->messenger->dispatch(new GetCurrencyQuery($table));
		$aggregatedData = $envelope->last( HandledStamp::class )->getResult();

		$rates = $this->service->mapRates( $aggregatedData['rates'] );

		return new JsonResponse ( [
			'tableNumber'  => $aggregatedData['tableNumber'],
			'updatingDate' => $aggregatedData['updatingDate'],
			'rates'        => $rates
		], Response::HTTP_OK, );
	}
}