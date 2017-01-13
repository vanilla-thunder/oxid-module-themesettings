<?php

/**
 * ___MODULE___
 * Copyright (C) ___YEAR___  ___COMPANY___
 * info:  ___EMAIL___
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 *
 * author: ___AUTHOR___
 */

class oxthemevttsb extends oxthemevttsb_parent
{
   public function activate()
   {
      try {
         parent::activate();
         $oDb = oxDb::getDb();
         $oUtils = oxRegistry::getUtils();
         $oUtils->resetLanguageCache();

         if ($this->getInfo('settings')) {
            /** @var oxModule $oFakeModule */
            $oFakeModule = oxNew('oxModule');
            $oFakeModule->setModuleData($this->_aTheme);
            //print_r($this->_aTheme);

            // cleanup settings
            $oDb->execute("DELETE FROM oxconfig WHERE OXMODULE = 'theme:" . $this->getId() . "'");
            $oDb->execute("DELETE FROM oxconfigdisplay WHERE OXCFGMODULE = 'theme:" . $this->getId() . "'");

            /** @var oxModuleInstaller $oModuleInstaller */
            $oModuleInstaller = oxNew('oxModuleInstaller');
            if ($oModuleInstaller->activate($oFakeModule)) {
               $settings = "'" . implode("','", array_column($this->getInfo('settings'), 'name')) . "'";

               $oxConfigSql = "UPDATE oxconfig SET OXMODULE = REPLACE(OXMODULE,'module:" . $this->getId() . "','theme:" . $this->getId() . "') WHERE OXMODULE = 'module:" . $this->getId() . "' AND OXVARNAME IN(" . $settings . ") ";
               $oDb->execute($oxConfigSql);

               $oxConfigDisplaySql = "UPDATE oxconfigdisplay SET OXCFGMODULE = REPLACE(OXCFGMODULE,'module:" . $this->getId() . "','theme:" . $this->getId() . "') WHERE OXCFGMODULE = 'module:" . $this->getId() . "' AND OXCFGVARNAME IN(" . $settings . ") ";
               $oDb->execute($oxConfigDisplaySql);
               //var_dump();
            }
         }

      } catch (oxException $oEx) {
         oxRegistry::get("oxUtilsView")->addErrorToDisplay($oEx);
         $oEx->debugOut();
      }
   }

}
