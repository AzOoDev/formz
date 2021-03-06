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

namespace Romm\Formz\Validation\DataObject;

use Romm\Formz\Configuration\Form\Field\Validation\Validation;
use Romm\Formz\Form\FormObject;

class ValidatorDataObject
{
    /**
     * @var FormObject
     */
    protected $formObject;

    /**
     * @var Validation
     */
    protected $validation;

    /**
     * @param FormObject    $formObject
     * @param Validation    $validation
     */
    public function __construct(FormObject $formObject, Validation $validation)
    {
        $this->formObject = $formObject;
        $this->validation = $validation;
    }

    /**
     * @return FormObject
     */
    public function getFormObject()
    {
        return $this->formObject;
    }

    /**
     * @return Validation
     */
    public function getValidation()
    {
        return $this->validation;
    }
}
