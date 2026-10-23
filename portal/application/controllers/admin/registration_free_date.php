<?php

class Registration_free_date extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('admin/registration_license/free_date');
    }

    public function edit()
    {
        redirect('admin/registration_license/free_date');
    }
}
