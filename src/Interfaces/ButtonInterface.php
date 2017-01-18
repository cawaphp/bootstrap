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

namespace Cawa\Bootstrap\Interfaces;

interface ButtonInterface
{
    const TYPE_DEFAULT = 'btn-default';
    const TYPE_PRIMARY = 'btn-primary';
    const TYPE_SUCCESS = 'btn-success';
    const TYPE_INFO = 'btn-info';
    const TYPE_WARNING = 'btn-warning';
    const TYPE_DANGER = 'btn-danger';
    const TYPE_LINK = 'btn-link';

    const SIZE_LARGE = 'btn-lg';
    const SIZE_SMALL = 'btn-sm';
    const SIZE_XSMALL = 'btn-xs';
}
