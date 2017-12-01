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

class ProgressBar extends HtmlContainer
{
    const SUCCESS = 'progress-bar-success';
    const INFO = 'progress-bar-info';
    const WARNING = 'progress-bar-warning';
    const DANGER = 'progress-bar-danger';

    /**
     * @param float $value
     * @param string $type
     * @param string $content
     */
    public function __construct(float $value, string $type = null, string $content = null)
    {
        parent::__construct('<div>', $content);
        $this->addAttributes([
            'class' => 'progress-bar',
            'role' => 'progressbar',
            'aria-valuenow' => (string) $value,
            'aria-valuemin' => (string) 0,
            'aria-valuemax' => (string) 100,
        ]);

        if ($type) {
            $this->addClass($type);
        }

        $this->addStyle('width: ' . $value . '%');
    }

    /**
     * @return float
     */
    public function getMin() : float
    {
        return (float) $this->getAttribute('aria-valuemin');
    }

    /**
     * @param float $min
     *
     * @return $this|self
     */
    public function setMin(float $min) : self
    {
        $this->addAttribute('aria-valuemin', (string) $min);

        return $this;
    }

    /**
     * @return float
     */
    public function getMax() : float
    {
        return (float) $this->getAttribute('aria-valuemax');
    }

    /**
     * @param float $max
     *
     * @return $this|self
     */
    public function setMax(float $max) : self
    {
        $this->addAttribute('aria-valuemax', (string) $max);

        return $this;
    }

    /**
     * @return bool
     */
    public function isStriped() : bool
    {
        return $this->hasClass('progress-bar-striped');
    }

    /**
     * @param bool $striped
     *
     * @return $this|self
     */
    public function setStriped(bool $striped = true) : self
    {
        if ($striped) {
            $this->addClass('progress-bar-striped');
        } else {
            $this->removeClass('progress-bar-striped');
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isAnimated() : bool
    {
        return $this->hasClass('active');
    }

    /**
     * @param bool $animated
     *
     * @return $this|self
     */
    public function setAnimated(bool $animated = true) : self
    {
        if ($animated) {
            $this->addClass('active');
        } else {
            $this->removeClass('active');
        }

        return $this;
    }
}
