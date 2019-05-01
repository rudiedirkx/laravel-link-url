<?php

namespace rdx\linkurl;

class Url implements Urlable {

	protected $override;

	protected $absolute;
	protected $scheme;
	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $path;
	protected $query;
	protected $fragment;

	public function __construct($url, $absolute = true) {
		$this->absolute = $absolute;

		$parsed = parse_url((string) $url);
		if (!$parsed) {
			$this->override = $url ?? '';
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



	public function fragment($fragment) {
		if (trim($fragment) == '') {
			unset($this->fragment);
		}
		else {
			$this->fragment = $fragment;
		}

		return $this;
	}

	public function query($name, $value) {
		if ($value === null) {
			unset($this->query[$name]);
		}
		else {
			$this->query[$name] = $value;
		}

		return $this;
	}

	public function withCsrf() {
		return $this->query('_token', csrf_token());
	}



	protected function buildScheme() {
		if ($this->scheme) {
			if ($this->scheme === 'mailto') {
				return $this->scheme . ':';
			}

			return $this->scheme . '://';
		}
	}

	protected function buildOrigin() {
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

	protected function build() {
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
