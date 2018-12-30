<?php

namespace rdx\linkurl;

interface Urlable {

	public function fragment($fragment);

	public function query($name, $value);

	public function withCsrf();

}
