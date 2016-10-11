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

namespace Cawa\Bootstrap\Tables\ColumnRenderer;

use Cawa\Html\Tables\Column;
use Cawa\Html\Tables\ColumnRenderer\AbstractRenderer;
use Cawa\Intl\Number;

class Currency extends AbstractRenderer
{
    /**
     * @var callable
     */
    private $currencyCols;

    /**
     * @param string $currencyCols
     */
    public function __construct(string $currencyCols)
    {
        $this->currencyCols = $currencyCols;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($content, Column $column, array $primaryValues, array $data) : string
    {
        if (!is_null($content)) {
            return Number::formatCurrency($content, $data[$this->currencyCols]);
        } else {
            return '';
        }
    }
}
