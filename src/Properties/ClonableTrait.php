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

use DeepCopy\DeepCopy;

trait ClonableTrait
{
    private $clonable = false;

    /**
     * @return bool
     */
    public function isClonable() : bool
    {
        return $this->clonable;
    }

    /**
     * @param bool $clonable
     *
     * @return self
     */
    public function setClonable(bool $clonable) : self
    {
        $this->clonable = $clonable;

        return $this;
    }

    /**
     * @var int
     */
    private $cloneCount = 0;

    /**
     * @return self
     */
    private function clone() : self
    {
        if ($this->clonable) {
            $deepcopy = new DeepCopy();
            $clone = $deepcopy->copy($this);
            return $clone;
        } else {
            $this->cloneCount++;

            if ($this->cloneCount > 1) {
                throw new \RuntimeException('Too many render for altered element, you must enable cloning');
            }

            return $this;
        }
    }
}
