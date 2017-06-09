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

class Range extends Text
{
    /**
     * {@inheritdoc}
     */
    public function __construct(string $name, string $label = null)
    {
        parent::__construct($name, $label);
        $this->getField()->addClass('cawa-fields-range');
    }

    /**
     * {@inheritdoc}
     */
    public function setValue($value) : parent
    {
        $this->getField()->addAttribute('data-slider-value', (string) is_array($value) ? json_encode($value) : (string) $value);

        return $this;
    }

    /**
     * minimum possible value.
     *
     * @param float $min
     *
     * @return $this|self
     */
    public function setMin(float $min) : self
    {
        $this->getField()->addAttribute('data-slider-min', (string) $min);

        return $this;
    }

    /**
     * maximum possible value.
     *
     * @param float $max
     *
     * @return $this|self
     */
    public function setMax(float $max) : self
    {
        $this->getField()->addAttribute('data-slider-max', (string) $max);

        return $this;
    }

    /**
     * increment step.
     *
     * @param float $step
     *
     * @return $this|self
     */
    public function setStep(float $step) : self
    {
        $this->getField()->addAttribute('data-slider-step', (string) $step);

        return $this;
    }

    /**
     * The number of digits shown after the decimal.
     * Defaults to the number of digits after the decimal of step value.
     *
     * @param float $precision
     *
     * @return $this|self
     */
    public function setPrecision(float $precision) : self
    {
        $this->getField()->addAttribute('data-slider-precision', (string) $precision);

        return $this;
    }

    /**
     * set the orientation.
     * Accepts 'vertical' or 'horizontal'.
     *
     * @param string $orientation
     *
     * @return $this|self
     */
    public function setOrientation(string $orientation) : self
    {
        $this->getField()->addAttribute('data-slider-orientation', $orientation);

        return $this;
    }

    /**
     * make range slider.
     * Optional if initial value is an array.
     * If initial value is scalar, max will be used for second value.
     *
     * @param bool $range
     *
     * @return $this|self
     */
    public function setRange(bool $range) : self
    {
        $this->getField()->addAttribute('data-slider-range', $range ? 'true' : 'false');

        return $this;
    }

    /**
     * selection placement.
     * Accepts: 'before', 'after' or 'none'.
     * In case of a range slider, the selection will be placed between the handles.
     *
     * @param string $selection
     *
     * @return $this|self
     */
    public function setSelection(string $selection) : self
    {
        $this->getField()->addAttribute('data-slider-selection', $selection);

        return $this;
    }

    /**
     * whether to show the tooltip on drag, hide the tooltip, or always show the tooltip.
     * Accepts: 'show', 'hide', or 'always'.
     *
     * @param string $tooltip
     *
     * @return $this|self
     */
    public function setTooltipVisibility(string $tooltip) : self
    {
        $this->getField()->addAttribute('data-slider-tooltip', $tooltip);

        return $this;
    }

    /**
     * if false show one tootip if true show two tooltips one for each handler.
     *
     * @param bool $tooltipSplit
     *
     * @return $this|self
     */
    public function setTooltipSplit(bool $tooltipSplit) : self
    {
        $this->getField()->addAttribute('data-slider-tooltip-split', $tooltipSplit ? 'true' : 'false');

        return $this;
    }

    /**
     * Position of tooltip, relative to slider.
     * Accepts 'top'/'bottom' for horizontal sliders and 'left'/'right' for vertically orientated sliders.
     * Default positions are 'top' for horizontal and 'right' for vertical slider.
     *
     * @param string $tooltipPosition
     *
     * @return $this|self
     */
    public function setTooltipPosition(string $tooltipPosition) : self
    {
        $this->getField()->addAttribute('data-slider-tooltip-position', $tooltipPosition);

        return $this;
    }

    /**
     * handle shape.
     * Accepts: 'round', 'square', 'triangle' or 'custom'.
     *
     * @param string $handle
     *
     * @return $this|self
     */
    public function setHandle(string $handle) : self
    {
        $this->getField()->addAttribute('data-slider-handle', $handle);

        return $this;
    }

    /**
     * whether or not the slider should be reversed.
     *
     * @param bool $reversed
     *
     * @return $this|self
     */
    public function setReversed(bool $reversed) : self
    {
        $this->getField()->addAttribute('data-slider-reversed', $reversed ? 'true' : 'false');

        return $this;
    }

