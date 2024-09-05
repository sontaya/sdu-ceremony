<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	private $aTemplate = array();
	var $data = array();


    public function set_active_tab($target)
	{
		$sessiontab = array(
			'active'=> $target
		);
		$this->session->set_userdata('tab',$sessiontab);
	}

	public function render()
	{
		$this->aTemplate['header'] = $this->load->view('templates/header', $this->data, true);
		$this->aTemplate['content'] = $this->load->view($this->content, $this->data, true);
		$this->aTemplate['footer'] = $this->load->view('templates/footer', $this->data, true);
		$this->load->view('templates/index', $this->aTemplate);
    }


    public function metronic_render()
	{
		$this->aTemplate['header'] = $this->load->view('metronic_templates/header', $this->data, true);
		$this->aTemplate['content'] = $this->load->view($this->content, $this->data, true);
		$this->aTemplate['footer'] = $this->load->view('metronic_templates/footer', $this->data, true);
		$this->load->view('metronic_templates/index', $this->aTemplate);
	}

    public function metronic_practice_render()
	{
		$this->aTemplate['header'] = $this->load->view('metronic_templates/header', $this->data, true);
		$this->aTemplate['content'] = $this->load->view($this->content, $this->data, true);
		$this->aTemplate['footer'] = $this->load->view('metronic_templates/footer', $this->data, true);
		$this->load->view('metronic_templates/index-practice', $this->aTemplate);
	}

    public function metronic_schedule_render()
	{
		$this->aTemplate['header'] = $this->load->view('metronic_templates/header', $this->data, true);
		$this->aTemplate['content'] = $this->load->view($this->content, $this->data, true);
		$this->aTemplate['footer'] = $this->load->view('metronic_templates/footer', $this->data, true);
		$this->load->view('metronic_templates/index-schedule', $this->aTemplate);
	}

    public function metronic_admin_render()
	{
		$this->aTemplate['header'] = $this->load->view('metronic_templates/header', $this->data, true);
		$this->aTemplate['content'] = $this->load->view($this->content, $this->data, true);
		$this->aTemplate['footer'] = $this->load->view('metronic_templates/footer', $this->data, true);
		$this->load->view('metronic_templates/index-admin', $this->aTemplate);
	}
}
