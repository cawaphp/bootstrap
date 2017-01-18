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

use Cawa\Bootstrap\Interfaces\ButtonInterface;
use Cawa\Renderer\HtmlElement;

class Button extends HtmlElement implements ButtonInterface
{
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
     * @return $this|self
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
        return $this->hasAttribute('disabled');
    }

    /**
     * @param bool $disabled
     *
     * @return $this|self
     */
    public function setDisabled(bool $disabled = true) : self
    {
        if ($disabled) {
            $this->addAttribute('disabled', 'disabled');
        } else {
            $this->removeAttribute('disabled');
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
     * @return $this|self
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
