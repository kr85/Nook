<?php

return array(
	'table' => 'social_login_tokens',
	'providers' => array(
		'google' => array(
			'id' => getenv('GOOGLE_CLIENT_ID'),
			'secret' => getenv('GOOGLE_CLIENT_SECRET'),
			'redirect' => URL::to('http://nook.com/google/login'),
			'scope' => array(),
		),
	)
);
