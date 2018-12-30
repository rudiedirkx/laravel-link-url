<?php

namespace rdx\linkurl;

use Illuminate\Http\RedirectResponse as BaseRedirectResponse;

class RedirectResponse extends BaseRedirectResponse implements Urlable {

	protected $url;

	public function __construct($url, $status = 302, $headers = array()) {
		parent::__construct($url, $status, $headers);

		$this->url = new Url($url);
	}

	public function setTargetUrl($url) {
		parent::setTargetUrl((string) $url);
	}

	public function fragment($fragment) {
		$this->url->fragment($fragment);
		$this->setTargetUrl((string) $this->url);

		return $this;
	}

	public function query($name, $value) {
		$this->url->query($name, $value);
		$this->setTargetUrl((string) $this->url);

		return $this;
	}

	public function withCsrf() {
		// No. That makes no sense.

		return $this;
	}

}
