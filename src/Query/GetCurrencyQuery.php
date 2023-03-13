<?php

declare(strict_types=1);

namespace App\Query;

class GetCurrencyQuery {
	private string $table;

	public function __construct( string $table ) {
		$this->table = $table;
	}

	public function getTable(): string {
		return $this->table;
	}

	public function setTable( string $table ): self {
		$this->table = $table;

		return $this;
	}
}