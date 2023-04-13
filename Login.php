<?php
    require_once "database.php";
    // Initialize the session


class Login {

    public static function doctorLogin($userEmail, $password) {
        // Check if the user is already logged in, if yes then redirect him to welcome page
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        }

        // Define variables and initialize with empty values
    //    $username = $password = "";
      //  $username_err = $password_err = $login_err = "";
     
        // Check if username is empty
        if(empty(trim($userEmail))){
            $username_err = "Please enter email.";
        } 
        
        // Check if password is empty
        if(empty(trim($password))){
            $password_err = "Please enter your password.";
        } 
            
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            // Prepare a select statement
            $li = Database::connect();
            $sqlLoginQuery = "SELECT id, username, password FROM doctors WHERE username = ?";
            $stmtLoginDoctor = $li->prepare($sqlLoginQuery);
            $stmtLoginDoctor->bind_param("s", $userEmail);
            $stmtLoginDoctor -> execute();
            
            $result = $stmtLoginDoctor->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $hash = $row['password'];
            
            if (password_verify($password, $hash)) {
                // Password is correct, store data in session variables
                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $row['id'];
                $_SESSION["username"] = $userEmail;                            
                return true;

            } else {
                echo 'Invalid password.';
                return false;
            }
        }
    } // end of DoctorLogin function
}
?>