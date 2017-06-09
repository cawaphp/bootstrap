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

namespace Cawa\Bootstrap\Grid;

use Cawa\Renderer\HtmlContainer;

class Col extends HtmlContainer
{
    const XS_1 = 'col-xs-1';
    const XS_2 = 'col-xs-2';
    const XS_3 = 'col-xs-3';
    const XS_4 = 'col-xs-4';
    const XS_5 = 'col-xs-5';
    const XS_6 = 'col-xs-6';
    const XS_7 = 'col-xs-7';
    const XS_8 = 'col-xs-8';
    const XS_9 = 'col-xs-9';
    const XS_10 = 'col-xs-10';
    const XS_11 = 'col-xs-11';
    const XS_12 = 'col-xs-12';

    const SM_1 = 'col-sm-1';
    const SM_2 = 'col-sm-2';
    const SM_3 = 'col-sm-3';
    const SM_4 = 'col-sm-4';
    const SM_5 = 'col-sm-5';
    const SM_6 = 'col-sm-6';
    const SM_7 = 'col-sm-7';
    const SM_8 = 'col-sm-8';
    const SM_9 = 'col-sm-9';
    const SM_10 = 'col-sm-10';
    const SM_11 = 'col-sm-11';
    const SM_12 = 'col-sm-12';

    const MD_1 = 'col-md-1';
    const MD_2 = 'col-md-2';
    const MD_3 = 'col-md-3';
    const MD_4 = 'col-md-4';
    const MD_5 = 'col-md-5';
    const MD_6 = 'col-md-6';
    const MD_7 = 'col-md-7';
    const MD_8 = 'col-md-8';
    const MD_9 = 'col-md-9';
    const MD_10 = 'col-md-10';
    const MD_11 = 'col-md-11';
    const MD_12 = 'col-md-12';

    const LG_1 = 'col-lg-1';
    const LG_2 = 'col-lg-2';
    const LG_3 = 'col-lg-3';
    const LG_4 = 'col-lg-4';
    const LG_5 = 'col-lg-5';
    const LG_6 = 'col-lg-6';
    const LG_7 = 'col-lg-7';
    const LG_8 = 'col-lg-8';
    const LG_9 = 'col-lg-9';
    const LG_10 = 'col-lg-10';
    const LG_11 = 'col-lg-11';
    const LG_12 = 'col-lg-12';

    const XS_OFFSET_0 = 'col-xs-offset-0';
    const XS_OFFSET_1 = 'col-xs-offset-1';
    const XS_OFFSET_2 = 'col-xs-offset-2';
    const XS_OFFSET_3 = 'col-xs-offset-3';
    const XS_OFFSET_4 = 'col-xs-offset-4';
    const XS_OFFSET_5 = 'col-xs-offset-5';
    const XS_OFFSET_6 = 'col-xs-offset-6';
    const XS_OFFSET_7 = 'col-xs-offset-7';
    const XS_OFFSET_8 = 'col-xs-offset-8';
    const XS_OFFSET_9 = 'col-xs-offset-9';
    const XS_OFFSET_10 = 'col-xs-offset-10';
    const XS_OFFSET_11 = 'col-xs-offset-11';
    const XS_OFFSET_12 = 'col-xs-offset-12';

    const SM_OFFSET_0 = 'col-sm-offset-0';
    const SM_OFFSET_1 = 'col-sm-offset-1';
    const SM_OFFSET_2 = 'col-sm-offset-2';
    const SM_OFFSET_3 = 'col-sm-offset-3';
    const SM_OFFSET_4 = 'col-sm-offset-4';
    const SM_OFFSET_5 = 'col-sm-offset-5';
    const SM_OFFSET_6 = 'col-sm-offset-6';
    const SM_OFFSET_7 = 'col-sm-offset-7';
    const SM_OFFSET_8 = 'col-sm-offset-8';
    const SM_OFFSET_9 = 'col-sm-offset-9';
    const SM_OFFSET_10 = 'col-sm-offset-10';
    const SM_OFFSET_11 = 'col-sm-offset-11';
    const SM_OFFSET_12 = 'col-sm-offset-12';

