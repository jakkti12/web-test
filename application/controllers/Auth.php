<?php
class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->view('admin');
    }
    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[3]');

        if ($this->form_validation->run()) {
            $query = $this->db->query("SELECT * FROM users WHERE email = '$email'");
            $item = $query->result();
            $count = $query->num_rows();
            $check_login = $query->row();

            $hash_password = md5($password);

            if ($count == 1) {
                foreach ($item as $row) {
                    if ($row->email == $email && $row->password == $hash_password) {
                        foreach ($check_login as $id => $val) {
                            $this->session->set_userdata($id, $val);
                        }
                        redirect('');
                    }
                }

                $this->session->set_flashdata('fail_message', 'Wrong password or email.');
                redirect('auth/login');
            } elseif ($count == 0) {
                $this->session->set_flashdata('fail_message', 'Wrong password or email.');
                redirect('auth/login');
            } elseif ($check_login->banned_users == "ban") {
            }
        }
    }
}
