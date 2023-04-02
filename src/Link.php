<?php

namespace rdx\linkurl;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Traits\Macroable;

class Link implements Htmlable {

	use Macroable;

	protected Url $url;
	protected ?string $title;
	protected array $attributes;
	protected ?bool $secure;
	protected bool $escape;

	public function __construct(string|Url $url, ?string $title = null, array $attributes = [], ?bool $secure = null, bool $escape = true) {
		$this->url = $url instanceof Url ? $url : new Url($url);
		$this->title = $title;
		$this->attributes = $attributes;
		$this->secure = $secure;
		$this->escape = $escape;
	}



	/**
	 * LINK properties
	 */

	public function html(bool $html = true) {
		$this->escape = !$html;

		return $this;
	}

	public function blank(bool $blank = true) {
		return $this->set('target', $blank ? '_blank' : null);
	}

	public function class(string $name) {
		return $this->add('class', $name);
	}

	public function add(string $name, ?string $value) {
		if ($value !== null) {
			isset($this->attributes[$name]) or $this->attributes[$name] = '';
			$this->attributes[$name] = trim($this->attributes[$name] . ' ' . $value);
		}

		return $this;
	}

	public function set(string $name, ?string $value) {
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

	public function secure(bool $secure) {
		$this->secure = $secure;

		return $this;
	}

	public function fragment(?string $fragment) {
		$this->url->fragment($fragment);

		return $this;
	}

	public function query(string $name, ?string $value) {
		$this->url->query($name, $value);

		return $this;
	}

	public function withCsrf() {
		$this->url->withCsrf();

		return $this;
	}



	public function toHtml() {
		return app('html')->link((string) $this->url, $this->title, $this->attributes, $this->secure, $this->escape);
	}

	public function __toString() {
		return $this->toHtml();
	}

}
