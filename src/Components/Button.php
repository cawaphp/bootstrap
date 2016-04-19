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

use Cawa\Renderer\HtmlElement;

class Button extends HtmlElement
{
    const TAG_BUTTON = '<button>';
    const TAG_A = '<a>';

    const SIZE_LARGE = 'btn-lg';
    const SIZE_SMALL = 'btn-sm';
    const SIZE_XSMALL = 'btn-xs';

    const DEFAULT = 'btn-default';
    const PRIMARY = 'btn-primary';
    const SUCCESS = 'btn-success';
    const INFO = 'btn-info';
    const WARNING = 'btn-warning';
    const DANGER = 'btn-danger';

    /**
     * @param string $content
     * @param string $type
     * @param string $size
     * @param string $tag
     */
    public function __construct(
        string $content,
        string $type = self::DEFAULT,
        string $size = null,
        string $tag = self::TAG_BUTTON
    ) {
        parent::__construct($tag, $content);

        $this->addClass(['btn', $type]);

        if ($tag == self::TAG_A) {
            $this->addAttribute('role', 'button');
        }

        if ($size) {
            $this->addClass($size);
        }
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->hasClass('active');
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active = true)
    {
        if ($active) {
            $this->addClass('active');
        } else {
            $this->removeClass('active');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled() : bool
    {
        if ($this->getTag() == self::TAG_A) {
            return $this->hasClass('disabled');
        } else {
            return $this->hasAttribute('disabled');
        }
    }

    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled = true)
    {
        if ($this->getTag() == self::TAG_A) {
            if ($disabled) {
                $this->addClass('disabled');
            } else {
                $this->removeClass('disabled');
            }
        } else {
            if ($disabled) {
                $this->addAttribute('disabled', 'disabled');
            } else {
                $this->removeAttribute('disabled');
            }
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isBlock() : bool
    {
        return $this->hasClass('btn-block');
    }

    /**
     * @param bool $block
     *
     * @return $this
     */
    public function setBlock(bool $block = true)
    {
        if ($block) {
            $this->addClass('btn-block');
        } else {
            $this->removeClass('btn-block');
        }

        return $this;
    }
}
