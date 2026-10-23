<?php

class Registration_coupon extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('registration_coupon_m');
        $this->data['content_language_id'] = $this->language_m->get_content_lang();
    }

    public function index()
    {
        prepare_search_query_GET(array(), array('id', 'code_name', 'coupon_code'));

        $this->data['coupons'] = $this->registration_coupon_m->get();

        $this->data['subview'] = 'admin/registration_coupon/index';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function edit($id = NULL)
    {
        if (!empty($id))
        {
            $this->data['coupon'] = $this->registration_coupon_m->get(trim($id));
        }
        else
        {
            $this->data['coupon'] = $this->registration_coupon_m->get_new();
            $id = NULL;
        }

        $this->data['discount_types'] = $this->registration_coupon_m->discount_types;

        $rules = $this->registration_coupon_m->rules;
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == TRUE)
        {
            if ($this->config->item('app_type') == 'demo')
            {
                $this->session->set_flashdata('error', lang('Data editing disabled in demo'));
                redirect('admin/registration_coupon/edit/'.$id);
                exit();
            }

            $data = $this->registration_coupon_m->array_from_post(array(
                'code_name', 'coupon_code', 'discount_type', 'discount_value', 'quantity', 'date_start', 'date_end', 'active'
            ));

            if (!isset($_POST['active']))
                $data['active'] = 0;

            if (!in_array($data['discount_type'], array('percent', 'fixed'), TRUE))
                $data['discount_type'] = 'percent';

            if (is_null($id))
            {
                $data['date_created'] = date('Y-m-d H:i:s');
                $data['used'] = 0;
            }

            $insert_id = $this->registration_coupon_m->save($data, $id);

            $this->session->set_flashdata('message',
                '<p class="label label-success validation">'.lang_check('Changes saved').'</p>');

            redirect('admin/registration_coupon/edit/'.$insert_id);
        }

        $this->data['subview'] = 'admin/registration_coupon/edit';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function delete($id = NULL)
    {
        if (empty($id))
        {
            $this->session->set_flashdata('error', lang_check('Id is empty'));
            redirect('admin/registration_coupon');
            exit();
        }

        if ($this->config->item('app_type') == 'demo')
        {
            $this->session->set_flashdata('error', lang('Data editing disabled in demo'));
            redirect('admin/registration_coupon');
            exit();
        }

        if ($this->session->userdata('type') != 'ADMIN')
            redirect('admin/registration_coupon');

        $this->registration_coupon_m->delete($id);
        redirect('admin/registration_coupon');
    }

    public function _check_date($str)
    {
        $date_from = $this->input->post('date_start');
        $date_to = $this->input->post('date_end');

        if (strtotime($date_to) < strtotime($date_from))
        {
            $this->form_validation->set_message('_check_date', lang_check('Please correct dates start/end'));
            return FALSE;
        }

        return TRUE;
    }

    public function _check_unique_code($str)
    {
        $id = $this->uri->segment(4);
        $this->db->where('coupon_code', $this->input->post('coupon_code'));
        !$id || $this->db->where('id !=', $id);
        $rows = $this->registration_coupon_m->get();

        if (sw_count($rows))
        {
            $this->form_validation->set_message('_check_unique_code', '%s should be unique');
            return FALSE;
        }

        return TRUE;
    }

    public function _check_discount_value($str)
    {
        $type = $this->input->post('discount_type');
        $value = (float) $str;

        if ($type === 'percent' && $value > 100)
        {
            $this->form_validation->set_message('_check_discount_value', lang_check('Percent discount cannot exceed 100'));
            return FALSE;
        }

        return TRUE;
    }
}
