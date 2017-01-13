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

class theme_configvttsb extends theme_configvttsb_parent
{
    protected $_sChildTheme = null;

    public function render()
    {
        try {
            parent::render();
            if ($sParentTheme = $this->_aViewData["oTheme"]->getInfo('parentTheme')) {
                $oParentTheme = oxNew('oxTheme');
                if ($oParentTheme->load($sParentTheme)) {
                    $this->_aViewData["oParentTheme"] = $oParentTheme;
                    $aDbVariables = $this->loadConfVars(oxRegistry::getConfig()->getShopId(), oxConfig::OXMODULE_THEME_PREFIX . $sParentTheme);
                    $this->_aViewData["parent_constraints"] = $aDbVariables['constraints'];
                    $this->_aViewData["parent_grouping"] = $aDbVariables['grouping'];
                    foreach ($this->_aConfParams as $sType => $sParam) {
                        $this->_aViewData[str_replace('conf', 'parent', $sParam)] = $aDbVariables['vars'][$sType];
                    }
                    //var_dump($this->_aConfParams);

                }
            }

            return 'vt_themesettings.tpl';
        } catch (oxException $oEx) {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay($oEx);
            $oEx->debugOut();
        }

    }

    public function saveConfVars()
    {
        if ($parent = oxRegistry::getConfig()->getRequestParameter("parenttheme")) {
            $this->_sChildTheme = $this->_sTheme;
            $this->_sTheme = $parent;
        }

        parent::saveConfVars();

        if ($parent) $this->_sTheme = $this->_sChildTheme;
    }

    public function reloadSettings()
    {
        try {
            $sTheme = $this->getEditObjectId();
            $oTheme = oxNew('oxTheme');
            $oTheme->load($sTheme);
            if ($oTheme->getInfo('settings')) {
                $oDb = oxDb::getDb();
                $oUtils = oxRegistry::getUtils();
                $oUtils->resetLanguageCache();

                /** @var oxModule $oFakeModule */
                $oFakeModule = oxNew('oxModule');
                $oFakeModule->setModuleData($oTheme->getInfoArray());
                //print_r($this->_aTheme);

                // cleanup settings
                $oDb->execute("DELETE FROM oxconfig WHERE OXMODULE = 'theme:{$sTheme}'");
                $oDb->execute("DELETE FROM oxconfigdisplay WHERE OXCFGMODULE = 'theme:{$sTheme}'");

                /** @var oxModuleInstaller $oModuleInstaller */
                $oModuleInstaller = oxNew('oxModuleInstaller');
                if ($oModuleInstaller->activate($oFakeModule)) {
                    $settings = "'" . implode("','", array_column($oTheme->getInfo('settings'), 'name')) . "'";

                    $oxConfigSql = "UPDATE oxconfig SET OXMODULE = REPLACE(OXMODULE,'module:{$sTheme}','theme:{$sTheme}') WHERE OXMODULE = 'module:{$sTheme}' AND OXVARNAME IN(" . $settings . ") ";
                    $oDb->execute($oxConfigSql);

                    $oxConfigDisplaySql = "UPDATE oxconfigdisplay SET OXCFGMODULE = REPLACE(OXCFGMODULE,'module:{$sTheme}','theme:{$sTheme}') WHERE OXCFGMODULE = 'module:{$sTheme}' AND OXCFGVARNAME IN(" . $settings . ") ";
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
