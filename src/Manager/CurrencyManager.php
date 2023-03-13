<?php

namespace App\Manager;

use App\Query\GetCurrencyQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class CurrencyManager
{
	private MessageBusInterface $messenger;

	public function __construct( MessageBusInterface $messenger ) {

		$this->messenger = $messenger;
	}
	public function getExchangeRatesTable( string $table )
	{
		$envelope = $this->messenger->dispatch(new GetCurrencyQuery($table));
		$aggregatedData = $envelope->last( HandledStamp::class )->getResult();

		return new JsonResponse([

		]);
	}
}