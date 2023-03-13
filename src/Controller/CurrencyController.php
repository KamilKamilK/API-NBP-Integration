<?php

namespace App\Controller;

use App\Manager\CurrencyManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class CurrencyController extends AbstractController {
	private CurrencyManager $manager;

	public function __construct( CurrencyManager $manager ) {

		$this->manager = $manager;
	}

	#[Route( '/currency/{table}', name: 'app_currency', requirements: [ 'table' => 'A' ], methods: 'GET' )]
	public function getExchangeRatesTable( string $table ): JsonResponse {

		return $this->manager->getExchangeRatesTable( $table );
	}
}
