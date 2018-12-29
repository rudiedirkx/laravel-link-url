<?php

namespace rdx\linkurl;

use Illuminate\Support\HtmlString;

class Link extends HtmlString {

	protected $url;
	protected $title;
	protected $attributes;
	protected $secure;
	protected $escape;

	public function __construct($url, $title = null, $attributes = [], $secure = null, $escape = true) {
		$this->url = $url instanceof Url ? $url : new Url($url);
		$this->title = $title;
		$this->attributes = $attributes;
		$this->secure = $secure;
		$this->escape = $escape;
	}



	/**
	 * LINK properties
	 */

	public function add($name, $value) {
		if ($value !== null) {
			isset($this->attributes[$name]) or $this->attributes[$name] = '';
			$this->attributes[$name] = trim($this->attributes[$name] . ' ' . $value);
		}

		return $this;
	}

	public function set($name, $value) {
		if ($value === null) {
			unset($this->attributes[$name]);
		}
		else {
			$this->attributes[$name] = $value;
		}

		return $this;
	}



	/**
	 * URL properties
	 */

	public function fragment($fragment) {
		$this->url->fragment($fragment);

		return $this;
	}

	public function query($name, $value) {
		$this->url->query($name, $value);

		return $this;
	}

	public function withCsrf() {
		$this->url->withCsrf();

		return $this;
	}



	public function build() {
		return app('html')->origLink((string) $this->url, $this->title, $this->attributes, $this->secure, $this->escape);
	}

	public function __toString() {
		return (string) $this->build();
	}

}
