<?php

/**
 * importing Theme Settings from theme.php for OXID eShop
 * Copyright (C) 2017  Marat Bedoev
 * info:  m@marat.ws
 *
 * This program is free software;
 * you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation;
 * either version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>
 *
 * author: Marat Bedoev
 */

class theme_configvttsb extends theme_configvttsb_parent
{
   public function render()
   {
      try
      {
         parent::render();
         if($sParentTheme = $this->_aViewData["oTheme"]->getInfo('parentTheme'))
         {
            $oParentTheme = oxNew('oxTheme');
            if ($oParentTheme->load($sParentTheme))
            {
               $this->_aViewData["oParentTheme"] = $oParentTheme;
               $aDbVariables = $this->loadConfVars(oxRegistry::getConfig()->getShopId(), oxConfig::OXMODULE_THEME_PREFIX . $sParentTheme);
               $this->_aViewData["parent_constraints"] = $aDbVariables['constraints'];
               $this->_aViewData["parent_grouping"] = $aDbVariables['grouping'];
               foreach ($this->_aConfParams as $sType => $sParam) {
                  $this->_aViewData[str_replace('conf','parent',$sParam)] = $aDbVariables['vars'][$sType];
               }
               //var_dump($this->_aConfParams);

            }
         }
         return 'vt_themesettings.tpl';
      }
      catch (oxException $oEx)
      {
         oxRegistry::get("oxUtilsView")->addErrorToDisplay($oEx);
         $oEx->debugOut();
      }

   }

}
