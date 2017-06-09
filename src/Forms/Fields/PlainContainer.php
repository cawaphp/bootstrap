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

namespace Cawa\Bootstrap\Forms\Fields;

class PlainContainer extends \Cawa\Html\Forms\Fields\PlainContainer
{
    use FieldTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $label = null)
    {
        parent::__construct($label);
        $this->getContainer()->addClass('form-control-static');
        $this->addClass('form-group');
    }
}
