<?php

namespace Hcode;

use Rain\TpL;


class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"data" => []
	];
	public function __construct($opts = array()){
		// se existir algum conflito no 1 para o 2 array, o que fica a valer é o seguundo array $opts)
		$this -> options = array_merge($this -> defaults, $opts);

		// configurar TpL
		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache"
		);

		Tpl::configure( $config );

		$this ->tpl = new Tpl;
		$this -> setData($this->options["data"]);

		$this -> tpl ->draw("header");
	}

	public function setTpl($name, $data = array(), $returnHtml = false){
		$this -> setData($data);

		return $this ->tpl -> draw ($name, $returnHtml);
	}

	private function setData($data = array()){
		foreach ($data as $key => $value) {
			# code...
			$this -> tpl -> assign($key, $value);
		}
	}

	public function __destruct(){
		$this ->tpl -> draw("footer");
	}
}

?>