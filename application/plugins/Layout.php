<?php

class LayoutPlugin extends Yaf_Plugin_Abstract
{

    private $_layoutDir;                //布局模板的路径
    private $_layoutFile;               //布局文件名
    private $_layoutVars = [];     //布局的模板变量
    public $withoutLayouts = [];   //不使用布局模板的模块列表

    public function __construct($layoutFile, $layoutDir = null)
    {
        $this->_layoutFile = $layoutFile;
        $this->_layoutDir = ($layoutDir) ? $layoutDir : APPLICATION_PATH . '/views/';
    }

    public function __set($name, $value)
    {
        $this->_layoutVars[$name] = $value;
    }

    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    public function dispatchLoopStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    public function postDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
        $module = strtolower($request->getModuleName());
        $controller = strtolower($request->getControllerName());
        $action = strtolower($request->getActionName());
        if (!empty($this->withoutLayouts)) {
            foreach ($this->withoutLayouts as $url) {
                $urlArr = explode('/', trim($url));
                $count = count($urlArr);
                if (($count == 1) && ($module == $urlArr[0]) || ($controller == $urlArr[0])) {
                    return true;
                } elseif (($count == 2) && ($module == $urlArr[0]) && ($controller == $urlArr[1])) {
                    return true;
                } elseif (($count == 3) && ($module == $urlArr[0]) && ($controller == $urlArr[1]) && ($action == $urlArr[2])) {
                    return true;
                }
            }
        }

        //获取已经设置响应的Body
        $body = $response->getBody();

        //清除已经设置响应的body
        $response->clearBody();
        /* wrap it in the layout */
        $layout = new Yaf_View_Simple($this->_layoutDir);
        $layout->content = $body;    //相当于$layout->assign('content', $body);
        $layout->assign('layout', $this->_layoutVars);

        //设置响应的body
        $response->setBody($layout->render($this->_layoutFile));
    }

    public function preDispatch(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    public function preResponse(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }
}
