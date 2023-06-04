<?php
session_start();
ini_set('display_errors', 1);

class Action
{
    private $db;

    public function __construct()
    {
        ob_start();
        include './db_connect.php';

        $this->db = $conn;
    }

    function __destruct()
    {
        $this->db->close();
        ob_end_flush();
    }

    function studentLogin()
    {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM login_info WHERE pass='" . md5($password) . "' AND userid='" . strtolower(trim($cid)) . "'");
        if ($qry ? $qry->num_rows > 0 : false) {
            $row = $qry->fetch_assoc();
            foreach ($row as $key => $value) {
                if ($key != 'password' && !is_numeric($key)) {
                    $_SESSION['login_' . $key] = $value;
                }
            }
            if (isset($_SESSION['login_userid'])) {
                $bio = $this->db->query("SELECT * FROM user_registration WHERE userid='" . strtolower($_SESSION['login_userid']) . "'");
                if ($bio ? $bio->num_rows > 0 : false) {
                    $bioRow = $bio->fetch_assoc();
                    foreach ($bioRow as $key => $value) {
                        if ($key != 'password' && !is_numeric($key)) {
                            $_SESSION['bio'][$key] = $value;
                        }
                    }
                }
            }
            if ($_SESSION['bio']['email'] != strtolower(trim($email))) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 3;
            }
            if ($_SESSION['bio']['status'] == 0) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 4;
            }
            if ($_SESSION['bio']['usertype'] != 1) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 2;
            }
            return 1;
        } else {
            return 3;
        }
    }

    function CollegeHeadLogin()
    {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM login_info WHERE pass='" . md5($password) . "' AND userid='" . strtolower(trim($cid)) . "'");
        if ($qry ? $qry->num_rows > 0 : false) {
            $row = $qry->fetch_assoc();
            foreach ($row as $key => $value) {
                if ($key != 'password' && !is_numeric($key)) {
                    $_SESSION['login_' . $key] = $value;
                }
            }
            if (isset($_SESSION['login_userid'])) {
                $bio = $this->db->query("SELECT * FROM user_registration WHERE userid='" . strtolower($_SESSION['login_userid']) . "'");
                if ($bio ? $bio->num_rows > 0 : false) {
                    $bioRow = $bio->fetch_assoc();
                    foreach ($bioRow as $key => $value) {
                        if ($key != 'password' && !is_numeric($key)) {
                            $_SESSION['bio'][$key] = $value;
                        }
                    }
                }
            }
            if ($_SESSION['bio']['email'] != strtolower(trim($email))) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 3;
            }
            if ($_SESSION['bio']['status'] == 0) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 4;
            }
            if ($_SESSION['bio']['usertype'] != 3) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 2;
            }
            return 1;
        } else {
            return 3;
        }
    }

    function FacultyHeadLogin()
    {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM login_info WHERE pass='" . md5($password) . "' AND userid='" . strtolower(trim($fid)) . "'");
        if ($qry ? $qry->num_rows > 0 : false) {
            $row = $qry->fetch_assoc();
            foreach ($row as $key => $value) {
                if ($key != 'password' && !is_numeric($key)) {
                    $_SESSION['login_' . $key] = $value;
                }
            }
            if (isset($_SESSION['login_userid'])) {
                $bio = $this->db->query("SELECT * FROM user_registration WHERE userid='" . strtolower($_SESSION['login_userid']) . "'");
                if ($bio ? $bio->num_rows > 0 : false) {
                    $bioRow = $bio->fetch_assoc();
                    foreach ($bioRow as $key => $value) {
                        if ($key != 'password' && !is_numeric($key)) {
                            $_SESSION['bio'][$key] = $value;
                        }
                    }
                }
            }
            if ($_SESSION['bio']['email'] != strtolower(trim($email))) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 3;
            }
            if ($_SESSION['bio']['status'] == 0) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 4;
            }
            if ($_SESSION['bio']['usertype'] != 2) {
                foreach ($_SESSION as $key => $value) {
                    unset($_SESSION[$key]);
                }
                return 2;
            }
            return 1;
        } else {
            return 3;
        }
    }

    function ForgetPassword()
    {
        extract($_POST);
        $qry = $this->db->query("SELECT * FROM login_info WHERE userid='" . strtolower(trim($uid)) . "' AND usertype='" . $userType . "'");
        if ($qry ? $qry->num_rows > 0 : false) {
            $save = $this->db->query("UPDATE login_info SET pass='" . md5(trim($password)) . "' WHERE userid='" . strtolower(trim($uid)) . "' AND usertype='" . $userType . "'");
            if ($save) {
                return 1;
            }
        } else {
            return 2;
        }
    }

    function SignUp()
    {
        extract($_POST);
        $emailExists = $this->db->query("SELECT * FROM user_registration WHERE email = '" . strtolower(trim($email)) . "'");
        if ($emailExists ? $emailExists->num_rows > 0 : false) {
            return 2; // User with the same email already exists
        }

        // Check if user with the same CID already exists
        $cidExists = $this->db->query("SELECT * FROM user_registration WHERE userid = '" . strtolower(trim($cid)) . "'");
        if ($cidExists ? $cidExists->num_rows > 0 : false) {
            return 3; // User with the same CID already exists
        }

        $data = " firstname = '" . $firstname . "'";
        $data .= ", lastname = '" . $lastname . "'";
        $data .= ", email = '" . strtolower(trim($email)) . "'";
        $data .= ", userid = '" . strtolower(trim($cid)) . "'";
        $data .= ", course = '$course'";
        $data .= ", usertype = 1";
        $data .= ", status = 0";
        $data .= ", semester = '$semester'";
        $save = $this->db->query("INSERT INTO user_registration SET $data;");
        if ($save) {
            $data = "userid = '" . strtolower(trim($cid)) . "', pass = '" . md5(trim($password)) . "', usertype = 1";
            $login_info = $this->db->query("INSERT INTO login_info SET $data;");
            if ($login_info) {
                return 1;
            } else {
                $this->db->query("DELETE FROM user_registration WHERE userid='" . strtolower(trim($cid)) . "' AND email='" . strtolower(trim($email)) . "'");
                return 4;
            }
        } else {
            return 4;
        }
    }

    function logout()
    {
        session_destroy();
        foreach ($_SESSION as $key => $value) {
            unset($_SESSION[$key]);
        }
        return json_encode(array('success' => true));
    }
    function addmessage()
    {
        extract($_POST);
        $result =  $this->db->query("INSERT INTO chats SET query_id = " . $_SESSION['selectedquery']['id'] . ", user_from = (Select id from user_registration where userid='" . $_SESSION['login_userid'] . "'),message='" . $message . "'");
        if ($result)
            return 1;
        else
            return $result;
    }
    function createQuery()
    {
        extract($_POST);
        $qry = $this->db->query("INSERT INTO queries (title, description, user_from, user_to) VALUES ('" . $title . "','" . $description . "'," . $_SESSION['bio']['id'] . "," . $faculty . ");");
        if ($qry) {
            return 1;
        } else {
            return $result;
        }
    }
    function updatechatStudent()
    {
        $result = $this->db->query("SELECT q.id,q.title AS `query`, q.description, q.status, DATE_FORMAT(q.timestamp, '%d-%b-%y %h:%i %p') AS `created on`, CONCAT(u.firstname, ' ', u.lastname) AS `created by`,
(SELECT CONCAT(xx.firstname, ' ', xx.lastname) FROM user_registration xx WHERE xx.id = q.user_to) AS `faculty name`,
CASE
WHEN u.course = 1 THEN 'CSE'
WHEN u.course = 2 THEN 'IT'
WHEN u.course = 3 THEN 'EE'
WHEN u.course = 4 THEN 'ECE'
WHEN u.course = 5 THEN 'ME'
WHEN u.course = 6 THEN 'CE'
END AS `department`
FROM queries q
INNER JOIN user_registration u ON u.id = q.user_from
WHERE q.id = " . $_GET['query'] . ";");
        $_SESSION['selectedquery'] = $result->fetch_assoc();
        $messages = $this->db->query("SELECT DATE_FORMAT(timestamp, '%d-%b-%y %h:%i %p') AS `addedon`, message, user_from FROM chats WHERE query_id = " . $_GET['query'] . " ORDER BY timestamp ASC");
        return require_once('../PHP/chatbox.php');
    }
    function updatechatfaculty()
    {
        $result = $this->db->query("SELECT q.id,q.title AS `query`, q.description, q.status, DATE_FORMAT(q.timestamp, '%d-%b %h:%i %p') AS `created on`, CONCAT(u.firstname, ' ', u.lastname) AS `created by`,
(SELECT CONCAT(xx.firstname, ' ', xx.lastname) FROM user_registration xx WHERE xx.id = q.user_to) AS `faculty name`,
CASE
WHEN u.course = 1 THEN 'CSE'
WHEN u.course = 2 THEN 'IT'
WHEN u.course = 3 THEN 'EE'
WHEN u.course = 4 THEN 'ECE'
WHEN u.course = 5 THEN 'ME'
WHEN u.course = 6 THEN 'CE'
END AS `department`
FROM queries q
INNER JOIN user_registration u ON u.id = q.user_to
WHERE q.id = " . $_GET['query'] . ";");
        $_SESSION['selectedquery'] = $result->fetch_assoc();
        $messages = $this->db->query("SELECT DATE_FORMAT(timestamp, '%d-%b %h:%i %p') AS `addedon`, message, user_from FROM chats WHERE query_id = " . $_GET['query'] . " ORDER BY timestamp ASC");
        return require_once('../PHP/chatbox.php');
    }
    function addFaculty()
    {
        extract($_POST);
        $emailExists = $this->db->query("SELECT * FROM user_registration WHERE email = '" . strtolower(trim($email)) . "'");
        if (($emailExists ? ($emailExists->num_rows > 0) : false)) {
            return 2;
        }

        $cidExists = $this->db->query("SELECT * FROM user_registration WHERE userid = '" . strtolower(trim($faculty_id)) . "'");
        if (($cidExists ? ($cidExists->num_rows > 0) : false)) {
            return 3;
        }

        $data = " firstname = '" . $first_name . "'";
        $data .= ", lastname = '" . $last_name . "'";
        $data .= ", email = '" . strtolower(trim($email)) . "'";
        $data .= ", userid = '" . strtolower(trim($faculty_id)) . "'";
        $data .= ", course = '$course'";
        $data .= ", usertype = 2";
        $data .= ", status = 1";
        $save = $this->db->query("INSERT INTO user_registration SET $data;");
        if ($save) {
            $data = "userid = '" . strtolower(trim($faculty_id)) . "', pass = '" . md5(12345678) . "', usertype = 2";
            $login_info = $this->db->query("INSERT INTO login_info SET $data;");
            if ($login_info) {
                return 1;
            } else {
                $this->db->query("DELETE FROM user_registration WHERE userid='" . strtolower(trim($faculty_id)) . "' AND email='" . strtolower(trim($email)) . "'");
                return 4;
            }
        } else {
            return 4;
        }
    }
    function updatechatadmin()
    {
        $result = $this->db->query("SELECT q.id,q.title AS `query`, q.description, q.status,q.user_from, DATE_FORMAT(q.timestamp, '%d-%b %h:%i %p') AS `created on`, CONCAT(u.firstname, ' ', u.lastname) AS `created by`,
(SELECT CONCAT(xx.firstname, ' ', xx.lastname) FROM user_registration xx WHERE xx.id = q.user_to) AS `faculty name`,
CASE
WHEN u.course = 1 THEN 'CSE'
WHEN u.course = 2 THEN 'IT'
WHEN u.course = 3 THEN 'EE'
WHEN u.course = 4 THEN 'ECE'
WHEN u.course = 5 THEN 'ME'
WHEN u.course = 6 THEN 'CE'
END AS `department`
FROM queries q
INNER JOIN user_registration u ON u.id = q.user_from
WHERE q.id = " . $_GET['query'] . ";");
        $_SESSION['selectedquery'] = $result->fetch_assoc();
        $messages = $this->db->query("SELECT DATE_FORMAT(timestamp, '%d-%b %h:%i %p') AS `addedon`, message, user_from FROM chats WHERE query_id = " . $_GET['query'] . " ORDER BY timestamp ASC");
        return require_once('../PHP/chatbox.php');
    }
    function disapprovestudent()
    {
        extract($_POST);
        $loginQuery = "DELETE FROM login_info WHERE userid = ?";
        $loginStmt = $this->db->prepare($loginQuery);
        $loginStmt->bind_param('s', $userid);
        $registrationQuery = "DELETE FROM user_registration WHERE userid = ?";
        $registrationStmt = $this->db->prepare($registrationQuery);
        $registrationStmt->bind_param('s', $userid);

        try {
            $loginStmt->execute();
            $loginRowCount = $loginStmt->affected_rows;

            if ($loginRowCount > 0) {
                $registrationStmt->execute();
                $registrationRowCount = $registrationStmt->affected_rows;

                if ($registrationRowCount > 0) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            return $e->getMessage();
        } finally {
            $loginStmt->close();
            $registrationStmt->close();
        }
    }
    function approvestudent()
    {
        // Extract the POST data
        extract($_POST);

        // Use prepared statement to update the user's status
        $stmt = $this->db->prepare("UPDATE user_registration SET status = 1 WHERE userid = ?");
        $stmt->bind_param('s', $userid);

        try {
            // Execute the query
            $stmt->execute();

            // Check the number of affected rows
            $rowCount = $stmt->affected_rows;

            if ($rowCount > 0) {
                return 1; // Update successful
            } else {
                return 0; // No rows updated
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, display an error message)
            return $e->getMessage(); // Return the error message
        } finally {
            // Close the database connection
            $stmt->close();
        }
    }
    function approvequery()
    {
        // Extract the POST data
        extract($_POST);

        // Use prepared statement to update the user's status
        $stmt = $this->db->prepare("UPDATE queries SET status = 1 WHERE id = ?");
        $stmt->bind_param('s', $id);

        try {
            // Execute the query
            $stmt->execute();

            // Check the number of affected rows
            $rowCount = $stmt->affected_rows;

            if ($rowCount > 0) {
                return 1; // Update successful
            } else {
                return 0; // No rows updated
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, display an error message)
            return $e->getMessage(); // Return the error message
        } finally {
            // Close the database connection
            $stmt->close();
        }
    }
    function disapprovequery()
    {
        // Extract the POST data
        extract($_POST);

        // Use prepared statement to update the user's status
        $stmt = $this->db->prepare("UPDATE queries SET status = 4 WHERE id = ?");
        $stmt->bind_param('s', $id);

        try {
            // Execute the query
            $stmt->execute();

            // Check the number of affected rows
            $rowCount = $stmt->affected_rows;

            if ($rowCount > 0) {
                return 1; // Update successful
            } else {
                return 0; // No rows updated
            }
        } catch (PDOException $e) {
            // Handle the exception (e.g., log the error, display an error message)
            return $e->getMessage(); // Return the error message
        } finally {
            // Close the database connection
            $stmt->close();
        }
    }
}
?>