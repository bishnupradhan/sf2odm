<?php

namespace B2\AccountBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class B2AccountBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
