<?php

namespace DJ\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class DJAdminBundle extends Bundle
{
    public function getParent()
    {
        return 'SonataAdminBundle';
    }
}
