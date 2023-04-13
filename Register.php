<?php
    require_once "database.php";
    // Initialize the session
    
    // Define variables and initialize with empty values
    $username = $password = $confirm_password = "";
    $username_err = $password_err = $confirm_password_err = "";

    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
        // Validate username
        if(empty(trim($_POST["username"]))){
            $username_err = "Please enter a username.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
            $username_err = "Username can only contain letters, numbers, and underscores.";
        } else{
            $li = Database::connect();
            $sqlCheckUser = "SELECT id FROM doctors WHERE username = ?";
            $stmtCheckPrep = $li->prepare($sqlCheckUser);
            $stmtCheckPrep->bind_param("s", $_POST["username"]);
            $stmtCheckPrep -> execute();
            $result = $stmtCheckPrep->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            print_r($row);
            if($row){
                $username_err = "This username is already taken.";
            } else{
                $username = trim($_POST["username"]);
            }
        } 


     // Validate password
        if(empty(trim($_POST["password"]))){
            $password_err = "Please enter a password.";     
        } elseif(strlen(trim($_POST["password"])) < 6){
            $password_err = "Password must have atleast 6 characters.";
        } else{
            $password = trim($_POST["password"]);
        }
        
        // Validate confirm password
        if(empty(trim($_POST["confirm_password"]))){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password = trim($_POST["confirm_password"]);
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }
        
        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
            // Prepare an insert statement
            $hash_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            $sqlRegisterDoctor = "INSERT INTO doctors (username, password) VALUES (?, ?)";
    
            $sqlRegisterPrep = $li->prepare($sqlRegisterDoctor);
            $sqlRegisterPrep->bind_param("ss", $username, $hash_password);
            $sqlRegisterPrep -> execute();
    
                            
            ?>
                <!DOCTYPE html>
                <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Sign Up</title>
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                        <style>
                            body{ font: 14px sans-serif; }
                            .wrapper{ width: 500px; padding: 20px; margin: 0 auto;  text-align: center;}
                        </style>
                    </head>
                    <body>
                        <div class="wrapper"> 
                            <h3>Registration Successful</h3>
                            <p id="alert alert-info alert-autocloseable-info">Doctor profile created. <br/><br/>
                                <a href='http://prazdnik.kg/ehr'>Click here to login<a>
                            </p>
                        </div>
                    </body>        
                </html>    
            <?php 
        }             
    } else {
?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Sign Up</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
            body{ font: 14px sans-serif; }
            .wrapper{ width: 360px; padding: 20px; margin: 0 auto;}
        </style>
        
        
              <script type="text/javascript">
                  
                  /******** password generator ****/
                  function generatePassword() {
                    var length = 8,
                        charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
                        retVal = "";
                    for (var i = 0, n = charset.length; i < length; ++i) {
                        retVal += charset.charAt(Math.floor(Math.random() * n));
                    }
                
                    document.getElementById('passwordValue').innerHTML = retVal;                
                    document.getElementById("copyPassword").addEventListener("click", copyPassword);
                  
                  }      
                  
                                
                  const copyPassword = () => {
                    let text = document.getElementById("passwordValue").textContent;
                    document.getElementById("passwordConfirmField").value = text;
                    document.getElementById("passwordField").value = text;
    //                navigator.clipboard.writeText(text);
                  };
    
                  const updateView = (targetId, newId, label, element, method = '') => {
                    let newElement = document.createElement(element);
                    newElement.id = newId;
                    let content = document.createTextNode(label + method);
                    newElement.appendChild(content);
    
                    let currentElement = document.getElementById(targetId);
                    let parentElement = currentElement.parentNode;
                    parentElement.replaceChild(newElement, currentElement);
                  }
                  window.onload = generatePassword;
                  /******************END ***/
            </script>
        
        
        
    </head>
    <body>
        <div class="wrapper">
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="passwordField" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" id="passwordConfirmField" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <input type="reset" class="btn btn-secondary ml-2" value="Reset">
                </div>
                
                <div>Recommended password: <span id="passwordValue"></span>&nbsp;
                    <button type="button" class="btn btn-outline-primary me-2" id="copyPassword">Use it</button>
                </div>
                
                <p>Already have an account? <a href="index.php">Login here</a>.</p>
            </form>
        </div>    
    </body>
    </html>
    
<?php } ?>
