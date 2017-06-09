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

namespace Cawa\Bootstrap\Components;

use Cawa\Renderer\HtmlContainer;
use Cawa\Renderer\HtmlElement;

class Description extends HtmlContainer
{
    /**
     * @param array $keyValue
     */
    public function __construct(array $keyValue = [])
    {
        parent::__construct('<dl>');

        foreach ($keyValue as $key => $value) {
            $this->addDescription($key, $value);
        }
    }

    /**
     * @param string $key
     * @param string $value
     *
     * @return $this|self
     */
    public function addDescription(string $key, string $value) : self
    {
        $this->add((new HtmlElement('<dt>', $key)));
        if ($value) {
            $this->add((new HtmlElement('<dd>', $value)));
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHorizontal() : bool
    {
        return $this->hasClass('dl-horizontal');
    }

    /**
     * @param bool $horizontal
     *
     * @return $this|self
     */
    public function setHorizontal(bool $horizontal = true)
    {
        if ($horizontal) {
            $this->addClass('dl-horizontal');
        } else {
            $this->removeClass('dl-horizontal');
        }

        return $this;
    }
}
