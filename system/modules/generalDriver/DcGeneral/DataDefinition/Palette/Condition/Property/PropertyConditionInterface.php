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

namespace DcGeneral\DataDefinition\Palette\Condition\Property;

use DcGeneral\Data\ModelInterface;
use DcGeneral\Data\PropertyValueBag;
use DcGeneral\DataDefinition\ConditionInterface;

/**
 * A condition define when a property is visible or editable and when not.
 */
interface PropertyConditionInterface extends ConditionInterface
{
	/**
	 * Check if the condition match.
	 *
	 * @param ModelInterface|null $model If given, subpalettes will be evaluated depending on the model.
	 * If no model is given, all properties will be returned, including subpalette properties.
	 * @param PropertyValueBag $input If given, subpalettes will be evaluated depending on the input data.
	 * If no model and no input data is given, all properties will be returned, including subpalette properties.
	 *
	 * @return bool
	 */
	public function match(ModelInterface $model = null, PropertyValueBag $input = null);

	/**
	 * Create a deep clone of the condition.
	 */
	public function __clone();
}
