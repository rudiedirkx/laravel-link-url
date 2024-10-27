<?php

namespace rdx\linkurl;

class Url {

	protected ?string $override = null;

	protected bool $absolute;
	protected ?string $scheme = null;
	protected ?string $host = null;
	protected ?int $port = null;
	protected ?string $user = null;
	protected ?string $pass = null;
	protected ?string $path = null;
	protected array $query = [];
	protected ?string $fragment = null;

	public function __construct(string $url, bool $absolute = true) {
		$this->absolute = $absolute;

		if ($url == '#') {
			$this->override = $url;
			return;
		}

		$parsed = parse_url($url);
		if (!$parsed) {
			$this->override = $url;
			return;
		}

		if (isset($parsed['query'])) {
			parse_str($parsed['query'], $query);
			$parsed['query'] = $query;
		}

		foreach ($parsed as $component => $value) {
			$this->$component = $value;
		}
	}



	/** @return $this */
	public function fragment(?string $fragment) {
		if (strlen($fragment ?? '')) {
			$this->fragment = $fragment;
		}
		else {
			$this->fragment = null;
		}

		return $this;
	}

	/** @return $this */
	public function query(string $name, ?string $value) {
		if ($value === null) {
			unset($this->query[$name]);
		}
		else {
			$this->query[$name] = $value;
		}

		return $this;
	}

	/** @return $this */
	public function withCsrf() {
		return $this->query('_token', csrf_token());
	}



	protected function buildScheme() : string {
		if ($this->scheme) {
			if ($this->scheme === 'mailto') {
				return $this->scheme . ':';
			}

			return $this->scheme . '://';
		}

		return '';
	}

	protected function buildOrigin() : string {
		if (!$this->absolute) {
			return '';
		}

		$scheme = $this->buildScheme();
		$host = $this->host;
		$port = $this->port ? ':' . $this->port : '';
		$user = $this->user;
		$pass = $this->pass ? ':' . $this->pass  : '';
		$pass = $user || $pass ? "$pass@" : '';

		return "$scheme$user$pass$host$port";
	}

	protected function build() : string {
		if ($this->override !== null) {
			return $this->override;
		}

		$origin = $this->buildOrigin();
		$path = $this->path;
		$query = $this->query ? '?' . http_build_query($this->query) : '';
		$fragment = $this->fragment ? '#' . $this->fragment : '';
		return "$origin$path$query$fragment";
	}

	public function __toString() {
		return $this->build();
	}

}
