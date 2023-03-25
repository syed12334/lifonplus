<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Demo extends CI_Controller {
	function index() {
		echo phpinfo();
	}
}
?>