<?php

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('auth_model');
        $this->load->library('user_level');
        $this->load->library('date_time');
    }

    public function index()
    {
        $id = $this->session->userdata('id');
        $role = $this->session->userdata('role');
        $user_info['user_info'] = $this->auth_model->get_data_by_id($id);
        $user_info['user_level'] = $this->user_level->level($role);
        $user_info['all_user'] = $this->auth_model->get_all_data();
        $user_info['post'] = $this->auth_model->get_all_post();
        
        $this->load->view('header');
        $this->load->view('navbar' , $user_info);
        $this->load->view('post/content', $user_info);
        $this->load->view('post/footer');
    }
    
    public function login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run()) {
            $check_login = $this->auth_model->login($email, $password);

            if ($check_login) {
                foreach ($check_login as $id => $value) {
                    $this->session->set_userdata($id, $value);
                }
                redirect('');
            } else {
                echo 'login fail';
            }
        }

        $this->load->view('auth/login');
    }

    public function logout()
    {
        $this->auth_model->logout();
        redirect('');
    }

    public function register()
    {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->form_validation->set_rules('firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run()) {
            $check_email = $this->auth_model->check_email($email);
            if ($check_email) {
                $this->session->set_flashdata('fail_message', 'User email already exists');
                redirect('auth/register');
            } else {
                $this->auth_model->register($firstname, $lastname, $email, $password);
            }
        }

        $this->load->view('auth/register');
    }

    public function edit_profile()
    {
        $id = $this->session->userdata('id');
        $user_info['user_info'] = $this->auth_model->get_data_by_id($id);
        $data = $this->auth_model->get_data_by_id($id);
        $Original_password = $data['password'];

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');

        $this->form_validation->set_rules('firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('old_password', 'Password', 'required');
        $this->form_validation->set_rules('new_password', 'Password', 'required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run()) {
            if (md5($old_password) == $Original_password) {
                if ($old_password == $new_password) {
                    $this->session->set_flashdata('fail_message', 'Old and new passwords match.');
                    redirect('auth/edit_profile');
                } else {
                    $this->auth_model->update_profile($id, $firstname, $lastname, $email, $new_password);
                    $this->session->set_flashdata('success_message', 'Password changed successfully.');
                    redirect('auth/edit_profile');
                }
            } else {
                $this->session->set_flashdata('fail_message', 'The old password is invalid.');
                redirect('auth/edit_profile');
            }
        }
        $this->load->view('edit/edit_profile', $user_info);
    }

    public function edit_img_profile()
    {
        $id = $this->session->userdata('id');

        $config['upload_path'] = './assets/upload/user_img/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = 10000;
        $config['max_width'] = 10000;
        $config['max_height'] = 10000;

        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('userfile')) {
            $error = array(
                'error' => $this->upload->display_errors()
            );

            $this->load->view('edit/edit_img', $error);
        } else {

            $user_img = '/assets/upload/user_img/' . $this->upload->data('file_name');
            $this->auth_model->updata_img($id, $user_img);

            $data = array(
                'upload_data' => $this->upload->data()
            );
            $this->load->view('edit/edit_img_success', $data);
        }
    }
    
    public function admin()
    {
        $id = $this->session->userdata('id');
        $role = $this->session->userdata('role');
        $user_info['user_info'] = $this->auth_model->get_data_by_id($id);
        $user_info['all_user'] = $this->auth_model->get_all_data();
        $user_info['user_level'] = $this->user_level->level($role);
        
        $this->load->view('header');
        $this->load->view('navbar', $user_info);
        $this->load->view('admin/admin', $user_info);
    }

    public function bypass()
    {
        isset($_GET['id']) ? $id = $_GET['id'] : $id = '';
        $data = $this->auth_model->get_data_by_id($id);

        $email = $data['email'];
        $password = $data['password'];

        $check_bypass = $this->auth_model->bypass($email, $password);

        foreach ($check_bypass as $id => $value) {
            $this->session->set_userdata($id, $value);
        }
        redirect('');
    }

    public function edit_user()
    {
        isset($_GET['id']) ? $id = $_GET['id'] : $id = '';
        $user_info['user_info'] = $this->auth_model->get_data_by_id($id);

        $data = $this->auth_model->get_data_by_id($id);
        $Original_password = $data['password'];

        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $email = $this->input->post('email');
        $old_password = $this->input->post('old_password');
        $new_password = $this->input->post('new_password');

        $this->form_validation->set_rules('firstname', 'Firstname', 'required');
        $this->form_validation->set_rules('lastname', 'Lastname', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('old_password', 'Password', 'required');
        $this->form_validation->set_rules('new_password', 'Password', 'required');
        $this->form_validation->set_rules('conf_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run()) {
            if (md5($old_password) == $Original_password) {
                if ($old_password == $new_password) {
                    $this->session->set_flashdata('fail_message', 'Old and new passwords match.');
                    redirect('auth/edit_user?id=' . $id);
                } else {
                    $this->auth_model->update_profile($id, $firstname, $lastname, $email, $new_password);
                    $this->session->set_flashdata('success_message', 'Password changed successfully.');
                    redirect('auth/edit_user?id=' . $id);
                }
            } else {
                $this->session->set_flashdata('fail_message', 'The old password is invalid.');
                redirect('auth/edit_user?id=' . $id);
            }
        }
        $this->load->view('edit/edit_profile', $user_info);
    }

    public function delete_user_1()
    {
        isset($_GET['id']) ? $id = $_GET['id'] : $id = '';
        $this->auth_model->delete_1($id);
        redirect('');
    }

    public function delete_user_2()
    {
        isset($_GET['id']) ? $id = $_GET['id'] : $id = '';
        $this->auth_model->delete_2($id);
    }

    public function comment()
    {}


    public function add_post()
    {
        $comment = $this->input->post('comment');

        $this->form_validation->set_rules('comment', 'Comment', 'required');

        if ($this->form_validation->run()) {
            $config['upload_path'] = './assets/upload/post_img/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = 10000;
            $config['max_width'] = 10000;
            $config['max_height'] = 10000;

            $this->load->library('upload', $config);

            if (! $this->upload->do_upload('userfile')) {
                $error = array(
                    'error' => $this->upload->display_errors()
                );

                $this->load->view('edit/edit_img', $error);
            } else {
                $id = $this->session->userdata('id');
                $post_img = '/assets/upload/post_img/' . $this->upload->data('file_name');
                $this->auth_model->add_post($id, $comment, $post_img);

                redirect('');
            }
        }
        $this->load->view('post/add_post');
    }
    
    public function edit_post()
    {
        
    }
    
    public function delete_post(){
        
    }
}
?>