    const MD_OFFSET_0 = 'col-md-offset-0';
    const MD_OFFSET_1 = 'col-md-offset-1';
    const MD_OFFSET_2 = 'col-md-offset-2';
    const MD_OFFSET_3 = 'col-md-offset-3';
    const MD_OFFSET_4 = 'col-md-offset-4';
    const MD_OFFSET_5 = 'col-md-offset-5';
    const MD_OFFSET_6 = 'col-md-offset-6';
    const MD_OFFSET_7 = 'col-md-offset-7';
    const MD_OFFSET_8 = 'col-md-offset-8';
    const MD_OFFSET_9 = 'col-md-offset-9';
    const MD_OFFSET_10 = 'col-md-offset-10';
    const MD_OFFSET_11 = 'col-md-offset-11';
    const MD_OFFSET_12 = 'col-md-offset-12';

    const LG_OFFSET_0 = 'col-lg-offset-0';
    const LG_OFFSET_1 = 'col-lg-offset-1';
    const LG_OFFSET_2 = 'col-lg-offset-2';
    const LG_OFFSET_3 = 'col-lg-offset-3';
    const LG_OFFSET_4 = 'col-lg-offset-4';
    const LG_OFFSET_5 = 'col-lg-offset-5';
    const LG_OFFSET_6 = 'col-lg-offset-6';
    const LG_OFFSET_7 = 'col-lg-offset-7';
    const LG_OFFSET_8 = 'col-lg-offset-8';
    const LG_OFFSET_9 = 'col-lg-offset-9';
    const LG_OFFSET_10 = 'col-lg-offset-10';
    const LG_OFFSET_11 = 'col-lg-offset-11';
    const LG_OFFSET_12 = 'col-lg-offset-12';

    const XS_PULL_1 = 'col-xs-pull-1';
    const XS_PULL_2 = 'col-xs-pull-2';
    const XS_PULL_3 = 'col-xs-pull-3';
    const XS_PULL_4 = 'col-xs-pull-4';
    const XS_PULL_5 = 'col-xs-pull-5';
    const XS_PULL_6 = 'col-xs-pull-6';
    const XS_PULL_7 = 'col-xs-pull-7';
    const XS_PULL_8 = 'col-xs-pull-8';
    const XS_PULL_9 = 'col-xs-pull-9';
    const XS_PULL_10 = 'col-xs-pull-10';
    const XS_PULL_11 = 'col-xs-pull-11';
    const XS_PULL_12 = 'col-xs-pull-12';

    const SM_PULL_1 = 'col-sm-pull-1';
    const SM_PULL_2 = 'col-sm-pull-2';
    const SM_PULL_3 = 'col-sm-pull-3';
    const SM_PULL_4 = 'col-sm-pull-4';
    const SM_PULL_5 = 'col-sm-pull-5';
    const SM_PULL_6 = 'col-sm-pull-6';
    const SM_PULL_7 = 'col-sm-pull-7';
    const SM_PULL_8 = 'col-sm-pull-8';
    const SM_PULL_9 = 'col-sm-pull-9';
    const SM_PULL_10 = 'col-sm-pull-10';
    const SM_PULL_11 = 'col-sm-pull-11';
    const SM_PULL_12 = 'col-sm-pull-12';

    const MD_PULL_1 = 'col-md-pull-1';
    const MD_PULL_2 = 'col-md-pull-2';
    const MD_PULL_3 = 'col-md-pull-3';
    const MD_PULL_4 = 'col-md-pull-4';
    const MD_PULL_5 = 'col-md-pull-5';
    const MD_PULL_6 = 'col-md-pull-6';
    const MD_PULL_7 = 'col-md-pull-7';
    const MD_PULL_8 = 'col-md-pull-8';
    const MD_PULL_9 = 'col-md-pull-9';
    const MD_PULL_10 = 'col-md-pull-10';
    const MD_PULL_11 = 'col-md-pull-11';
    const MD_PULL_12 = 'col-md-pull-12';

