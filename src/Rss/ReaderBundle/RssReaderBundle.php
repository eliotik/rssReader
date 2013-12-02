<?php

namespace Rss\ReaderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class RssReaderBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
