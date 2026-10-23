<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Custom_Form extends Admin_Controller
{
    
	public function __construct(){
		parent::__construct();
        
        $this->load->model('custom_form_m');
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
	}
    
    
    /*
     * page Index
     * 
     */
    public function index () {

        prepare_search_query_GET(array(), array('id', 'first_name','last_name','phone','email','town','address','year','category'));
        
        /* data */
        $this->data['all_custom_forms']=$this->custom_form_m->get();
        /* end data */
        
        // Load view
        $this->data['subview'] = 'admin/custom_form/index';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    /*
     * page Edit custom_forme 
     * 
     */
    public function edit ($id=null) {
        if(!empty($id)) {
        /* data */
        $this->data['custom_form'] = $this->custom_form_m->get(trim($id));
        /* end data */
        } else {
            /* error */
            /* data */
            $this->data['custom_form'] = $this->custom_form_m->get_new();
            $id=null;
            /* end data */
        }
        
        // Set up the form
        // rules
        $rules = $this->custom_form_m->rules;
        $this->form_validation->set_rules($rules);
        
        // Process the form
        if($this->form_validation->run() == TRUE)
        {
            if($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', 
                        lang('Data editing disabled in demo'));
                redirect('admin/enquire/edit/'.$id);
                exit();
            }
            
            $data = $this->custom_form_m->array_from_rules($rules);
            
            
            if(is_null($id)) {
                $data['date_submit'] = date('Y-m-d H:i:s');
            }
            
            $insert_id='';
            $insert_id=$this->custom_form_m->save($data, $id);
            
            if(empty($insert_id))
            {
                echo '$insert_id is empty, ERROR IN QUERY: <br />';
                echo $this->db->last_query().'<br />';
                echo $this->db->_error_message();
                exit();
            }
            
            if(!empty($insert_id)) {
                $this->session->set_flashdata('message', 
                        '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');

                redirect('admin/custom_form/edit/'.$insert_id);
            }
            
        } else {
        
        }
        
        // Load view
        $this->data['subview'] = 'admin/custom_form/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    /*
     * page Edit custom_forme 
     * 
     */
    public function configuration ($id=null) {
      
       // Set up the form
       $rules = $this->custom_form_m->rules_settings;
        
       $this->form_validation->set_rules($rules);
       
       // Process the form
       if($this->form_validation->run() == TRUE)
       {
           $data = $this->custom_form_m->array_from_post($this->custom_form_m->get_post_from_rules($rules));
           $this->custom_form_m->save_settings($data);
           $this->session->set_flashdata('message', 
                   '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');
           redirect('admin/custom_form/configuration');
       }
        
        // Load view
        $this->data['subview'] = 'admin/custom_form/settings';
        $this->load->view('admin/_layout_main', $this->data);
    }
    
    public function delete($id=null)
	{
        if(empty($id)) {
            $this->session->set_flashdata('error', 
                    lang_check('Id is empty'));
            redirect('admin/custom_form');
            exit();
        }
        
        if($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', 
                    lang('Data editing disabled in demo'));
            redirect('admin/custom_form');
            exit();
        }
       
        $this->data['enquire'] = $this->custom_form_m->get($id);
        
        //Check if user have permissions
        if($this->session->userdata('type') != 'ADMIN')
        {
                redirect('admin/custom_form');
        }
       
        $this->custom_form_m->delete($id);
        redirect('admin/custom_form');
	}
    
        
    public function _check_date($str)
    {   
        $date_from = $this->input->post('date_start');
        $date_to = $this->input->post('date_end');
  
        // check 'from' before 'to', 'from' after 'now'
        if(/*strtotime($date_from) < time() ||*/ strtotime($date_to) < strtotime($date_from))
        {
            $this->form_validation->set_message('_check_date', lang_check('Please correct dates start/end'));
            return FALSE;
        }

        return TRUE;
    }
        
    public function _check_unique_code($str)
    {   
        // Do NOT validate if slug alredy exists
        // UNLESS it's the slug for the current page
        
        $id = $this->uri->segment(4);
        $this->db->where('custom_form', $this->input->post('custom_form'));
        !$id || $this->db->where('id !=', $id);
        $id = $this->custom_form_m->get();
        
        if(sw_count($id))
        {
            $this->form_validation->set_message('_check_unique_code', '%s should be unique');
            return FALSE;
        }
        
        return TRUE;
    }
}