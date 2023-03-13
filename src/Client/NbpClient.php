<?php

declare(strict_types=1);

namespace App\Client;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Unirest;

class NbpClient {
	public const NBP_URL = 'http://api.nbp.pl/api';
	public const HEADERS = [ 'Accept' => 'application/json' ];

	public function getCurrentExchangeRates( string $table ) {
		$url      = $this->buildUrl( $table );

		$response = Unirest\Request::get( $url, self::HEADERS );

		if ( empty( $response ) ) {
			throw new NotFoundHttpException( 'Something wrong with response from NBP' );
		}

		$response = json_decode( $response->raw_body );

		return array_values( $response )[0];
	}

	public function buildUrl( string $table ): string {
		return self::NBP_URL . '/exchangerates/tables/' . $table;
	}
}