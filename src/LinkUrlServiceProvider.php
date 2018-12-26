<?php

namespace rdx\linkurl;

use Illuminate\Support\ServiceProvider;

class LinkUrlServiceProvider extends ServiceProvider {

	/**
	 * Register any application services.
	 */
	public function register() {
        $this->app->alias('html', HtmlBuilder::class);
		$this->app->singleton('html', function($app) {
			return new HtmlBuilder($app['url'], $app['view']);
		});

        $this->app->alias('url', HtmlBuilder::class);
		$this->app->singleton('url', function($app) {
			return new UrlGenerator($app['router']->getRoutes(), $app['request']);
		});
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot() {
	}

}
