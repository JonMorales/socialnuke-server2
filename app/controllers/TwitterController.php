<?php

class TwitterController extends BaseController {

	public function showTest() {
		echo('this is a test');
	}

	public function showTwitter() {
		$test = new SocialNuke\APIs\Twitter\TwitterOAuth('hPt7qgK7t1gutuGvbpKRtw', 'NGQu97Brv8rH0y6JAssay6SHxtnjbTBR6CXPUm6E');
		print_r($test);
		echo('hello');
	}

}