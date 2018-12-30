<?php

namespace rdx\linkurl;

use Illuminate\Routing\Redirector as BaseRedirector;
use Illuminate\Session\Store as SessionStore;

class Redirector extends BaseRedirector {

	public function __construct(UrlGenerator $generator, SessionStore $session = null) {
		parent::__construct($generator);

		$this->session = $session;
	}

	protected function createRedirect($path, $status, $headers) {
		$redirect = new RedirectResponse($path, $status, $headers);
		if (isset($this->session)) {
			$redirect->setSession($this->session);
		}

		$redirect->setRequest($this->generator->getRequest());
		return $redirect;
	}

}
