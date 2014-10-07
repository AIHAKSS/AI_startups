<?php
class MyController extends CBaseController
{
	public $layout='//layouts/main';
	public $mainmenu;

	public function init()
    {
        parent::init();
        Log::writeLog('request['.CHttpRequestInfo::GetFullUrl().']','debug');
        $this->mainmenu = $this->controllermodule;
	}
}