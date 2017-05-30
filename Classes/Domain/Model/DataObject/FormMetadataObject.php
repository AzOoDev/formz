<?php
/*
 * 2017 Romain CANON <romain.hydrocanon@gmail.com>
 *
 * This file is part of the TYPO3 FormZ project.
 * It is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License, either
 * version 3 of the License, or any later version.
 *
 * For the full copyright and license information, see:
 * http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Romm\Formz\Domain\Model\DataObject;

use Romm\Formz\Core\Core;
use Romm\Formz\Domain\Model\FormMetadata;
use Romm\Formz\Exceptions\EntryNotFoundException;
use TYPO3\CMS\Core\Type\TypeInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/**
 * Store and retrieve arbitrary data using the setter/getter functions.
 */
class FormMetadataObject implements TypeInterface
{
    /**
     * @var array
     */
    protected $metadata = [];

    /**
     * @var FormMetadata
     */
    protected $object;

    /**
     * @param string $data
     */
    public function __construct($data = null)
    {
        if ($data) {
            $data = unserialize($data);

            if (is_array($data)
                && isset($data['metadata'])
            ) {
                $this->metadata = $data['metadata'];
            }
        }
    }

    /**
     * @param string $key
     * @return mixed
     * @throws EntryNotFoundException
     */
    public function get($key)
    {
        if (false === $this->has($key)) {
            throw EntryNotFoundException::metadataNotFound($key);
        }

        return ArrayUtility::getValueByPath($this->metadata, $key, '.');
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return ArrayUtility::isValidPath($this->metadata, $key, '.');
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function set($key, $value)
    {
        $this->metadata = ArrayUtility::setValueByPath($this->metadata, $key, $value, '.');
    }

    /**
     * @param string $key
     */
    public function remove($key)
    {
        if ($this->has($key)) {
            $this->metadata = ArrayUtility::removeByPath($this->metadata, $key, '.');
        }
    }

    /**
     * Persists the last changes of this instance in database.
     */
    public function persist()
    {
        $persistenceManager = Core::get()->getPersistenceManager();

        if (null === $this->object->getUid()) {
            $persistenceManager->add($this->object);
        } else {
            $persistenceManager->update($this->object);
        }

        $persistenceManager->persistAll();
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @param FormMetadata $metadata
     */
    public function setObject(FormMetadata $metadata)
    {
        if (null !== $this->object) {
            throw new \Exception('todo'); // @todo
        }

        $this->object = $metadata;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return serialize(['metadata' => $this->metadata]);
    }

    /**
     * @see deepClone()
     */
    public function __clone()
    {
        $this->deepClone($this->metadata);
    }

    /**
     * When the metadata is fetched from persistence, the `metadata` array can
     * contain object instances, meaning that by default the original references
     * to these objects are used in the clean properties, resulting in the
     * object modification not being detected.
     *
     * In this function, we clone every object that is found, to solve the issue
     * above.
     *
     * @param mixed $entry
     * @param array $path
     */
    protected function deepClone($entry, array $path = [])
    {
        if (is_array($entry)) {
            foreach ($entry as $key => $item) {
                $path[] = $key;
                $this->deepClone($item, $path);
            }
        } elseif (is_object($entry)) {
            $this->set(implode('.', $path), clone $entry);
        }
    }
}
