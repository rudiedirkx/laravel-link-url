<?php

namespace rdx\linkurl;

use Collective\Html\HtmlBuilder as BaseHtmlBuilder;

class HtmlBuilder extends BaseHtmlBuilder {

	public function linkRoute($name, $title = null, $parameters = [], $attributes = []) {
		return new Link($this->url->route($name, $parameters), $title, $attributes);
	}

}
