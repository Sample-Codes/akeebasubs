<?php
/**
 * @package   AkeebaSubs
 * @copyright Copyright (c)2010-2018 Nicholas K. Dionysopoulos / Akeeba Ltd
 * @license   GNU General Public License version 3, or later
 */

defined('_JEXEC') or die;

use Akeeba\Subscriptions\Admin\Helper\Select;

echo Select::states(
    $this->input->getString('state', ''),
    'state',
    [
        'class'   => 'form-control',
        'country' => $this->input->getString('country', '')
    ]
);