    const LG_PULL_1 = 'col-lg-pull-1';
    const LG_PULL_2 = 'col-lg-pull-2';
    const LG_PULL_3 = 'col-lg-pull-3';
    const LG_PULL_4 = 'col-lg-pull-4';
    const LG_PULL_5 = 'col-lg-pull-5';
    const LG_PULL_6 = 'col-lg-pull-6';
    const LG_PULL_7 = 'col-lg-pull-7';
    const LG_PULL_8 = 'col-lg-pull-8';
    const LG_PULL_9 = 'col-lg-pull-9';
    const LG_PULL_10 = 'col-lg-pull-10';
    const LG_PULL_11 = 'col-lg-pull-11';
    const LG_PULL_12 = 'col-lg-pull-12';

    const XS_PUSH_1 = 'col-xs-push-1';
    const XS_PUSH_2 = 'col-xs-push-2';
    const XS_PUSH_3 = 'col-xs-push-3';
    const XS_PUSH_4 = 'col-xs-push-4';
    const XS_PUSH_5 = 'col-xs-push-5';
    const XS_PUSH_6 = 'col-xs-push-6';
    const XS_PUSH_7 = 'col-xs-push-7';
    const XS_PUSH_8 = 'col-xs-push-8';
    const XS_PUSH_9 = 'col-xs-push-9';
    const XS_PUSH_10 = 'col-xs-push-10';
    const XS_PUSH_11 = 'col-xs-push-11';
    const XS_PUSH_12 = 'col-xs-push-12';

    const SM_PUSH_1 = 'col-sm-push-1';
    const SM_PUSH_2 = 'col-sm-push-2';
    const SM_PUSH_3 = 'col-sm-push-3';
    const SM_PUSH_4 = 'col-sm-push-4';
    const SM_PUSH_5 = 'col-sm-push-5';
    const SM_PUSH_6 = 'col-sm-push-6';
    const SM_PUSH_7 = 'col-sm-push-7';
    const SM_PUSH_8 = 'col-sm-push-8';
    const SM_PUSH_9 = 'col-sm-push-9';
    const SM_PUSH_10 = 'col-sm-push-10';
    const SM_PUSH_11 = 'col-sm-push-11';
    const SM_PUSH_12 = 'col-sm-push-12';

    const MD_PUSH_1 = 'col-md-push-1';
    const MD_PUSH_2 = 'col-md-push-2';
    const MD_PUSH_3 = 'col-md-push-3';
    const MD_PUSH_4 = 'col-md-push-4';
    const MD_PUSH_5 = 'col-md-push-5';
    const MD_PUSH_6 = 'col-md-push-6';
    const MD_PUSH_7 = 'col-md-push-7';
    const MD_PUSH_8 = 'col-md-push-8';
    const MD_PUSH_9 = 'col-md-push-9';
    const MD_PUSH_10 = 'col-md-push-10';
    const MD_PUSH_11 = 'col-md-push-11';
    const MD_PUSH_12 = 'col-md-push-12';

    const LG_PUSH_1 = 'col-lg-push-1';
    const LG_PUSH_2 = 'col-lg-push-2';
    const LG_PUSH_3 = 'col-lg-push-3';
    const LG_PUSH_4 = 'col-lg-push-4';
    const LG_PUSH_5 = 'col-lg-push-5';
    const LG_PUSH_6 = 'col-lg-push-6';
    const LG_PUSH_7 = 'col-lg-push-7';
    const LG_PUSH_8 = 'col-lg-push-8';
    const LG_PUSH_9 = 'col-lg-push-9';
    const LG_PUSH_10 = 'col-lg-push-10';
    const LG_PUSH_11 = 'col-lg-push-11';
    const LG_PUSH_12 = 'col-lg-push-12';

    const TYPE_XS = 'xs';
    const TYPE_SM = 'sm';
    const TYPE_MD = 'md';
    const TYPE_LG = 'lg';

    /**
     * @param array|string $class
     */
    public function __construct($class = null)
    {
        parent::__construct('<div>');

        if ($class) {
            $this->addClass($class);
        }
    }
}
