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

use Cawa\Bootstrap\Forms\Fieldset;
use Cawa\Bootstrap\Forms\Group;
use Cawa\Intl\TranslatorFactory;

class CreditCardFieldset extends Fieldset
{
    use TranslatorFactory;

    /**
     * @param string $name
     */
    public function __construct(string $name = null)
    {
        self::translator()->addFile(__DIR__ . '/../../../lang/global', 'bootstrap');

        $this->addClass('cawa-fieldset-creditcard');

        $this
            ->add(($creditCard = new CreditCard($name ? $name . '[card]' : null))
                ->setRequired()
                ->setValue('4242424242424242')
            )
            ->add((new Group(''))
                ->add((new CreditCardExpiry($name ? $name . '[expiration]' : null))
                    ->setRequired()
                    ->setValue('01 / 18')
                )
                ->add((new CreditCardCvc($name ? $name . '[cvv]' : null))
                    ->setCardCredit($creditCard)
                    ->setRequired()
                    ->setValue('123')
                )
            )
        ;

        parent::__construct();
    }
}
