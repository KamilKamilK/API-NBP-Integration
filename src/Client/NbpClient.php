<?php

namespace App\Client;

use Unirest;

class NbpClient
{
	public const NBP_URL = 'http://api.nbp.pl/api';
	public const HEADERS = ['Accept' => 'application/json'];
	public function getCurrentExchangeRates( string $table )
	{
		$url = $this->buildUrl($table);
		$response = Unirest\Request::get($url, self::HEADERS);

		$response = json_decode($response->raw_body);

		return $response;
	}

	public function buildUrl( $table )
	{
		return self::NBP_URL . '/exchangerates/tables/' . $table;
	}
}