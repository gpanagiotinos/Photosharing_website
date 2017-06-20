<?php
/*
	Template Class
*/

class Template
{


	private $_smarty;
	
	
	function __construct()
	{
		global $template_config;
			
		$this->_smarty = new Smarty();
		
		$this->_smarty->template_dir = $template_config['template_dir'];
		$this->_smarty->compile_dir = $template_config['compile_dir'];
		$this->_smarty->cache_dir = $template_config['cache_dir'];
		$this->_smarty->config_dir = $template_config['config_dir'];
		
		$this->_smarty->caching = 0;
		//Debug
		$this->_smarty->debugging = DEBUG;
	
	}

	public function assign($name, $val)
	{
		$this->_smarty->assign($name, $val);
	}

	public function assign_array($array)
	{
		foreach($array as $key => $value)
		{
			$this->_smarty->assign($key, $value);
		}
	}

	public function render($template, $title, $layout = 'page')
	{
		global $session;	

		$this->_smarty->configLoad('init.conf', 'Default');
		
		$message = array(
			'text' => $session->message(),
			'type' => $session->messageType()
			);
		
		$this->_smarty->assign('message', $message);


		$_content = $this->_smarty->fetch($template . '.tpl');

		

		$this->_smarty->assign('_content', $_content);
		$this->_smarty->assign('title', $title);



		$this->_smarty->display($layout . '.layout.tpl');
	}


}

?>