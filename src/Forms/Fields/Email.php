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

class Email extends \Cawa\Html\Forms\Fields\Email
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
    }

    /**
     * @return bool
     */
    public function isValid() : bool
    {
        return filter_var($this->getValue(), FILTER_VALIDATE_EMAIL) !== false;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->renderWrap();
    }
}
