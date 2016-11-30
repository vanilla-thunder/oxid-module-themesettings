<?php

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
