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

namespace Cawa\Bootstrap\Forms;

use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class LabelIcon extends HtmlContainer
{
    /**
     * @param string $class
     */
    public function __construct(string $class = null)
    {
        parent::__construct('<span>');
        $this->addClass('input-group-addon');

        $element = new HtmlElement('<i>');
        $element->addClass($class);
        $this->add($element);
    }
}
