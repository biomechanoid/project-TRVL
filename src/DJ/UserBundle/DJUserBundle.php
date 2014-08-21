<?php

namespace DJ\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DJUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
