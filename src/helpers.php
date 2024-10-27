<?php

use rdx\linkurl\Link;
use rdx\linkurl\Url;

function linkurl_to_route(string $name, ?string $title = null, array $parameters = [], array $attributes = []) : Link {
	$url = app('url')->route($name, $parameters);
	return new Link($url, $title, $attributes);
}

function linkurl_to(string $url, ?string $title = null, array $attributes = []) : Link {
	return new Link($url, $title, $attributes);
}

function routeurl(string $name, $parameters = []) : Url {
	$url = app('url')->route($name, $parameters);
	return new Url($url);
}
