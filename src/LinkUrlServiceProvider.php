<?php

namespace rdx\linkurl;

use Illuminate\Support\ServiceProvider;

class LinkUrlServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register() {
		$this->app->alias('html', HtmlBuilder::class);
		$this->app->alias('url', UrlGenerator::class);

		$this->app->extend('url', function($service, $app) {
			$service = new UrlGenerator($app['router']->getRoutes(), $app['request']);
			$this->app->instance('url', $service);
			return $service;
		});

		$this->app->extend('html', function($service, $app) {
			return new HtmlBuilder($app['url'], $app['view']);
		});

		$this->app->extend('redirect', function($service, $app) {
			return new Redirector($app['url'], $app['session.store'] ?? null);
		});
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
	}

}
