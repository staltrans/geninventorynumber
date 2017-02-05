<?php
/*
 * @version $Id: HEADER 15930 2011-10-25 10:47:55Z orthagh $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2011 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 @package   geninventorynumber
 @author    the geninventorynumber plugin team
 @copyright Copyright (c) 2008-2017 geninventorynumber plugin team
 @license   GPLv2+
            http://www.gnu.org/licenses/gpl.txt
 @link      https://github.com/pluginsGLPI/geninventorynumber
 @link      http://www.glpi-project.org/
 @since     2008
---------------------------------------------------------------------- */

function plugin_init_geninventorynumber() {
   global $PLUGIN_HOOKS, $CFG_GLPI, $GENINVENTORYNUMBER_TYPES;

   $PLUGIN_HOOKS['csrf_compliant']['geninventorynumber'] = true;
   $PLUGIN_HOOKS['post_init']['geninventorynumber'] = 'plugin_geninventorynumber_postinit';

   $GENINVENTORYNUMBER_TYPES = ['Computer', 'Monitor', 'Printer', 'NetworkEquipment',
                                 'Peripheral', 'Phone', 'SoftwareLicense'];

   $plugin = new Plugin();
   if ($plugin->isInstalled('geninventorynumber')
      && $plugin->isActivated('geninventorynumber')
      && (Session::haveRight("config", CREATE))) {
      $PLUGIN_HOOKS['use_massive_action']['geninventorynumber'] = 1;

      Plugin::registerClass('PluginGeninventorynumberProfile',
                            ['addtabon' => ['Profile']]);
      Plugin::registerClass('PluginGeninventorynumberConfig');
      Plugin::registerClass('PluginGeninventorynumberConfigField');

      if (Session::haveRight('config', UPDATE)) {
         $PLUGIN_HOOKS["menu_toadd"]['geninventorynumber']
            = ['tools' => 'PluginGeninventorynumberConfig'];
      }
   }
}

function plugin_version_geninventorynumber() {
   return ['name'            => __('geninventorynumber', 'geninventorynumber'),
            'minGlpiVersion' => '0.85',
            'version'        => '9.1+1.0',
            'author'         => "<a href='http://www.teclib.com'>TECLIB'</a> + KK",
            'homepage'       => 'https://github.com/pluginsGLPI/geninventorynumber'];
}

function plugin_geninventorynumber_check_prerequisites() {
   if (version_compare(GLPI_VERSION, '0.85', 'lt')
      || version_compare(GLPI_VERSION, '9.2', 'ge')) {
      echo "This plugin requires GLPi > 0.85 and < 9.2";
   } else {
      return true;
   }
}

/**
 * Compatibility check
 *
 * @return   bool   True if plugin compatible with configuration
 */
function plugin_geninventorynumber_check_config() {
   return true;
}
