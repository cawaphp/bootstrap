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

use Cawa\Intl\TranslatorFactory;

class TreeItem implements \JsonSerializable
{
    use TranslatorFactory;

    /**
     * @param string|null $id
     * @param string|null $text
     */
    public function __construct(string $id = null, string $text = null)
    {
        $this->id = $id;
        $this->text = $text;
    }

    /**
     * @var string
     */
    private $id;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return $this
     */
    public function setId(string $id) : self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @var string
     */
    private $text;

    /**
     * @return string
     */
    public function getText() : string
    {
        return $this->text;
    }

    /**
     * @param string $text
     *
     * @return $this
     */
    public function setText(string $text) : self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @var string
     */
    private $icon;

    /**
     * @return string
     */
    public function getIcon() : string
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon) : self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @var bool
     */
    private $open;

    /**
     * @return boolean
     */
    public function isOpen() : bool
    {
        return $this->state['open'] ?? false;
    }

    /**
     * @param boolean $open
     *
     * @return $this
     */
    public function setOpen(bool $open) : self
    {
        $this->state['open'] = $open;

        return $this;
    }

    /**
     * @var bool
     */
    private $disabled;

    /**
     * @return boolean
     */
    public function isDisabled() : bool
    {
        return $this->state['disabled'] ?? false;
    }

    /**
     * @param boolean $disabled
     *
     * @return $this
     */
    public function setDisabled(bool $disabled) : self
    {
        $this->state['disabled'] = $disabled;

        return $this;
    }

    /**
     * @var array
     */
    private $state = [];

    /**
     * @return boolean
     */
    public function isSelected() : bool
    {
        return $this->state['selected'] ?? false;
    }

    /**
     * @param boolean $selected
     *
     * @return $this
     */
    public function setSelected(bool $selected) : self
    {
        $this->state['selected'] = $selected;

        return $this;
    }

    /**
     * @var array|TreeItem[]
     */
    private $children = [];

    /**
     * @return array|TreeItem[]
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param TreeItem $item
     *
     * @return $this
     */
    public function addChildren(TreeItem $item) : self
    {
        $this->children[] = $item;

        return $this;
    }

    /**
     * @param array|TreeItem[] $children
     *
     * @return $this
     */
    public function setChildren(array $children) : self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        $return = get_object_vars($this);
        if (!$this->id) {
            $return['id'] = uniqid('_');
        }

        if (!$this->text && $this->id) {
            $return['text'] = $this->trans('rights.' . $this->id, null, false);
            if (!$return['text']) {
                $explode = explode('/', $this->id);
                if (sizeof($explode) > 1) {
                    $return['text'] = $this->trans('rights.' . array_pop($explode), null, false);
                }
            }
        }

        return $return;
    }
}
