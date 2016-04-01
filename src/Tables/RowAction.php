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

namespace Cawa\Bootstrap\Tables;

use Cawa\Html\Link;

class RowAction extends Link
{
    /**
     * @param string $name
     * @param string|null $link
     * @param string|null $icon
     */
    public function __construct(string $name, string $link = null, string $icon = null)
    {
        if ($icon) {
            $content = $icon ? '<i class="' . $icon . '"></i>' : $name;
            $this->addAttribute("title", $name);
        } else {
            $content = $name;
        }

        parent::__construct($content, $link);
    }

    /**
     * @return bool
     */
    public function isMain() : bool
    {
        return is_null($this->getAttribute("data-main-action"));
    }

    /**
     * @param bool $main
     *
     * @return $this
     */
    public function setMain(bool $main = true) : self
    {
        if ($main) {
            return $this->addAttribute("data-main-action", "true");
        } else {
            return $this->removeAttribute("data-main-action");
        }
    }
}
