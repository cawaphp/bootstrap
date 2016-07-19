<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types = 1);

namespace Cawa\Bootstrap\Components;

use Cawa\Renderer\HtmlContainer;

class ButtonGroup extends HtmlContainer
{
    const SIZE_LARGE = 'btn-group-lg';
    const SIZE_SMALL = 'btn-group-sm';
    const SIZE_XSMALL = 'btn-group-xs';

    /**
     * @param string $size
     */
    public function __construct(string $size = null)
    {
        parent::__construct('<div>');

        $this->addClass('btn-group');
        $this->addAttribute('role', 'group');

        if ($size) {
            $this->addClass($size);
        }
    }

    /**
     * @return bool
     */
    public function isJustified() : bool
    {
        return $this->hasClass('btn-group-justified');
    }

    /**
     * @param bool $justified
     *
     * @return $this
     */
    public function setJustified(bool $justified = true) : self
    {
        if ($justified) {
            $this->addClass('btn-group-justified');
        } else {
            $this->removeClass('btn-group-justified');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isVertical() : bool
    {
        return $this->hasClass('btn-group-vertical');
    }

    /**
     * @param bool $vertical
     *
     * @return $this
     */
    public function setVertical(bool $vertical = true) : self
    {
        if ($vertical) {
            $this->addClass('btn-group-vertical')
                ->removeClass('btn-group');
        } else {
            $this->removeClass('btn-group-vertical')
                ->addClass('btn-group');
        }

        return $this;
    }
}
