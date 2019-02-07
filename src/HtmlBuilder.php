<?php

namespace rdx\linkurl;

use Collective\Html\HtmlBuilder as BaseHtmlBuilder;

class HtmlBuilder extends BaseHtmlBuilder {

	protected $linkClass = Link::class;

	public function setLinkClass($class) {
		$this->linkClass = $class;
	}



	public function origLink($url, $title = null, $attributes = [], $secure = null, $escape = true) {
		return parent::link($url, $title, $attributes, $secure, $escape);
	}

	public function link($url, $title = null, $attributes = [], $secure = null, $escape = true) {
		$url = $this->url->to($url, [], $secure);

		$class = $this->linkClass;
		return new $class($url, $title, $attributes, $secure, $escape);
	}

	public function linkRoute($name, $title = null, $parameters = [], $attributes = []) {
		$class = $this->linkClass;
		return new $class($this->url->route($name, $parameters), $title, $attributes);
	}

}
