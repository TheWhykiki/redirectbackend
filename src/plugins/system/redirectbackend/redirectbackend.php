<?php
/**
 * @copyright   Copyright (C) 2017 - 2020 pageup.gr, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;

defined('_JEXEC') or die('Restricted access');

class plgSystemRedirectbackend extends JPlugin
{

	public function onUserAfterLogin()
	{
		$app                = Factory::getApplication();
		$plugin             = PluginHelper::getPlugin('system', 'redirectbackend');
		$params             = new Registry($plugin->params);
		$groups_to_redirect = $params->get('redirect_usergroups');
		$component_name     = $params->get('redirect_component');
		$view_name          = $params->get('view_name');

		if ($app->isClient('administrator'))
		{
			$user   = $app->getIdentity();
			$groups = $user->getAuthorisedGroups();

			//$groups_to_redirect = array('13', '10');
			foreach ($groups as $group):
				if (in_array($group, $groups_to_redirect))
				{
$url = Uri::root() . Route::_('index.php?option=com_' . $component_name . '&view=' . $view_name, false);

					$app->redirect($url);
				}
			endforeach;
		}
	}

}
