<?php

namespace rdx\linkurl;

class Url {

	protected $url;
	protected $absolute;

	public function __construct($url) {
		$this->url = parse_url((string) $url);
	}

	public function fragment($fragment) {
		if (trim($fragment) == '') {
			unset($this->url['fragment']);
		}
		else {
			$this->url['fragment'] = $fragment;
		}

		return $this;
	}

	public function build() {
		$scheme		= isset($this->url['scheme']) ? $this->url['scheme'] . '://' : '';
		$host		= isset($this->url['host']) ? $this->url['host'] : '';
		$port		= isset($this->url['port']) ? ':' . $this->url['port'] : '';
		$user		= isset($this->url['user']) ? $this->url['user'] : '';
		$pass		= isset($this->url['pass']) ? ':' . $this->url['pass']  : '';
		$pass		= $user || $pass ? "$pass@" : '';
		$path		= isset($this->url['path']) ? $this->url['path'] : '';
		$query		= isset($this->url['query']) ? '?' . $this->url['query'] : '';
		$fragment	= isset($this->url['fragment']) ? '#' . $this->url['fragment'] : '';
		return "$scheme$user$pass$host$port$path$query$fragment";
	}

	public function __toString() {
		return $this->build();
	}

}
