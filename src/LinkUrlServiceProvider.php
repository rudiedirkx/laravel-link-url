<?php

namespace rdx\linkurl;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\ServiceProvider;

class LinkUrlServiceProvider extends ServiceProvider {

	public function register() : void {
	}

	public function boot() : void {
		RedirectResponse::mixin(new RedirectResponseMixin());
	}

}
