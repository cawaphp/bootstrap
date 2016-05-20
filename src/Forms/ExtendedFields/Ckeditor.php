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

use Cawa\Bootstrap\Forms\Fields\Textarea;

class Ckeditor extends Textarea
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name);
        $this->getField()->addClass('cawa-fields-ckeditor');
    }
}