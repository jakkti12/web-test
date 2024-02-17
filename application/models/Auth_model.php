<?php

class Auth_model extends CI_Model
{

    function login($email = null, $password = null)
    {
        $query = $this->db->query("SELECT * FROM users WHERE email = '$email' ");
        $check_login = $query->row();
        $count = $query->num_rows();
        $result = $query->result();

        $hash_password = md5($password);

        if ($count) {
            foreach ($result as $value) {
                if ($value->email == $email && $value->password == $hash_password) {
                    return $check_login;
                }
            }
        }
    }

    function logout()
    {
        $data = array(
            'id' => '',
            'email' => '',
            'password' => ''
        );

        return $this->session->sess_destroy($data);
    }

    function register($firstname = null, $lastname = null, $email = null, $password = null)
    {
        $user_info = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => md5($password),
            'status' => '1',
            'banned_users' => 'unban',
            'role' => '4'
        );

        $this->db->insert('users', $user_info);
        return true;
    }

    function check_email($email)
    {
        $this->db->get_where('users', array(
            'email' => $email
        ), 1);
        $check_email = $this->db->affected_rows();
        if ($check_email > 0) {
            return true;
        } else {
            return false;
        }
    }

    function get_data_by_id($id = null)
    {
        $result = $this->db->get_where('users', array(
            'id' => $id
        ));

        return $result->row_array();
    }

    function get_all_data()
    {
        $result = $this->db->query("SELECT * FROM users");

        return $result;
    }
    
    function get_all_post()
    {
        $result = $this->db->query("SELECT * FROM post");
        
        return $result;
    }

    function update_profile($id = null, $firstname = null, $lastname = null, $email = null, $new_password = null)
    {
        $data = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'password' => md5($new_password)
        );
        $this->db->where('id', $id);
        $this->db->update('users', $data);
        return true;
    }

    function updata_img($id = null, $user_img = null)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array(
            'user_picture' => $user_img
        ));
        return true;
    }

    function bypass($email = null, $password = null)
    {
        $query = $this->db->query("SELECT * FROM users WHERE email = '$email' ");
        $check_bypass = $query->row();
        $count = $query->num_rows();
        $result = $query->result();

        if ($count) {
            foreach ($result as $value) {
                if ($value->email == $email && $value->password == $password) {
                    return $check_bypass;
                }
            }
        }
    }

    function delete_1($id = null)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array(
            'status' => '0'
        ));
        return true;
    }

    function delete_2($id = null)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array(
            'status' => '0'
        ));
        return true;
    }

    function add_post($id = null, $comment = null, $post_img = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = array(
            'comment' => $comment,
            'img' => $post_img,
            'created_at' => date('Y-m-d H:i:s a'),
            'status' => '1',
            'user_id' => $id
        );
        $this->db->insert('post', $data);
        return;
    }
}