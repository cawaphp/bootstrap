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

use Cawa\Html\LinkTrait;

class ButtonLink extends Button
{
    use LinkTrait;

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
        $this->tag = '<a>';
        $this->addAttribute('role', 'button');

        parent::__construct($content, $type, $size);
    }

    /**
     * @return bool
     */
    public function isDisabled() : bool
    {
        return $this->hasClass('disabled');
    }

    /**
     * @param bool $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled = true) : parent
    {
        if ($disabled) {
            $this->addClass('disabled');
        } else {
            $this->removeClass('disabled');
        }

        return $this;
    }
}
