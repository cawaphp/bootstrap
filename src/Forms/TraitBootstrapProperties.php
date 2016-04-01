<?php

/*
 * This file is part of the Сáша framework.
 *
 * (c) tchiotludo <http://github.com/tchiotludo>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare (strict_types=1);

namespace Cawa\Bootstrap\Forms;

trait TraitBootstrapProperties
{
    /**
     * @var int
     */
    private $gridSize;

    /**
     * @return int
     */
    public function getGridSize()
    {
        return $this->gridSize;
    }

    /**
     * @param int $gridSize
     *
     * @return $this
     */
    public function setGridSize(int $gridSize) : self
    {
        $this->gridSize = $gridSize;

        return $this;
    }

    /**
     * @var bool
     */
    private $inline = false;

    /**
     * @return bool
     */
    public function getInline() : bool
    {
        return $this->inline;
    }

    /**
     * @param bool $inline
     *
     * @return $this
     */
    public function setInline(bool $inline) : self
    {
        $this->inline = $inline;

        return $this;
    }
}
