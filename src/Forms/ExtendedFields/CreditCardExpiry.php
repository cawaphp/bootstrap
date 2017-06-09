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

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\FieldTrait;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Intl\TranslatorFactory;

class CreditCardExpiry extends AbstractField
{
    use TranslatorFactory;
    use FieldTrait;

    /**
     * {@inheritdoc}
     */
    public function __construct(string $name = null, string $label = null)
    {
        if (is_null($label)) {
            self::translator()->addFile(__DIR__ . '/../../../lang/global', 'bootstrap');
            $label = self::trans('bootstrap.creditcard/expiration');
        }

        parent::__construct('<input />', $name, $label);
        $this->getField()->addAttribute('type', 'text');

        $this->getField()->addClass('form-control');
        $this->addClass('form-group');

        $this->setPlaceholder(self::trans('bootstrap.creditcard/expirationPlaceholder'));
        $this->getField()->addClass('cawa-fields-creditcard-expiry cc-exp');
        $this->getField()->addAttribute('autocomplete', 'cc-exp');
    }
}
