<?php
class shopImporthelperCli extends waCliController
{

    private $plugin;
    private $debug=false;
    public function execute()
    {
        $this -> plugin = wa('shop')->getPlugin('importhelper');
        $this -> plugin -> DataBaseConnection();
        $this -> plugin -> XmlLoadOut();
        $this -> plugin -> StartImport();
    }
}