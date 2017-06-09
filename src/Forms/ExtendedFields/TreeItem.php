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

class TreeItem implements \JsonSerializable
{
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
     * @return $this|self
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
     * @return $this|self
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
     * @return $this|self
     */
    public function setIcon(string $icon) : self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOpen() : bool
    {
        return $this->state['open'] ?? false;
    }

    /**
     * @param bool $open
     *
     * @return $this|self
     */
    public function setOpen(bool $open) : self
    {
        $this->state['open'] = $open;

        return $this;
    }

    /**
     * @return bool
     */
    public function isDisabled() : bool
    {
        return $this->state['disabled'] ?? false;
    }

    /**
     * @param bool $disabled
     *
     * @return $this|self
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
     * @return bool
     */
    public function isSelected() : bool
    {
        return $this->state['selected'] ?? false;
    }

    /**
     * @param bool $selected
     *
     * @return $this|self
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
     * @return $this|self
     */
    public function addChildren(TreeItem $item) : self
    {
        $this->children[] = $item;

        return $this;
    }

    /**
     * @param array|TreeItem[] $children
     *
     * @return $this|self
     */
    public function setChildren(array $children) : self
    {
        $this->children = $children;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        $return = get_object_vars($this);
        if (!$this->id) {
            $return['id'] = uniqid('_');
        }

        return $return;
    }
}
