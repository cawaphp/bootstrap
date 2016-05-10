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
    const SIZE_LARGE = 'btn-lg';
    const SIZE_SMALL = 'btn-sm';
    const SIZE_XSMALL = 'btn-xs';

    const TYPE_DEFAULT = 'btn-default';
    const TYPE_PRIMARY = 'btn-primary';
    const TYPE_SUCCESS = 'btn-success';
    const TYPE_INFO = 'btn-info';
    const TYPE_WARNING = 'btn-warning';
    const TYPE_DANGER = 'btn-danger';

    /**
     * @param string $content
     * @param string $type
     * @param string $size
     */
    public function __construct(
        string $content,
        string $type = self::TYPE_DEFAULT,
        string $size = null
    ) {
        if (!$this->tag) {
            $this->tag = '<button>';
        }
        parent::__construct(null, $content);

        $this->addClass(['btn', $type]);

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
    public function setActive(bool $active = true) : self
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
    public function setDisabled(bool $disabled = true) : self
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
    public function setBlock(bool $block = true) : self
    {
        if ($block) {
            $this->addClass('btn-block');
        } else {
            $this->removeClass('btn-block');
        }

        return $this;
    }
}
