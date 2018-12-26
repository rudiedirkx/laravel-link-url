<?php

namespace rdx\linkurl;

use Illuminate\Routing\UrlGenerator as BaseUrlGenerator;
use InvalidArgumentException;

class UrlGenerator extends BaseUrlGenerator {

	public function route($name, $parameters = [], $absolute = true) {
		if ($route = $this->routes->getByName($name)) {
			return new Url($this->toRoute($route, $parameters, true), $absolute);
		}

		throw new InvalidArgumentException("Route [{$name}] not defined.");
	}

}
