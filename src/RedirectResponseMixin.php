<?php

namespace rdx\linkurl;

class RedirectResponseMixin {

	public function fragment() {
		return function(?string $fragment = null) {
			$url = $this->getTargetUrl();
			$url = preg_replace('/#.+/', '', $url);
			if (strlen($fragment ?? '')) {
				$url .= '#' . $fragment;
			}

			$this->setTargetUrl($url);
			return $this;
		};
	}

	public function query() {
		return function(string $name, string $value) {
			$url = new Url($this->getTargetUrl());
			$url->query($name, $value);
			$this->setTargetUrl((string) $url);

			return $this;
		};
	}

}
