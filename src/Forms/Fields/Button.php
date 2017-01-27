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

namespace Cawa\Bootstrap\Forms\Fields;

use Cawa\Bootstrap\Properties\ButtonInterface;
use Cawa\Bootstrap\Properties\ButtonTrait;

class Button extends \Cawa\Html\Forms\Fields\Button implements ButtonInterface
{
    use ButtonTrait;
    use FieldTrait {
        FieldTrait::layout as private fieldTraitLayout;
    }

    /**
     * {@inheritdoc}
     */
    public function __construct(string $value)
    {
        parent::__construct($value);
        $this->getField()->addClass(['btn', 'btn-primary']);
        $this->addClass('form-group');
    }

    /**
     * @param string $type
     *
     * @return $this|self
     */
    public function setDisplayType(string $type) : self
    {
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getConstants() as $key => $value) {
            if (strpos($key, 'TYPE_') !== false) {
                $this->getField()->removeClass($value);
            }
        }

        $this->getField()->addClass($type);

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
