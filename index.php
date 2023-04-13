<?php
    session_start();
    error_reporting(E_ALL);
    ini_set('display_errors', 'on');
    require 'EhrManager.php';
    require 'Login.php';
    $isDoctorLoggedIn  = false;
   
    // $createDbTableUsers = EhrManager::createDB();
    if(isset($_GET["form_action"]) || isset($_POST["form_action"])){
        if(isset($_GET["form_action"]) && $_GET["form_action"] == 'save_info') {
            $email = $_GET["email"];
            $lastName = $_GET["lastName"];
            $firstName = $_GET["firstName"]; 
            $gender = $_GET["gender"];
            $date_of_birth = $_GET["date_of_birth"];
            $address = $_GET["address"];
            
            $state = $_GET["state"];
            $weight = $_GET["weight"];
            $height = $_GET["height"];
            $doctor_id = $_GET["doctor_id"];
            $covid_vaccine_received = $_GET["covid_vaccine_received"];
            $first_dose = $_GET["first_dose"];
            $second_dose = $_GET["second_dose"];
            
            if(isset($_GET["hepatit_b_date"])){
                $hepatit_b_date = 1;
            }
            else {
                $hepatit_b_date = 0;
            }
            $abnormalities = $_GET["abnormalities"];
            
            $insertNewUser = EhrManager::addUserToDB($email, $lastName, $firstName, $gender, $date_of_birth, $address, $state, $weight, $height, $doctor_id, $covid_vaccine_received, $first_dose, $second_dose, $hepatit_b_date, $abnormalities);
        }
        elseif(isset($_GET["form_action"]) && $_GET["form_action"] == 'remove_info') {
            $userId = $_GET["userId"];
            $deleteUser = EhrManager::removeEhrFromDB($userId);
        }
        
        elseif(isset($_GET["form_action"]) && $_GET["form_action"] == 'update_info') {
            $userId = $_GET["userId"];
            foreach ($_GET as $param_name=> $val) {
                $params[$param_name]=$val;
            }
            $updateUser = EhrManager::updateEhr($userId, $params);
        }
        
        elseif($_POST["form_action"] == 'doctorLogin') {
            $isDoctorLoggedIn = Login::doctorLogin($_POST["doctorEmail"], $_POST["password"]);   
//            print_r("------------");
//             echo $isDoctorLoggedIn;
        }
    }
    if(isset($_SESSION["loggedin"])) {
        $isDoctorLoggedIn  = $_SESSION["loggedin"];   
    }
    $formSubmitted = false;
//    print_r($_SESSION);
?>


