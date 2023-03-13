<?php

namespace App\Service;

use App\Client\NbpClient;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;

class CurrencyService {
	private NbpClient $client;
	private CurrencyRepository $repository;

	public function __construct( NbpClient $client, CurrencyRepository $repository ) {

		$this->client     = $client;
		$this->repository = $repository;
	}

	public function createOrUpdateCurrency( $ratesTable ): void {
		$currencyList = $this->currencyList();

		foreach ( $ratesTable->rates as $currentRate ) {
			$rate = $this->buildCurrency($currentRate);

			if (! in_array($currentRate->code, $currencyList)) {
				$this->repository->save($rate, true);
			} else{
				$this->repository->save($rate);
			}
		}
	}

	public function getExchangeRatesTable( string $table ) {
		return $this->client->getCurrentExchangeRates( $table );
	}

	public function currencyList(): array {
		$currencyList = [];
		foreach ( $this->getRates() as $rate ) {
			$currencyList[] = $rate->getCurrencyCode();
		}

		return $currencyList;
	}

	public function getRates(): array {
		return $this->repository->findAll();
	}

	public function buildCurrency( $currentRate ): Currency {
		return ( new Currency() )
			->setName( $currentRate->currency )
			->setCurrencyCode( $currentRate->code )
			->setExchangeRateAsInt( $currentRate->mid );
	}

	public function mapRates( $aggregatedData ): array {
		$arrayCollection = [];

		foreach ( $aggregatedData as $rate ) {
			$arrayCollection[] = [
				'id'           => $rate->getId(),
				'name'         => $rate->getName(),
				'currencyCode' => $rate->getCurrencyCode(),
				'exchangeRate' => $rate->getExchangeRateAsDecimal($rate->getExchangeRate())
			];
		}

		return $arrayCollection;
	}
}