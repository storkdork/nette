<?php

/**
 * This file is part of the Nette Framework.
 *
 * Copyright (c) 2004, 2011 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license", and/or
 * GPL license. For more information please see http://nette.org
 */

namespace Nette\Forms;

use Nette;



/**
 * Single line text input control.
 *
 * @author     David Grudl
 */
class TextInput extends TextBase
{

	/**
	 * @param  string  control name
	 * @param  string  label
	 * @param  int  width of the control
	 * @param  int  maximum number of characters the user may enter
	 */
	public function __construct($label = NULL, $cols = NULL, $maxLength = NULL)
	{
		parent::__construct($label);
		$this->control->type = 'text';
		$this->control->size = $cols;
		$this->control->maxlength = $maxLength;
		$this->filters[] = callback($this, 'sanitize');
		$this->value = '';
	}



	/**
	 * Filter: removes unnecessary whitespace and shortens value to control's max length.
	 * @return string
	 */
	public function sanitize($value)
	{
		if ($this->control->maxlength && Nette\String::length($value) > $this->control->maxlength) {
			$value = iconv_substr($value, 0, $this->control->maxlength, 'UTF-8');
		}
		return Nette\String::trim(strtr($value, "\r\n", '  '));
	}



	/**
	 * Changes control's type attribute.
	 * @param  string
	 * @return FormControl  provides a fluent interface
	 */
	public function setType($type)
	{
		$this->control->type = $type;
		return $this;
	}



	/** @deprecated */
	public function setPasswordMode($mode = TRUE)
	{
		$this->control->type = $mode ? 'password' : 'text';
		return $this;
	}



	/**
	 * Generates control's HTML element.
	 * @return Nette\Web\Html
	 */
	public function getControl()
	{
		$control = parent::getControl();
		foreach ($this->getRules() as $rule) {
			if ($rule->isNegative || $rule->type !== Rule::VALIDATOR) {

			} elseif ($rule->operation === Form::RANGE && $control->type !== 'text') {
				list($control->min, $control->max) = $rule->arg;

			} elseif ($rule->operation === Form::PATTERN) {
				$control->pattern = $rule->arg;
			}
		}
		if ($control->type !== 'password') {
			$control->value = $this->getValue() === '' ? $this->translate($this->emptyValue) : $this->value;
		}
		return $control;
	}

}
