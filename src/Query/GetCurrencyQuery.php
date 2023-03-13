<?php

namespace App\Query;

class GetCurrencyQuery {
	private ?string $table;

	public function __construct( ?string $table = null ) {
		$this->table = $table;
	}

	public function getTable(): ?string {
		return $this->table;
	}

	public function setTable( ?string $table ): self {
		$this->table = $table;

		return $this;
	}
}