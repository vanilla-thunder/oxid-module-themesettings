<?php

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
