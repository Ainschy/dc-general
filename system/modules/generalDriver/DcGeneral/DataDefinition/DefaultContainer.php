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

namespace DcGeneral\DataDefinition;


use DcGeneral\DataDefinition\Definition\BasicDefinitionInterface;
use DcGeneral\DataDefinition\Definition\DefinitionInterface;
use DcGeneral\DataDefinition\Definition\DataProviderDefinitionInterface;
use DcGeneral\DataDefinition\Definition\PalettesDefinitionInterface;
use DcGeneral\DataDefinition\Definition\PropertiesDefinitionInterface;
use DcGeneral\Exception\DcGeneralInvalidArgumentException;

class DefaultContainer implements ContainerInterface
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var DefinitionInterface[]
	 */
	protected $definitions;

	/**
	 * Create a new default container.
	 *
	 * @param string $name
	 */
	function __construct($name)
	{
		$this->name = (string) $name;
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
	public function hasDefinition($definitionName)
	{
		return isset($this->definitions[$definitionName]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function clearDefinitions()
	{
		$this->definitions = array();
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefinitions(array $definitions)
	{
		$this
			->clearDefinitions()
			->addDefinitions($definitions);
	}

	/**
	 * {@inheritdoc}
	 */
	public function addDefinitions(array $definitions)
	{
		foreach ($definitions as $name => $definition)
		{
			if (!($definition instanceof DefinitionInterface))
			{
				throw new DcGeneralInvalidArgumentException('Definition ' . $name . ' does not implement DefinitionInterface.');
			}

			$this->setDefinition($name, $definition);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDefinition($definitionName, DefinitionInterface $definition)
	{
		$this->definitions[$definitionName] = $definition;
	}

	/**
	 * {@inheritdoc}
	 */
	public function removeDefinition($definitionName)
	{
		unset($this->definitions[$definitionName]);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDefinition($definitionName)
	{
		if (!$this->hasDefinition($definitionName))
		{
			throw new DcGeneralInvalidArgumentException('Definition ' . $definitionName . ' is not registered in the configuration.');
		}

		return $this->definitions[$definitionName];
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDefinitionNames()
	{
		return array_keys($this->definitions);
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasBasicDefinition()
	{
		return $this->hasDefinition(BasicDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setBasicDefinition(BasicDefinitionInterface $definition)
	{
		return $this->setDefinition(BasicDefinitionInterface::NAME, $definition);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBasicDefinition()
	{
		return $this->getDefinition(BasicDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasPropertiesDefinition()
	{
		return $this->hasDefinition(PropertiesDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setPropertiesDefinition(PropertiesDefinitionInterface $definition)
	{
		return $this->setDefinition(PropertiesDefinitionInterface::NAME, $definition);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPropertiesDefinition()
	{
		return $this->getDefinition(PropertiesDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasPalettesDefinition()
	{
		return $this->hasDefinition(PalettesDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setPalettesDefinition(PalettesDefinitionInterface $definition)
	{
		return $this->setDefinition(PalettesDefinitionInterface::NAME, $definition);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getPalettesDefinition()
	{
		return $this->getDefinition(PalettesDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasDataProviderDefinition()
	{
		return $this->hasDefinition(DataProviderDefinitionInterface::NAME);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setDataProviderDefinition(DataProviderDefinitionInterface $definition)
	{
		return $this->setDefinition(DataProviderDefinitionInterface::NAME, $definition);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getDataProviderDefinition()
	{
		return $this->getDefinition(DataProviderDefinitionInterface::NAME);
	}
}
