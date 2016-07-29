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

namespace Cawa\Bootstrap\Forms\ExtendedFields;

use Cawa\Bootstrap\Forms\Fields\FieldTrait;
use Cawa\Html\Forms\Fields\AbstractField;
use Cawa\Intl\TranslatorFactory;

class CreditCardCvc extends AbstractField
{
    use TranslatorFactory;
    use FieldTrait;

    /**
     * @inheritDoc
     */
    public function __construct(string $name = null, string $label = null)
    {
        if (is_null($label)) {
            self::translator()->addFile(__DIR__ . '/../../../lang/global', 'bootstrap');
            $label = self::trans('bootstrap.creditcard/cvv');
        }

        parent::__construct('<input />', $name, $label);
        $this->getField()->addAttribute('type', 'text');

        $this->getField()->addClass('form-control');
        $this->addClass('form-group');

        $this->getField()->addClass('cawa-fields-creditcard-cvc cc-cvc');
        $this->getField()->addAttribute('autocomplete', 'off');
        $this->getField()->addAttribute('size', '4');
    }

    /**
     * @param CreditCard $card
     *
     * @return $this
     */
    public function setCardCredit(CreditCard $card) : self
    {
        if (!$card->getId()) {
            $card->generateId();
        }

        $this->getField()->addAttribute('data-creditcard-fields', $card->getId());

        return $this;
    }
}