    /**
     * 'auto'.
     *
     * @param bool $rtl
     *
     * @return $this|self
     */
    public function setRtl(bool $rtl) : self
    {
        $this->getField()->addAttribute('data-slider-rtl', $rtl ? 'true' : 'false');

        return $this;
    }

    /**
     * whether or not the slider is initially enabled.
     *
     * @param bool $enabled
     *
     * @return $this|self
     */
    public function setEnabled(bool $enabled) : self
    {
        $this->getField()->addAttribute('data-slider-enabled', $enabled ? 'true' : 'false');

        return $this;
    }

    /**
     * The natural order is used for the arrow keys.
     * Arrow up select the upper slider value for vertical sliders,
     * arrow right the righter slider value for a horizontal slider
     * no matter if the slider was reversed or not.
     * By default the arrow keys are oriented by arrow up/right to the higher slider value,
     * arrow down/left to the lower slider value.
     *
     * @param bool $naturalArrowKeys
     *
     * @return $this|self
     */
    public function setNaturalArrowKeys(bool $naturalArrowKeys) : self
    {
        $this->getField()->addAttribute('data-slider-natural-arrow-keys', $naturalArrowKeys ? 'true' : 'false');

        return $this;
    }

    /**
     * Used to define the values of ticks.
     * Tick marks are indicators to denote special values in the range.
     * This option overwrites min and max options.
     *
     * @param array $ticks
     *
     * @return $this|self
     */
    public function setTicks(array $ticks) : self
    {
        $this->getField()->addAttribute('data-slider-ticks', json_encode($ticks));

        return $this;
    }

    /**
     * Defines the positions of the tick values in percentages. The first value should always be 0, the last value
     * should always be 100 percent.
     *
     * @param array $ticksPositions
     *
     * @return $this|self
     */
    public function setTicksPositions(array $ticksPositions) : self
    {
        $this->getField()->addAttribute('data-slider-ticks-positions', json_encode($ticksPositions));

        return $this;
    }

    /**
     * Defines the labels below the tick marks.
     * Accepts HTML input.
     *
     * @param array $ticksLabels
     *
     * @return $this|self
     */
    public function setTicksLabels(array $ticksLabels) : self
    {
        $this->getField()->addAttribute('data-slider-ticks-labels', json_encode($ticksLabels));

        return $this;
    }

    /**
     * Used to define the snap bounds of a tick.
     * Snaps to the tick if value is within these bounds.
     *
     * @param float $ticksSnapBounds
     *
     * @return $this|self
     */
    public function setTicksSnapBounds(float $ticksSnapBounds) : self
    {
        $this->getField()->addAttribute('data-slider-ticks-snap-bounds', (string) $ticksSnapBounds);

        return $this;
    }

    /**
     * Used to allow for a user to hover over a given tick to see it's value.
     * Useful if custom formatter passed in.
     *
     * @param bool $ticksTooltip
     *
     * @return $this|self
     */
    public function setTicksTooltip(bool $ticksTooltip) : self
    {
        $this->getField()->addAttribute('data-slider-ticks-tooltip', $ticksTooltip ? 'true' : 'false');

        return $this;
    }

    /**
     * Set to 'logarithmic' to use a logarithmic scale.
     *
     * @param string $scale
     *
     * @return $this|self
     */
    public function setScale(string $scale) : self
    {
        $this->getField()->addAttribute('data-slider-scale', $scale);

        return $this;
    }

    /**
     * Focus the appropriate slider handle after a value change.
     *
     * @param bool $focus
     *
     * @return $this|self
     */
    public function setFocus(bool $focus) : self
    {
        $this->getField()->addAttribute('data-slider-focus', $focus ? 'true' : 'false');

        return $this;
    }

    /**
     * ARIA labels for the slider handle's,
     * Use array for multiple values in a range slider.
     *
     * @param string|array $labelledBy
     *
     * @return $this|self
     */
    public function setLabelledBy($labelledBy) : self
    {
        $this->getField()->addAttribute('data-slider-labelledby', is_array($labelledBy) ? json_encode($labelledBy) : $labelledBy);

        return $this;
    }

    /**
     * Defines a range array that you want to highlight,
     * for example: [{'start':val1, 'end': val2}].
     *
     * @param array $rangeHighlights
     *
     * @return $this|self
     */
    public function setRangeHighlights(array $rangeHighlights) : self
    {
        $this->getField()->addAttribute('data-slider-range-highlights', json_encode($rangeHighlights));

        return $this;
    }
}
