<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lsk_model extends CI_Model {

        public function __construct()
        {
                parent::__construct(); 
                //https://github.com/cb0/LiskPHP
                require __DIR__.'/../../vendor/autoload.php';
        }
 


        
        protected function parseLiskResult($result) {
                        try {
                $client = new \Lisk\Client('https://login.lisk.io/');
                $result = $client->getDelegate(null, 'jopanel');
                $result = (array)$result;
                echo "<pre>";
                var_dump($result);
                echo "</pre>";
            } catch (Throwable $t) {
                echo sprintf("Error: %s\n", $t->getMessage());
            } 
        }

        protected function generateSalt() {
                $salt = "xiORG17N6ayoEn6X3";
                return $salt;
        }

        protected function generateVerificationKey() {
                $length = 10;
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
        }

        public function register($postData=null) {
            $error = 0;
            if (!isset($postData["username"]) || empty($postData["username"])) { $error = 2;} else { $username = $this->db->escape(strip_tags($postData["username"]));}
            if (!isset($postData["password"]) || empty($postData["password"])) { $error = 3;} else { $password = strip_tags($postData["password"]);}
            if (!isset($postData["password2"]) || empty($postData["password2"])) { $error = 4;} else { $password2 = strip_tags($postData["password2"]);}
            if (!isset($postData["name"]) || empty($postData["name"])) { $error = 6;} else { $name = $this->db->escape(strip_tags($postData["name"]));}
            $verification_key = $this->db->escape($this->generateVerificationKey());
            $salt = $this->generateSalt();
            if ($password !== $password2) { $error = 8; } else { $password = $this->db->escape(md5($salt.$password)); }
            if ($error > 0) { return $error; }
            $now = $this->db->escape(time());
            $sql = "SELECT * FROM users WHERE username = ".$username;
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                    return 9;
            } else {
                $sql2 = "INSERT INTO users (username,password,created,verification_key,name) VALUES ($username, $password, $now, $verification_key, $name)";
                $this->db->query($sql2);
                return TRUE;   
            }
        }


        public function getUserIP() {
		    $ipaddress = '';
		    if (isset($_SERVER['HTTP_CLIENT_IP']))
		        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		    else if(isset($_SERVER['HTTP_X_FORWARDED']))
		        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		    else if(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
		        $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
		        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		    else if(isset($_SERVER['HTTP_FORWARDED']))
		        $ipaddress = $_SERVER['HTTP_FORWARDED'];
		    else if(isset($_SERVER['REMOTE_ADDR']))
		        $ipaddress = $_SERVER['REMOTE_ADDR'];
		    else
		        $ipaddress = 'UNKNOWN';
		    return $ipaddress;
	   }

        public function login($postData) {
        	if (!isset($postData["username"])) { return 2; }
        	if (!isset($postData["password"])) { return 2; }
                $salt = $this->generateSalt();
        	$username = $this->db->escape(strip_tags($postData["username"]));
        	$password = $this->db->escape(strip_tags(md5($salt.$postData["password"])));
        	$sql = "SELECT a.*, ag.name as 'role' FROM opa_admin a 
            LEFT JOIN opa_admin_groups ag ON a.admin_group = ag.id
            WHERE a.username = ".$username." AND a.password = ".$password;
        	$query = $this->db->query($sql);
        	if ($query->num_rows() > 0) {
        		$q = $query->row();
                $this->session->set_userdata("role", $q->role);
        		$this->session->set_userdata("username",$q->username);
        		$this->session->set_userdata("verification_key",$q->verification_key);
        		$this->session->set_userdata("admin_id", $q->id);
        		$this->session->set_userdata("loggedin",1);
        		$ip = $this->getUserIP();
        		$sql2 = "UPDATE users SET last_login = NOW(), ip = ".$this->db->escape($ip)." WHERE id = ".$q->id;
        		$this->db->query($sql2);
        		return TRUE;
        	} else {
        		return 2;
        	}
        }

        public function verifyUser() {
        	if ($this->session->userdata("username") && $this->session->userdata("verification_key") && $this->session->userdata("loggedin")) {
        		$sql = "SELECT * FROM opa_admin WHERE verification_key = ".$this->db->escape(strip_tags($this->session->userdata("verification_key")))." AND username = ".$this->db->escape(strip_tags($this->session->userdata("username")));
        		$query = $this->db->query($sql);
        		if ($query->num_rows() > 0) {
        			return TRUE;
        		} else {
        			$this->logout();
        			redirect(base_url()."login");
        		}
        	} else {
        		$this->logout();
        		redirect(base_url()."login");
        	}
        }

        public function logout() {
        	$this->session->unset_userdata("username");
        	$this->session->unset_userdata("verification_key");
        	$this->session->unset_userdata("loggedin");
        	return TRUE;
        }

}