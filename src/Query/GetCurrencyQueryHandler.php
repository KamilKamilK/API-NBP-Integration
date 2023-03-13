<?php

namespace App\Query;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;


class GetCurrencyQueryHandler implements MessageHandlerInterface
{
	public function __construct(  ) {

	}
	public function __invoke( GetCurrencyQuery $query )
	{

	}
}