<!DOCTYPE html>
<html lang="en" xml:lang="en">
    <head>
        <title>Kids EHR - medical information system for kindergartens</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <!-- Bootstrap: CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">  
  
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script>
			$(document).ready(function(){
				var date_input=$('input[name="date"]'); //our date input has the name "date"
				var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
				date_input.datepicker({
					format: 'mm/dd/yyyy',
					container: container,
					todayHighlight: true,
					autoclose: true,
				})
			})
		</script>
		<!-- Include jQuery -->
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

		<!-- Include Date Range Picker -->
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

        <link rel="icon" href="img/favicon.ico" type="image/x-icon"></link>
        <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon"></link>
        <link rel="icon" href="img/favicon-32x32.png" sizes="32x32" />
    
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

        <script type="text/javascript">
                function create_ehr_focus () {
                  document.getElementById("patient_name").focus();
                }

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
                navigator.clipboard.writeText(text);
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
        <div id="main_header_footer" style="padding: 20px;">
            <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
                <symbol id="bootstrap" viewBox="0 0 118 94">
                  <title>Bootstrap</title>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"></path>
                </symbol>
                <symbol id="home" viewBox="0 0 16 16">
                  <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z"/>
                </symbol>
                <symbol id="speedometer2" viewBox="0 0 16 16">
                  <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z"/>
                  <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z"/>
                </symbol>
                <symbol id="table" viewBox="0 0 16 16">
                  <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z"/>
                </symbol>
                <symbol id="people-circle" viewBox="0 0 16 16">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                </symbol>
                <symbol id="grid" viewBox="0 0 16 16">
                  <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z"/>
                </symbol>
            </svg>  
            <main>
                <h1 class="visually-hidden">Headers examples</h1>
                <div class="header_container">
                  <header class="d-flex flex-wrap align-items-center justify-content-center py-3 mb-4 border-bottom">
                    <a href="http://prazdnik.kg/ehr/index.php" class="">
                      <img src="img/logo.png" alt="Logo EHR">
                    </a>
    
                    <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0" id="top_menu">
                        <li><a href="#about_ehr_block" class="nav-link px-2">About Kids EHR</a></li>
                        <li><a href="http://prazdnik.kg/ehr/Register.php" class="nav-link px-2">Registration</a></li>
                        <li><a href="#Contact" class="nav-link px-2">Contact</a></li>
                        <?php if($isDoctorLoggedIn) { ?>
                            <li><a href="#MyEhr" class="nav-link px-2">My Patients</a></li>
                        <?php } ?>
                    </ul>
                  </header>
                </div>  <!-- END  header_container-->      
                <div class="b-example-divider"></div>
   
                <!-- LOGIN FORM --> 
                <?php if(!$isDoctorLoggedIn) { ?>
                    <div id="Login" class="card">

                        <div class="block_header"><b>Doctor Login / Registration</b></div>
                        <div id="Login_form">
                            <form id="signin" class="navbar-form navbar-left" role="form"  method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
                                <div class="input-group" style="float:left;  width: 200px;">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                    <input id="email" type="text" class="form-control" name="doctorEmail" value="" placeholder="Username">                                        
                                </div>
                            
                                <div class="input-group" style="float:left; width: 200px;">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                    <input id="password" type="password" class="form-control" name="password" value="" placeholder="Password">                                        
                                </div>
                                  <input type="hidden" id="form_action" name="form_action" value="doctorLogin" />
                                <button type="submit" class="btn btn-primary">Login</button>
                            </form>

                        <!--- END of Login-->

                          <a href="Register.php" style="margin: 0 20px 0 0;" class="btn btn-primary navbar-right" style="width: 80px">Sign-up</a>
                          <a class="navbar-right" style="margin: 7px 20px 0 0;" href="#">Forgot your password?</a>
                        </div>
                    </div> 
                <?php } ?>
          

                <?php if($isDoctorLoggedIn) { ?> 
                    <div id="main_content">
                        <p>Welcome, <?php echo $_SESSION["username"] ?>&nbsp;&nbsp;<a class="" href="logout.php">Sign out</a></p>
                        <div id="MyEhr">
                          <div class="block_header"><b>My EHRs</b></div>
                        </div>
                        <div id="ehr_table">        
                            <table class="table caption-top" id="customers">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Patient Name, Surname, <br>Email, Address</th>
                                    <th scope="col" width="16%">Date of Birth, Gender, <br>Weight, Height</th>
                                    <th scope="col" width="17%">Covid vaccine received</th>
                                    <th scope="col" width="17%">Hepatit vaccine received</th>
                                    <th scope="col">Abnormalities</th>
                                    <th scope="col">Actions</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if($_SESSION["id"]) {
                                        $ehrRecords = EhrManager::getAllEhrs($_SESSION["id"]);
                                    if(!empty($ehrRecords)) {
                                        foreach($ehrRecords as $record){
                                    ?>
                                          <tr>
                                            <form action="" method="get" id="editEhrForm">
                                                <input type="hidden" id="form_action" name="form_action" value="update_info"/> 
                                                <td scope="row"><input type="checkbox"> <?php echo $record['userId'] ?></td><input type="hidden" id="userId" name="userId" value="<?php echo $record['userId'] ?>"/> 
                                                <td>
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>">First Name: <b><?php echo $record['firstName'] ?></b></p><p class="ehrInputs" id="firstName_<?php echo $record['userId'] ?>"><input type="text" value="<?php echo $record['firstName'] ?>" class="inputString" name="firstName" /></p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>">Last Name: <b><?php echo $record['lastName'] ?></b></p><p class="ehrInputs" id="lastName_<?php echo $record['userId'] ?>"><input type="text" value="<?php echo $record['lastName'] ?>" class="inputString" name="lastName" /></p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><a href=""><?php echo $record['email'] ?></a></p><p class="ehrInputs" id="email_<?php echo $record['userId'] ?>"><input type="email" value="<?php echo $record['email'] ?>" class="inputString" name="email" /></p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['address'] ?></p><p class="ehrInputs" id="address_<?php echo $record['userId'] ?>"><input type="text" value="<?php echo $record['address'] ?>" class="inputString" name="address" /></p><br />
                                                
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['state'] ?></p>
                                                    <p class="ehrInputs" id="state_<?php echo $record['userId'] ?>">
                                                        <select class="searchList " name="state" >
                                                            <option value="">Select State</option>
                                                            <option value='Baden-Wurttemberg' >Baden-Wurttemberg</option>
                                                            <option value='Bayern' >Bayern</option>
                                                            <option value='Berlin' >Berlin</option>
                                                            <option value='Brandenburg' >Brandenburg</option>
                                                            <option value='Bremen' >Bremen</option>
                                                            <option value='Hamburg' >Hamburg</option>
                                                            <option value='Hessen' >Hessen</option>
                                                            <option value='Lower Saxony' >Lower Saxony</option>
                                                            <option value='Mecklenburg-Western Pomerania' >Mecklenburg-Western Pomerania</option>
                                                            <option value='North Rhine-Westphalia' >North Rhine-Westphalia</option>
                                                            <option value='Rhineland-Palatinate' >Rhineland-Palatinate</option>
                                                            <option value='Saarland' >Saarland</option>
                                                            <option value='Saxony' >Saxony</option>
                                                            <option value='Saxony-Anhalt' >Saxony-Anhalt</option>
                                                            <option value='Schleswig-Holstein'  >Schleswig-Holstein</option>
                                                            <option value='Thuringia'  >Thuringia</option>
                                                            <option value='No State-Outside of Germany'>No State-Outside of Germany</option>
                                                        </select><br />
                                                    </p><br />
                                                </td>
                                                <td>
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['date_of_birth'] ?></p><p class="ehrInputs" id="date_of_birth_<?php echo $record['userId'] ?>"><input type="date" value="<?php echo $record['date_of_birth'] ?>" class="inputString" name="date_of_birth" /></p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['gender'] ?></p>
                                                    <p class="ehrInputs" id="gender_<?php echo $record['userId'] ?>">
                                                        <input type="radio" class="searchList " name="gender" value="male"><label for="male">Male</label> <br />
                                                        <input type="radio" class="searchList " name="gender" value="female"><label for="female">Female</label><br />
                                                    </p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['weight'] ?></p><p class="ehrInputs" id="weight_<?php echo $record['userId'] ?>"><input type="text" value="<?php echo $record['weight'] ?>" class="inputString" name="weight" /></p><br />                                
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['height'] ?></p><p class="ehrInputs" id="height_<?php echo $record['userId'] ?>"><input type="text" value="<?php echo $record['height'] ?>" class="inputString" name="height" /></p><br />
                                                </td>
                                                <!-- EHR fields -->                                                                                
                                                <td>
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['covid_vaccine_received'] ?></p>
                                                    <p class="ehrInputs" id="covid_vaccine_received_<?php echo $record['userId'] ?>">
                                                        <input type="radio" class="inputString " name="covid_vaccine_received" value="Pfizer"><label for="male">Pfizer</label> <br />
                                                        <input type="radio" class="inputString " name="covid_vaccine_received" value="Moderna"><label for="female">Moderna</label><br />
                                                    </p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['first_dose'] ?></p><p class="ehrInputs" id="first_dose_<?php echo $record['userId'] ?>"><input type="date" value="<?php echo $record['first_dose'] ?>" class="inputString" name="first_dose" /></p><br />
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['second_dose'] ?></p><p class="ehrInputs" id="second_dose_<?php echo $record['userId'] ?>"><input type="date" value="<?php echo $record['second_dose'] ?>" class="inputString" name="second_dose" /></p><br />
                                                </td>
                                                <td>
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php if ($record['hepatit_b_date']==1){echo "Yes";} else{echo "No";} ?></p><p class="ehrInputs" id="hepatit_b_date_<?php echo $record['userId'] ?>"><input type="checkbox" value="1" class="inputString" name="hepatit_b_date" <?php if ($record['hepatit_b_date']==1){ ?>checked<?php }  ?> /></p><br />
                                                </td>
                                                <td>
                                                    <p class="ehrValues ehrValue_<?php echo $record['userId'] ?>"><?php echo $record['abnormalities'] ?></p><p class="ehrInputs" id="abnormalities_<?php echo $record['userId'] ?>"><textarea rows="40" cols="50" name="abnormalities" form="editEhrForm" class="inputString" ><?php echo $record['abnormalities'] ?></textarea></p><br />
                                                </td>

                                                <!-- ACTIONS -->
                                                <td>
                                                  <a onclick="editEhr(<?php echo $record['userId'] ?>);" href="#" title="Edit"><img src="" border="0" alt=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                                  </svg></a>
                                                  <a href="/ehr/index.php?form_action=remove_info&userId=<?php echo $record['userId'] ?>" title="Delete"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                  </svg></a>
                                                  <p class="ehrInputs" id="actions_<?php echo $record['userId'] ?>"><input type="submit" value="Update" /><input type="button" name="button" value="Cancel" onclick="hideallEhrInputs();"></p>
                                                </td>
                                            </form>
                                          </tr>
                                    <?php
                                        }
                                    }
                                    }
                                    ?>
                                </tbody>
                              </table>
                              <script type="text/javascript">          
                                 /******************EDIT EHR form ***/
                                function editEhr(userSid) {
                                    hideallEhrInputs();
                                    document.getElementById("firstName_"+userSid).style.display = "block";
                                    document.getElementById("lastName_"+userSid).style.display = "block";
                                    document.getElementById("email_"+userSid).style.display = "block";
                                    document.getElementById("gender_"+userSid).style.display = "block";
                                    document.getElementById("date_of_birth_"+userSid).style.display = "block";
                                    document.getElementById("address_"+userSid).style.display = "block";
                                    document.getElementById("state_"+userSid).style.display = "block";
                                    
                                    document.getElementById("weight_"+userSid).style.display = "block";
                                    document.getElementById("height_"+userSid).style.display = "block";                                    
                                    document.getElementById("covid_vaccine_received_"+userSid).style.display = "block";
                                    document.getElementById("first_dose_"+userSid).style.display = "block";
                                    document.getElementById("second_dose_"+userSid).style.display = "block";
                                    document.getElementById("hepatit_b_date_"+userSid).style.display = "block";
                                    document.getElementById("abnormalities_"+userSid).style.display = "block";
                                    document.getElementById("actions_"+userSid).style.display = "block";
                                    
                                    var elems = document.getElementsByClassName("ehrValue_"+userSid)
                                    for (var i=0;i<elems.length;i+=1){
                                      elems[i].style.display = 'none';
                                    }

                                }
                                
                                function hideallEhrInputs() {
                                    var allEhrRows = document.getElementsByClassName("ehrInputs");
                                    var i;
                                    for (i = 0; i < allEhrRows.length; i++) {
                                        allEhrRows[i].style.display = "none";
                                    }
                                    
                                    var elems = document.getElementsByClassName("ehrValues")
                                    for (var i=0;i<elems.length;i+=1){
                                      elems[i].style.display = 'block';
                                    }

                                    
                                }
                                window.onload = hideallEhrInputs();
                                 /******************END ***/
                                </script>
                        </div> <!-- END  ehr_table -->  
                        <div class="b-example-divider"><br /><br /></div>

                        <!-- ADD EHR form -->
                        <div id="Registration">
                    		<div class="container register-form top-buffer-1">
                    		  <div class="form">
                    			  <div class="note">
                    				<p>Add a new EHR</p>
                    			  </div>
                    		 <div class="form-content bk">
                    				<form action="" method="get" id="addEhrForm">
                                        <input type="hidden" id="form_action" name="form_action" value="save_info"/>
                    					<fieldset class="scheduler-border">
                    						<legend class="scheduler-border">Personal Information</legend>
                    						<div class="row">
                    							<div class="col-SM-2">
                    							  <label for="lname">Last Name</label>
                    							  <input type="name" class="form-control" id="fmane" placeholder="Manohar" name="lastName">
                    							</div>
                    							<div class="col-SM-5">
                    							  <label for="fname">First Name</label>
                    							  <input type="name" class="form-control" id="fmane" placeholder="Manohar" name="firstName">
                    							</div>
                    
                    						</div>
                    						<div class="section-to-print" id="section-to-print">
                    						<div class="row top-buffer">
                    							<div class="col-sm-3">
                    							  <label for="email">Email</label>
                    							  <input type="email" class="form-control" id="email" placeholder="xyz@xyz.com" name="email">
                    							</div>
                    							<div class="col-sm-3">
                    							  <label for="dob">Date of Birth</label>
                    							  <input name="date_of_birth" class="form-control" id="dob" type="date" />
                    							</div>
                    							<div class="col-sm-2">
                    							  <label for="phone">Phone Number</label>
                    							  <input name="phone" class="form-control" id="phone" type="phone" />
                    							</div>
                    							<div class="col-sm-4">
                    							  <label for="phone">Gender</label></br>
                    								<div class="radio-inline"><label><input type="radio" name="gender" value="male" checked>Male</label></div>
                    								<div class="radio-inline"><label><input type="radio" name="gender" value="female">Female</label></div>
                    							</div>
                    						</div>
                    						<div class="row top-buffer">
                    							<!-- Address -->
                    							  <div class="form-group col-sm-3">
                    								<label for="inputAddress">Address</label>
                    								<input type="text" class="form-control" id="inputAddress" name="address" placeholder="1234 Main St">
                    							  </div>
                    							  <div class="form-row">
                    								<div class="form-group col-sm-2">
                    								  <label for="inputCity">City</label>
                    								  <input type="text" class="form-control" name="city" id="inputCity">
                    								</div>
                    								<div class="form-group col-sm-2">
                    								  <label for="inputState">State</label>
                    								  <select id="inputState" class="form-control" name="state">
                    									<option selected>Choose...</option>
                                                        <option value='Baden-Wurttemberg' >Baden-Wurttemberg</option>
                                                        <option value='Bayern' >Bayern</option>
                                                        <option value='Berlin' >Berlin</option>
                                                        <option value='Brandenburg' >Brandenburg</option>
                                                        <option value='Bremen' >Bremen</option>
                                                        <option value='Hamburg' >Hamburg</option>
                                                        <option value='Hessen' >Hessen</option>
                                                        <option value='Lower Saxony' >Lower Saxony</option>
                                                        <option value='Mecklenburg-Western Pomerania' >Mecklenburg-Western Pomerania</option>
                                                        <option value='North Rhine-Westphalia' >North Rhine-Westphalia</option>
                                                        <option value='Rhineland-Palatinate' >Rhineland-Palatinate</option>
                                                        <option value='Saarland' >Saarland</option>
                                                        <option value='Saxony' >Saxony</option>
                                                        <option value='Saxony-Anhalt' >Saxony-Anhalt</option>
                                                        <option value='Schleswig-Holstein'  >Schleswig-Holstein</option>
                                                        <option value='Thuringia'  >Thuringia</option>
                                                        <option value='No State-Outside of Germany'>No State-Outside of Germany</option>
                    								  </select>
                    								</div>
                    								<div class="form-group col-md-2">
                    								  <label for="inputZip">Zip</label>
                    								  <input type="text" class="form-control" name="zip" id="inputZip">
                    								</div>
                    							  </div>
                    							  <!-- Address -->
                    							</div>
                    						</div>
                    					</fieldset>
                    
                    					<!-- Test Prep -->
                    					<fieldset class="scheduler-border">
                    						<legend class="scheduler-border">Patient Notes</legend>
                    						
                    						<div class="row top-buffer">
                    							<div class="col-sm-5">
                    							  <label for="weight">Weight</label>
                    							  <input type="text" class="form-control" id="weight" placeholder="kg" name="weight">
                    							</div>
                    							<div class="col-sm-5">
                    							  <label for="height">Height</label>
                    							  <input type="text" class="form-control" id="height" placeholder="cm" name="height">
                    							</div>
                    						</div>
                    						<br />
                    						<div class="row top-buffer">
                    							<div class="col-sm-4">
                    							    <label for="phone">Covid vaccine received</label>
                        						    <select id="inputState" class="form-control" name="covid_vaccine_received">
                        								<option selected>None</option>
                                                        <option value='Pfizer' >Pfizer</option>
                                                        <option value='Moderna' >Moderna</option>
                                                        <option value='Sputnik-V' >Sputnik-V</option>
                                                    </select>
                    
                    							</div>
                    							<div class="col-sm-3">
                    						        <label for="first_dose">First dose</label></br>
                    							    <input name="first_dose" class="form-control inputString" id="first_dose" type="date" />
                    							</div>
                    							<div class="col-sm-3">
                                                    <label for="second_dose">Second dose</label></br>
                    							    <input name="second_dose" class="form-control inputString" id="second_dose" type="date" />
                    							</div>
                    						</div>
                    						<br />
                    						<div class="row">
                    							<div class="col-sm-4">
                    							  <label for="phone">Hepatit vaccination date</label>
                    							  <input name="hepatit_b_date" class="" id="hepatit_b_date" type="checkbox" value="1" />
                    							</div>
                    							<div class="col-sm-3">
                    						        <label for="first_dose">Abnormalities</label></br>
                    							    <textarea rows="4" cols="50" name="abnormalities" form="addEhrForm" class="inputString" >Enter description here...</textarea>
                    							</div>
                    						</div>
                    						<input  type="hidden" value="<?php echo $_SESSION["id"] ?>" class="inputString" name="doctor_id" />
                    						                                 
                    					</fieldset>
                    					<!-- Study Abroad Plans -->
                    					<button type="submit" class="btn btn-success" value="submit">Add EHR </button>
                    				</form>
                    			</div>
                    		  </div>
                    		  </div>
                        </div> <!--- END of ADD EHR block-->
                    </div> <!-- END of Main_content -->
                <?php } ?>
            
                <div class="b-example-divider"><br /><br /></div>
                    <div id="about_ehr" class="justify-content-center mb-md-0">
                        <div class="how-section1">
                            <div class="row">
                                <div class="col-md-6 how-img">
                                    <img src="img/features_pict.jpg" style="width: 80%;" class="img-fluid" alt=""/>
                                </div>
                                <div id="about_ehr_block" class="col-md-6">
                                    <h4>ABOUT EHR</h4>
                                    <h4 class="subheading">An electronic health record (EHR) is a digital version of a patient's paper chart.</h4>
                                    <p class="text-muted">EHRs are real-time, patient-centered records that make information available instantly and securely to authorized users. 
                                    While an EHR does contain the medical and treatment histories of patients, an EHR system is built to go beyond standard clinical data collected in a provider's office and can be inclusive of a broader view of a patient's care. 
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" id="opportunities_block" >
                                    <h4>Opportunities</h4>
                                    <h4 class="subheading">EHRs are a vital part of health IT and can:</h4>
                                    <p class="text-muted">
                                        <ul>
                                            <li class="text-muted">Contain a patient's medical history, diagnoses, medications, treatment plans, immunization dates, allergies, radiology images, and laboratory and test results</li>
                                            <li class="text-muted">Allow access to evidence-based tools that providers can use to make decisions about a patient's care</li>
                                            <li class="text-muted">Automate and streamline provider workflow</li>
                                        </ul>
                                    </p>
                                </div>
                                <div class="col-md-6 how-img">
                                    <img src="img/about_pict.png" style="width: 60%;" class="rounded-circle img-fluid" alt=""/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 how-img">
                                     <img src="img/opportunities_pict.png" style="width: 80%;" class="rounded-circle img-fluid" alt=""/>
                                </div>
                                <div class="col-md-6">
                                    <h4>Key features</h4>
                                                <h4 class="subheading">With Kids EHR, you have the freedom and flexibility to control when, where, and how...</h4>
                                                <p class="text-muted">One of the key features of an EHR is that health information can be created and managed by authorized providers in a digital format capable of being shared with other providers across more than one health care organization.
                                        EHRs are built to share information with other health care providers and organizations - such as laboratories, specialists, medical imaging facilities, pharmacies, emergency facilities, and school and workplace clinics - 
                                        so they contain information from all clinicians involved in a patient's care.</p>
                                </div>
                            </div>
                            
                            
                               <div class="row">
                                <div class="col-md-6" id="opportunities_block" >
                                    <h4>SUS score = 87.5</h4>
                                    <h4 class="subheading">Kinder EHR UI evaluation using SUS score method:</h4>
                                    <p class="text-muted">
                                        <ul>
                                            <li class="text-muted">Survey-based evaluation by system users </li>
                                        
                                            <li class="text-muted">Learn more about the SUS score methodology <a href="https://measuringu.com/sus/">here</a></li>
                                        </ul>
                                    </p>
                                </div>
                                <div class="col-md-6 how-img">
                                    <img src="img/sus_pict.png" class="rounded-circle img-fluid" alt="" style="width: 70%;" />
                                </div>
                            </div>
                            
                            
                            <div class="row">
                                <div class="col-md-6 how-img">
                                    <img src="img/ressources_pict.jpg" class="rounded-circle img-fluid" alt="" style="width: 70%;" />
                                </div>
                                <div class="col-md-6">
                                    <h4 class="subheading">For more information on EHR systems, see the following resources:</h4>
                                    <p class="text-muted">
                                        <ul>
                                            <li class="text-muted"><a href="https://www.healthit.gov/providers-professionals/benefits-electronic-health-records-ehrs">Benefits of Electronic Health Records</a></li>
                                            <li class="text-muted"><a href="https://www.healthit.gov/faq/what-are-advantages-electronic-health-records">What are the advantages of electronic health records?</a></li>
                                            <li class="text-muted"><a href="https://www.healthit.gov/faq/what-information-does-electronic-health-record-ehr-contain">What information does an electronic health record (EHR) contain?</a></li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div id="Contact" class="col-md-9">
                                    <h4>Contacts</h4>
                                    <h4 class="subheading">Faculty of European Campus Rottal-Inn - Health Informatics</h4>
                                    <p class="text-muted"> Eldar Gaifullin <br>                  
                                      Email: <a href="mailto:eldargaifullin@gmail.com">eldargaifullin@gmail.com</p>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div> 
                    <div class="b-example-divider"><br /><br /></div>
   
            </main>
            <div class="b-example-divider"></div>
            <div id="footer">HI-B-3: Information Systems in Health Care (WS21/22)</div>
        </div><!-- END main_header_footer -->      
 
    </body> 
</html>

