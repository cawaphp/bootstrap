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

namespace Cawa\Bootstrap\Properties;

use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Renderer\HtmlElement;

/**
 * @mixin HtmlElement
 */
trait ButtonTrait
{
    /**
     * @return HtmlElement
     */
    private function getButton() : HtmlElement
    {
        if ($this instanceof AbstractField) {
            return $this->getField();
        } else {
            return $this;
        }
    }

    /**
     * @return bool
     */
    public function isBlock() : bool
    {
        return $this->getButton()->hasClass('btn-block');
    }

    /**
     * @param bool $block
     *
     * @return $this|self
     */
    public function setBlock(bool $block = true) : self
    {
        if ($block) {
            $this->getButton()->addClass('btn-block');
        } else {
            $this->getButton()->removeClass('btn-block');
        }

        return $this;
    }
}
