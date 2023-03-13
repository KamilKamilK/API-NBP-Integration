<?php

namespace App\Service;

use App\Client\NbpClient;

class CurrencyService
{
	private NbpClient $client;

	public function __construct( NbpClient $client ) {

		$this->client = $client;
	}

	public function getExchangeRatesTable( string $table ) {
		return $this->client->getCurrentExchangeRates( $table );
	}
}