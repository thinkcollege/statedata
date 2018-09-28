<?php   
/*
class: template
purpose: template engine
*/
class template extends mre_base {

	private $debug = false;
	/*
	function: define_file
	purpose: defines template file
	*/
	function define_file($file){
		$this->template_file = $file;
	}

	/*
	function: add_region
	purpose: adds template dynamic region
	*/
	function add_region($region,$value) {
		$this->regions[$region] = $value;
	}

	/*
	function: debug
	purpose: set debugging to true
	*/
	function debug() {
		$this->debug = !$this->debug;
	}

	/**
	 * makes the template and prints to stdout
	 *
	 * @return void
	 */
	function make_template() {
		$f = file_get_contents($this->mre_base_path.$this->template_dir.$this->template_file);
		if (empty($this->regions['base_url'])) {
			$this->regions['base_url'] = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('/charts', '', substr($_SERVER['REQUEST_URI'], -1) != '/' ? dirname($_SERVER['REQUEST_URI']) . '/' : $_SERVER['REQUEST_URI']);
		}
		foreach ($this->regions as $region => $val) {
			$f = str_replace('{' . $region . '}', $val, $f);
		}
		$tempfile = $this->mre_base_path.$this->template_tempdir.rand(111111111,999999999).".php";
	
		$temp = @fopen($tempfile,"w+");
		fwrite($temp, $f);

		fclose($temp);
		include($tempfile);
		if (!$this->debug) {
			unlink($tempfile);
		}
	}
}