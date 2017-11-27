<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lsk_model extends CI_Model {

        public function __construct()
        {
                parent::__construct(); 
                //https://github.com/cb0/LiskPHP
                require __DIR__.'/../../vendor/autoload.php';
                $this->checkUpdate();
        }

        public function checkUpdate() {
            $time = strtotime("+15 minutes");
            $sql = "SELECT last_update FROM updated ORDER BY id DESC LIMIT 1";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $last_update = $query->row()->last_update;
                if ($last_update > $time) {
                    return $this->updateData();
                }
            } else {
                return $this->updateData();
            }
            return array("success" => 1, "error" => "");
        }

        private function updateData() {
            // things to get: delegate, address_id, json_data, approval%
            // data insert only: 
            // table - delegates: delegate, address_id
            // table - approval: approval(float), created(int), did, weight (float)
            // table - updated: last_update(int)
            // data update only: 
            // table - delegates: json_data
            /*
            [0] => Delegateusername
            [1] => Delegatevote
            [2] => Delegateproducedblocks
            [3] => Delegatemissedblocks
            [4] => Delegaterate
            [5] => Delegaterank
            [6] => Delegateapproval
            [7] => Delegateproductivity
            [8] => Accountaddress
            [9] => AccountpublicKey
            */
            $delegateData = [];
            $totalDelegates = $this->getTotalDelegates();
            $totalDelegates = $totalDelegates["result"][0];
            $delegateFor = ($totalDelegates / 100);
            $offset = 0;
            for ($i=0; $i<=$delegateFor; $i++) {
                $delegateList = $this->getDelegateList(100, $offset); // Lisk.io API limit 100 MAX 
                $offset += 100; 
                if (isset($delegateList["result"])) {
                   foreach ($delegateList["result"] as $v) {
                        $delegateData[] = $v;
                    } 
                }
            }  
            foreach ($delegateData as $v) {
                // get additional delegate data
                $weight = $v[1];
                $approval = $v[6];
                $json_data = json_encode($v);
                // check if delegate exists
                $sql = "SELECT id FROM delegates WHERE address_id = ".$this->db->escape($v[9]);
                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    // delegate exists
                    $did = $query->row()->id;
                    $sql = "INSERT INTO approval (did, weight, approval, created) VALUES (".$this->db->escape($did).", ".$this->db->escape($weight).", ".$this->db->escape($approval).", UNIX_TIMESTAMP(NOW()))";
                    $this->db->query($sql);
                    $sql = "UPDATE delegates SET weight = ".$this->db->escape($weight).", json_data = ".$this->escape($json_data)." WHERE id = ".$this->escape($did);
                    $this->db->query($sql);
                } else {
                    // delegate doesnt exist
                    $sql = "INSERT INTO delegates (delegate, address_id, weight, json_data) VALUES (".$this->db->escape($v[0]).", ".$this->db->escape($v[8]).", ".$this->db->escape($weight).", ".$this->db->escape($json_data).")";
                    $this->db->query($sql);
                    $sql = "SELECT id FROM delegates WHERE address_id = ".$this->db->escape($v[8]);
                    $query1 = $this->db->query($sql);
                    $did = $query1->row()->id;
                    $sql = "INSERT INTO approval (did, weight, approval, created) VALUES (".$this->db->escape($did).", ".$this->db->escape($weight).", ".$this->db->escape($approval).", UNIX_TIMESTAMP(NOW()))";
                    $this->db->query($sql);
                }
            }
            $sql = "INSERT INTO updated (last_update) VALUES (UNIX_TIMESTAMP(NOW()))";
            $this->db->query($sql);
            return;
        }

        private function toHuman($number) {
            return number_format(sprintf("%.8f", $number / 100000000), 2, '.', '');
        }

        protected function parseLiskResult($result) {
            $getall = 0;
            $output = [];
            $output["success"] = 1;
            $keycounter = -1; 
            $notlist = 0;
            foreach ((array)$result as $k => $v) {
                if (!is_array($v) && !is_object($v)) {
                    $dispersekey = explode("\\", $k);
                    $output["keys"][] = (string)$dispersekey[(count($dispersekey) - 1)];
                    $output["result"][] = $v;
                    $notlist = 1;
                }
                if ($notlist == 0) {
                    $keycounter += 1;
                    if ($keycounter == 0) { 
                        if (count((array)$v) > 1) { 
                            // an array of items
                            $justintimecounter = -1;
                            foreach((array)$v as $kk => $vv) {
                                $dispersekey = explode('"', $kk);
                                $dispersekey = explode("\\", $dispersekey[0]);
                                if (count((array)$vv) > 1) { 
                                    $justintimecounter += 1;
                                    foreach ((array)$vv as $kb => $vb) {
                                        $dispersekey = explode("\\", $kb);
                                        $output["keys"][] = (string)$dispersekey[(count($dispersekey) - 1)];
                                        $output["result"][$justintimecounter][] = $vb;
                                    }
                                } else {
                                    $output["keys"][] =(string)$dispersekey[(count($dispersekey) - 1)];
                                    $output["result"][$keycounter][] = $vv;
                                }
                                
                            }
                        } else {
                            // spit out all items just in case
                            $getall = 1;
                        }
                    }
                }
                
            }
            if ($getall == 1) {
                foreach ((array)$result as $k => $v) { 
                    $dispersekey = explode('"', $k); 
                    $output["keys"] = $dispersekey[0];
                    $output["result"][] = (array)$v;
                }
            }
            $newresultarray = [];
            // delete last 2 items in result array
            $totalkeys = count($output["result"]);
            $del1 = $totalkeys - 1;
            $del2 = $totalkeys - 2;
            unset($output["result"][$del1]);
            unset($output["result"][$del2]);
            $output["keys"] = array_unique($output["keys"]); 
             // foreach ($output["result"] as $kk => $arr) {
             //     foreach ($arr as $k => $v) {
             //         if (isset($output["keys"][$k])) {
             //             $newresultarray[$kk][(string)strtolower($output["keys"][$k])] = $v;
             //         } 
             //     }
             // }
             // $output["result"] = $newresultarray;
            return $output;
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

        protected function generatePageDateIdentifier() {
            $year = date("Y");
            $month = date("F");
            $q1 = array("January", "February", "March");
            $q2 = array("April", "May", "June");
            $q3 = array("July", "August", "September");
            $q4 = array("October", "November", "December");
            if (in_array($month, $q1)) {
                $output = "Q1-".$year;
            }
            if (in_array($month, $q2)) {
                $output = "Q2-".$year;
            }
            if (in_array($month, $q3)) {
                $output = "Q3-".$year;
            }
            if (in_array($month, $q4)) {
                $output = "Q4-".$year;
            }
            return $output;
        }

        public function getHomeData() {
            $output = [];
            $sql = "
                SELECT
                d.id AS 'did',
                d.delegate,
                d.address_id,
                d.grp,
                d.rewards,
                (
                    SELECT
                        a.approval
                    FROM
                        approval a
                    WHERE
                        a.did = d.id
                    ORDER BY
                        created DESC
                    LIMIT 1
                )AS 'approval',
                (
                    SELECT
                        a.weight
                    FROM
                        approval a
                    WHERE
                        a.did = d.id
                    ORDER BY
                        created DESC
                    LIMIT 1
                )AS 'weight',
                (
                    SELECT
                        COALESCE(COUNT(k.karma), 0)
                    FROM
                        karma k
                    WHERE
                        k.did = d.id
                    AND k.karma = '0'
                )AS 'negative_karma',
                (
                    SELECT
                        COALESCE(COUNT(kk.karma), 0)
                    FROM
                        karma kk
                    WHERE
                        kk.did = d.id
                    AND kk.karma = '1'
                )AS 'positive_karma'
            FROM
                delegates d
            ORDER BY
                d.weight DESC
            ";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                foreach($query->result_array() as $res) {
                    $output[] = array(
                        "did" => $res["did"],
                        "name" => $res["delegate"],
                        "address_id" => $res["address_id"],
                        "group" => $res["grp"],
                        "rewards" => $res["rewards"],
                        "approval" => $res["approval"],
                        "weight" => $this->toHuman($res["weight"]),
                        "negative_karma" => $res["negative_karma"],
                        "positive_karma" => $res["positive_karma"]
                    );
                }
                return $output;
            } else {
                return array();
            }
        }

        public function getDelegate($publicKey=null, $username=null) {
            try {
                $client = new \Lisk\Client(LISK_SERVER);
                $result = $client->getDelegate($publicKey, $username);
                $result = $this->parseLiskResult($result);
                return $result;
            } catch (Throwable $t) {
                return (object)array("result" => null, "success" => 0, "error" => $t->getMessage());
            }
        }

        public function getDelegateList($limit, $offset, $orderBy=null) {
            try {
                $client = new \Lisk\Client(LISK_SERVER);
                $result = $client->getDelegateList($limit, $offset, $orderBy);
                $result = $this->parseLiskResult($result);
                return $result;
            } catch (Throwable $t) {
                return (object)array("result" => null, "success" => 0, "error" => $t->getMessage());
            }
        }

        public function getBalance($address) {
            try {
                $client = new \Lisk\Client(LISK_SERVER);
                $result = $client->getBalance($address);
                $result = $this->parseLiskResult($result);
                return $result;
            } catch (Throwable $t) {
                return (object)array("result" => null, "success" => 0, "error" => $t->getMessage());
            }
        }

        public function getTotalDelegates() {
            try {
                $client = new \Lisk\Client(LISK_SERVER);
                $result = $client->getDelegateCount();
                $result = $this->parseLiskResult($result); 
                return $result;
            } catch (Throwable $t) {
                return (object)array("result" => null, "success" => 0, "error" => $t->getMessage());
            }
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