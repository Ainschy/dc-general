<?php
/**
 * PHP version 5
 * @package    generalDriver
 * @author     Christian Schiffler <c.schiffler@cyberspectrum.de>
 * @author     Stefan Heimes <stefan_heimes@hotmail.com>
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @copyright  The MetaModels team.
 * @license    LGPL.
 * @filesource
 */

namespace DcGeneral\DataDefinition\Palette;

use DcGeneral\Data\ModelInterface;
use DcGeneral\Data\PropertyValueBag;
use DcGeneral\DataDefinition\Palette\Condition\Palette\PaletteConditionInterface;
use DcGeneral\Exception\DcGeneralRuntimeException;

/**
 * Default implementation of a palette.
 */
class Palette implements PaletteInterface
{
	/**
	 * The name of this palette.
	 *
	 * @deprecated Only for backwards compatibility, we will remove palette names in the future!
	 *
	 * @var string
	 */
	protected $name = null;

	/**
	 * List of all legends in this palette.
	 *
	 * @var array|LegendInterface[]
	 */
	protected $legends = array();

	/**
	 * The condition bound to this palette.
	 *
	 * @var PaletteConditionInterface|null
	 */
	protected $condition = null;

	/**
	 * {@inheritdoc}
	 */
	public function setName($name)
	{
		$this->name = (string) $name;
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getProperties(ModelInterface $model = null, PropertyValueBag $input)
	{
		$properties = array();

		foreach ($this->legends as $legend) {
			$properties = array_merge($properties, $legend->getProperties($model, $input));
		}

		return $properties;
	}

	/**
	 * {@inheritdoc}
	 */
	public function clearLegends()
	{
		$this->legends = array();
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function setLegends(array $legends)
	{
		$this->clearLegends();
		$this->addLegends($legends);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function addLegends(array $legends)
	{
		foreach ($legends as $legend) {
			$this->addLegend($legend);
		}
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasLegend($name)
	{
		foreach ($this->legends as $legend) {
			if ($legend->getName() == $name) {
				return true;
			}
		}

		return false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function containsLegend(LegendInterface $legend)
	{
		$hash = spl_object_hash($legend);
		return isset($this->legends[$hash]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function addLegend(LegendInterface $legend)
	{
		$hash = spl_object_hash($legend);
		$this->legends[$hash] = $legend;
		$legend->setPalette($this);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeLegend(LegendInterface $legend)
	{
		$hash = spl_object_hash($legend);
		unset($this->legends[$hash]);
		return $this;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLegend($name)
	{
		foreach ($this->legends as $legend) {
			if ($legend->getName() == $name) {
				return $legend;
			}
		}

		throw new DcGeneralRuntimeException('Legend "' . $name . '" does not exists');
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLegends()
	{
		return array_values($this->legends);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setCondition(PaletteConditionInterface $condition = null)
	{
		$this->condition = $condition;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCondition()
	{
		return $this->condition;
	}

	/**
	 * {@inheritdoc}
	 */
	public function __clone()
	{
		$legends = array();
		foreach ($legends as $index => $legend) {
			$legends[$index] = clone $legend;
		}
		$this->legends = $legends;

		$this->condition = clone $this->condition;
	}
}
