<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types = 1);

namespace Cawa\Bootstrap\Grid;

use Cawa\Renderer\HtmlContainer;

class Row extends HtmlContainer
{
    /**
     *
     */
    public function __construct()
    {
        parent::__construct('<div>');
        $this->addClass('row');
    }
}
