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

class Plain extends \Cawa\Html\Forms\Fields\Plain
{
    use FieldTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $label, string $content = null)
    {
        parent::__construct($label, $content);
        $this->getField()->addClass('form-control-static');
        $this->addClass('form-group');
    }
}
