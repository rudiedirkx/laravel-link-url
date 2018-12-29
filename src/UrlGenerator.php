<?php

namespace rdx\linkurl;

use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use InvalidArgumentException;

class UrlGenerator extends BaseUrlGenerator {

	protected $urlClass = Url::class;

	public function setUrlClass($class) {
		$this->urlClass = $class;
	}



	public function route($name, $parameters = [], $absolute = true) {
		if ($route = $this->routes->getByName($name)) {
			$class = $this->urlClass;
			return new $class($this->toRoute($route, $parameters, true), $absolute);
		}

		throw new InvalidArgumentException("Route [{$name}] not defined.");
	}

}
