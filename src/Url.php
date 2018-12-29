<?php

namespace rdx\linkurl;

class Url {

	protected $scheme;
	protected $host;
	protected $port;
	protected $user;
	protected $pass;
	protected $path;
	protected $query;
	protected $fragment;

	public function __construct($url) {
		$parsed = parse_url((string) $url);

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

	protected function build() {
		$scheme		= $this->buildScheme();
		$host		= $this->host;
		$port		= $this->port ? ':' . $this->port : '';
		$user		= $this->user;
		$pass		= $this->pass ? ':' . $this->pass  : '';
		$pass		= $user || $pass ? "$pass@" : '';
		$path		= $this->path;
		$query		= $this->query ? '?' . http_build_query($this->query) : '';
		$fragment	= $this->fragment ? '#' . $this->fragment : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}

	public function __toString() {
		return $this->build();
	}

}
