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

use Cawa\Bootstrap\Forms\Fields\Text;
use Cawa\Html\Forms\Fields\Select;
use Cawa\Renderer\HtmlContainer;

class Color extends Text
{
    public function __construct(string $name, string $label = null, array $options = [])
    {
        parent::__construct($name, $label);

        if (sizeof($options) == 0) {
            $options = [
                '#0033CC' => '#0033CC',
                '#428BCA' => '#428BCA',
                '#44AD8E' => '#44AD8E',
                '#A8D695' => '#A8D695',
                '#5CB85C' => '#5CB85C',
                '#69D100' => '#69D100',
                '#004E00' => '#004E00',
                '#34495E' => '#34495E',
                '#7F8C8D' => '#7F8C8D',
                '#A295D6' => '#A295D6',
                '#5843AD' => '#5843AD',
                '#8E44AD' => '#8E44AD',
                '#FFECDB' => '#FFECDB',
                '#AD4363' => '#AD4363',
                '#D10069' => '#D10069',
                '#CC0033' => '#CC0033',
                '#FF0000' => '#FF0000',
                '#D9534F' => '#D9534F',
                '#D1D100' => '#D1D100',
                '#F0AD4E' => '#F0AD4E',
                '#AD8D43' => '#AD8D43',
            ];
        }

        $this->addClass('cawa-fields-color');

        $this->addInputGroup($select = (new Select('', '', $options)),false);

        $select->getField()->addClass('hidden');

        $this->addClass('cawa-fields-color-container');
    }
}
