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

use Cawa\Bootstrap\Forms\Fields\Checkbox;
use Cawa\Bootstrap\Forms\Fieldset;
use Cawa\Bootstrap\Forms\Group;
use Cawa\Intl\TranslatorFactory;

class CreditCardFieldset extends Fieldset
{
    use TranslatorFactory;

    /**
     * @param string $name
     * @param bool $save
     */
    public function __construct(string $name = null, bool $save = false)
    {
        self::translator()->addFile(__DIR__ . '/../../../lang/global', 'bootstrap');

        $this->addClass('cawa-fieldset-creditcard');

        $this
            ->add(($creditCard = new CreditCard($name ? $name . '[card]' : null))
                ->setRequired()
            )
            ->add((new Group(''))
                ->add((new CreditCardExpiry($name ? $name . '[expiration]' : null))
                    ->setRequired()
                )
                ->add((new CreditCardCvc($name ? $name . '[cvv]' : null))
                    ->setCardCredit($creditCard)
                    ->setRequired()
                )
            )
        ;

        if ($save) {
            $this->add($saveCheckbox = (new Checkbox(
                $name ? $name . '[save]' : 'saveCard',
                self::trans('bootstrap.creditcard/save'),
                '1'))
            );

            $saveCheckbox->getField()->addClass('cc-save');
        }

        parent::__construct();
    }
}
