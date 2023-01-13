<?php

namespace rdx\linkurl;

use Illuminate\Support\ServiceProvider;
use TwigBridge\Bridge;
use Twig\Extension\EscaperExtension;

class LinkUrlServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register() {
		$this->app->alias('html', HtmlBuilder::class);
		$this->app->alias('url', UrlGenerator::class);

		$this->app->singleton('url', function ($app) {
			$routes = $app['router']->getRoutes();

			$app->instance('routes', $routes);

			return new UrlGenerator(
				$routes,
				$app->rebinding('request', function($app, $request) {
					$app['url']->setRequest($request);
				}),
				$app['config']['app.asset_url'],
			);
		});

		$this->app->extend('html', function($service, $app) {
			return new HtmlBuilder($app['url'], $app['view']);
		});

		$this->app->extend('redirect', function($service, $app) {
			$redirector = new Redirector($app['url']);

			if (isset($app['session.store'])) {
				$redirector->setSession($app['session.store']);
			}

			return $redirector;
		});

		$this->callAfterResolving('twig', function(Bridge $twig) {
			$twig->getExtension(EscaperExtension::class)->addSafeClass(Link::class, ['html']);
		});
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
	}

}
