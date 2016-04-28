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


use Cawa\Bootstrap\Forms\Fields\FieldTrait;
use Cawa\Html\Forms\Fields\AbstractField;

class Group extends \Cawa\Html\Forms\Group
{
    use FieldTrait;
    /**
     * @inheritdoc
     */
    public function __construct(string $label = null)
    {
        parent::__construct($label);
        $this->addClass('form-group');
        $this->container->addClass("row");
    }

    public function render()
    {
        /** @var AbstractField $element */
        foreach ($this->container->elements as $element) {
            $element->addClass("col-sm-" .  12 / sizeof($this->container->elements));
        }

        return $this->renderWrap();
    }
}
