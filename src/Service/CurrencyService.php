<?php

declare(strict_types=1);

namespace App\Service;

use App\Client\NbpClient;
use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyService {
	private NbpClient $client;
	private CurrencyRepository $repository;
	private EntityManagerInterface $entityManager;

	public function __construct( NbpClient $client, CurrencyRepository $repository, EntityManagerInterface $entityManager ) {

		$this->client     = $client;
		$this->repository = $repository;
		$this->entityManager = $entityManager;
	}

	public function createOrUpdateCurrency( $ratesTable ): void {
		$currencyList = $this->currencyList();

		foreach ( $ratesTable->rates as $currentRate ) {
			if (! in_array($currentRate->code, $currencyList)) {
				$this->createCurrency($currentRate);
			} else{
				$this->updateCurrency( $currentRate);
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

	public function createCurrency( $currentRate ): void {

		$rate = (new Currency())
			->setName( $currentRate->currency )
			->setCurrencyCode( $currentRate->code )
			->setExchangeRateAsInt( $currentRate->mid );
		$this->entityManager->persist($rate);
		$this->entityManager->flush();
	}

	public function updateCurrency($currentRate): void {
		$currency = $this->repository->findOneBy(['currencyCode'=> $currentRate->code]);

		$currency->setName($currentRate->currency);
		$currency->setExchangeRateAsInt($currentRate->mid);
		$this->entityManager->flush();
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