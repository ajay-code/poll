<?php
/**
 * Poll Management Class
 * This class is used to manage the online poll & voting system
 * @author    CodexWorld.com
 * @url       http://www.codexworld.com
 * @license   http://www.codexworld.com/license
 */
class Admin
{
    // private $dbHost  = 'us-cdbr-iron-east-05.cleardb.net';
    // private $dbUser  = 'b5fba7b8025cf0';
    // private $dbPwd   = 'd2728a90';
    // private $dbName  = 'heroku_e83e4a6f9df25f6';
    private $dbHost  = 'localhost';
    private $dbUser  = 'root';
    private $dbPwd   = '';
    private $dbName  = 'poll';
    private $db      = false;
    private $pollTbl = 'polls';
    private $optTbl  = 'poll_options';
    private $voteTbl = 'poll_votes';
    
    /**
     * Establlish database connection on construction
     *
     * @return void
     */
    public function __construct()
    {
        @session_start();
        
        if (!$this->db) {
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUser, $this->dbPwd, $this->dbName);
            if ($conn->connect_error) {
                die("Failed to connect with MySQL: " . $conn->connect_error);
            } else {
                $this->db = $conn;
            }
        }
    }

    /**
     * Login the admin
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function login($username = '', $password = '')
    {
        $password = md5($password);
        $sql = "SELECT * FROM `admin` WHERE `username` = '{$username}' AND `password` = '{$password}'";
        if ($this->getQuery($sql, 'count')) {
            if ($_POST['remember']) {
                setcookie('log', 1, time()+60*60*24);
            } else {
                $_SESSION['log'] = '1';
            }
            
            return true;
        }
        return false;
    }

    /**
     * Login the admin
     *
     * @return void
     */
    public function logout()
    {
        setcookie("log", "", time()-3600);
        unset($_SESSION['log']);
        header('LOCATION: index.php');
    }

    /**
     * Redirect to home page if logged in
     *
     * @return void
     */
    public function redirectIfLoggedIn()
    {
        if (isset($_SESSION['log']) || isset($_COOKIE['log'])) {
            header('LOCATION: home.php');
        }
    }

    /**
     * Redirect to login page if not logged in
     *
     * @return void
     */
    public function redirectIfNotLoggedIn()
    {
        if (!(isset($_SESSION['log']) || isset($_COOKIE['log']))) {
            header('LOCATION: index.php');
        }
    }
    
    /**
     * Runs query to the database
     *
     * @param string SQL
     * @param string count, single, all
     * @return int or
     * @return array
     */
    private function getQuery($sql, $returnType = '')
    {
        $data = '';
        $result = $this->db->query($sql);
        if ($result) {
            switch ($returnType) {
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                case 'update':
                    $data = $result;
                    break;
                case 'delete':
                    $data = $result;
                    break;
                case 'insert':
                    $data = $result;
                    break;
                default:
                    if ($result->num_rows > 0) {
                        $data = [];
                        while ($row = $result->fetch_assoc()) {
                            $data[] = $row;
                        }
                    }
            }
        }
        return !empty($data)?$data:false;
    }
    
    /**
     * Get polls data
     *
     * @return single or multiple poll data with respective options
     * @param string single, all
     */
    public function getPolls($pollType = 'single')
    {
        $pollData = array();
        $sql = "SELECT * FROM ".$this->pollTbl." WHERE status = '1' ORDER BY created DESC";
        $pollResult = $this->getQuery($sql, $pollType);
        if (!empty($pollResult)) {
            if ($pollType == 'single') {
                $pollData['poll'] = $pollResult;
                $sql2 = "SELECT * FROM ".$this->optTbl." WHERE poll_id = ".$pollResult['id']." AND status = '1'";
                $optionResult = $this->getQuery($sql2);
                $pollData['options'] = $optionResult;
            } else {
                $i = 0;
                foreach ($pollResult as $prow) {
                    $pollData[$i]['poll'] = $prow;
                    $sql2 = "SELECT * FROM ".$this->optTbl." WHERE poll_id = ".$prow['id']." AND status = '1'";
                    $optionResult = $this->getQuery($sql2);
                    $pollData[$i]['options'] = $optionResult;
                }
            }
        }
        return !empty($pollData)?$pollData:false;
    }

    /**
     * Get option by id
     *
     * @param int $optionID
     * @return array $data;
     */
    public function getOption($optionID)
    {
        $sql = "SELECT * FROM ".$this->optTbl." WHERE id = {$optionID} ORDER BY created DESC";
        $data = $this->getQuery($sql, 'single');
        return $data;
    }
    
    
    
    /**
     * Get poll result
     *
     * @param poll ID
     */
    public function getResult($pollID)
    {
        $resultData = array();
        if (!empty($pollID)) {
            $sql = "SELECT p.subject, SUM(v.vote_count) as total_votes FROM ".$this->voteTbl." as v LEFT JOIN ".$this->pollTbl." as p ON p.id = v.poll_id WHERE poll_id = ".$pollID;
            $pollResult = $this->getQuery($sql, 'single');
            if (!empty($pollResult)) {
                $resultData['poll'] = $pollResult['subject'];
                $resultData['total_votes'] = $pollResult['total_votes'];
                $sql2 = "SELECT o.id, o.name, v.vote_count FROM ".$this->optTbl." as o LEFT JOIN ".$this->voteTbl." as v ON v.poll_option_id = o.id WHERE o.poll_id = ".$pollID;
                $optResult = $this->getQuery($sql2);
                if (!empty($optResult)) {
                    foreach ($optResult as $orow) {
                        $resultData['options'][$orow['name']] = $orow['vote_count'];
                    }
                }
            }
        }
        return !empty($resultData)?$resultData:false;
    }

    /**
     * Update poll question
     *
     * @return boolean
     */

    public function updateQuestion()
    {
        $title = $_POST['title'];
        $subject = $_POST['subject'];

        $query = "UPDATE `{$this->pollTbl}` SET `title` = '{$title}', `subject` = '{$subject}'  where `id` = 1 ";
        if ($this->getQuery($query, 'update')) {
            return true;
        }

        return false;
    }

    /**
     * Update poll option
     *
     * @return boolean
     */
    public function updateOption()
    {
        $option = $this->getOption($_GET['optionID']);
        $name = $_POST['name'];
        if ($_FILES["img"]["name"]) {
            $target_dir = "uploads/";
            $uploadOk = 1;
            $imageFileType = pathinfo(basename($_FILES["img"]["name"]), PATHINFO_EXTENSION);
            $new_filename = $target_dir . $this->random_string(10) . '.' . $imageFileType;
            $target_file = '../' . $new_filename;
            if (isset($_POST["submit-option"])) {
                $check = getimagesize($_FILES["img"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    $query = "UPDATE `{$this->optTbl}` SET `name` = '{$name}', `img` = '{$new_filename}', `modified` = NOW()  where `id` = {$option['id']} and `poll_id` = {$option['poll_id']} ";
                    if ($this->getQuery($query, 'update')) {
                        return true;
                    }
                }
            }
        } else {
            $query = "UPDATE `{$this->optTbl}` SET `name` = '{$name}', `modified` = NOW()  where `id` = {$option['id']} and `poll_id` = {$option['poll_id']} ";
            if ($this->getQuery($query, 'update')) {
                return true;
            }
        }
    
        return false;
    }

    /**
     * Delete option
     *
     * @param int $optionID
     * @return boolean
     */
    public function deleteOption($optionID)
    {
        $query = "DELETE FROM {$this->optTbl} where id={$optionID}";
        if ($this->getQuery($query, 'delete')) {
            return true;
        }
        return false;
    }

    /**
     * Update poll option
     *
     * @return boolean
     */
    public function createOption()
    {
        $name = $_POST['name'];

        if($_FILES["img"]["name"]){
            $target_dir = "uploads/";
            $uploadOk = 1;
            $imageFileType = pathinfo(basename($_FILES["img"]["name"]), PATHINFO_EXTENSION);
            $new_filename = $target_dir . $this->random_string(10) . '.' . $imageFileType;
            $target_file = '../' . $new_filename;
    
            if (isset($_POST["submit-option"])) {
                $check = getimagesize($_FILES["img"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }
    
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                    $query = "INSERT INTO `{$this->optTbl}`  (poll_id, name, img ,created, modified )
                    VALUES (1, '{$name}','{$new_filename}', NOW(), NOW())";
                    if ($this->getQuery($query, 'insert')) {
                        return true;
                    }
                }
            }
        }else{
            $query = "INSERT INTO `{$this->optTbl}` (poll_id, name, created, modified ) 
                        VALUES (1, '{$name}', NOW(),  NOW())";
            if ($this->getQuery($query, 'insert')) {
                return true;
            }
        }
        return false;
    }

    /**
     * Generate random string of given number
     *
     * @param int $lenght
     * @return string $key
     */
    private function random_string($length)
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }
}
