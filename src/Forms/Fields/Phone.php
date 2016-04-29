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

namespace Cawa\Bootstrap\Forms\Fields;

class Phone extends \Cawa\Html\Forms\Fields\Phone
{
    use FieldTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name, $label);
        $this->getField()->addClass('form-control');
        $this->addClass('form-group');
        $this->setPlaceholder(null);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->renderBootstrapProperties();
    }
}
