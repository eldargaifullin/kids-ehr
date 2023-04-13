<?php
require 'database.php';

class EhrManager 
{
    
	public static function createDB()
	{
        $pdo = Database::connect();
        $sqlcreate = "CREATE TABLE users (userId Int(10) PRIMARY KEY, email Varchar(50), lastName Varchar(50), firstName Varchar(50), gender Varchar(10), date_of_birth DATE, address Varchar(50))";
        $query = mysqli_query($pdo, $sqlcreate);
        return $query;
	}
	
	public static function updateEhr($userId, $params)
	{
	    $li = Database::connect();
	    foreach ($params as $param => $val) {
	        if (!empty($val))
	            switch ($param) {
            	    case "email":
            	        $sqlupdate = "UPDATE users SET  email=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
            	    case "lastName":
                        $sqlupdate = "UPDATE users SET lastName=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "firstName":
                        $sqlupdate = "UPDATE users SET firstName=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "gender":
                        $sqlupdate = "UPDATE users SET gender=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "date_of_birth":
                        $sqlupdate = "UPDATE users SET date_of_birth=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "address":
                        $sqlupdate = "UPDATE users SET address=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                        
                    case "state":
                        $sqlupdate = "UPDATE users SET state=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                        
                    case "weight":
                        $sqlupdate = "UPDATE users SET weight=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                        
                    case "height":
                        $sqlupdate = "UPDATE users SET height=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;                        
                        
                    case "doctor_id":
                        $sqlupdate = "UPDATE users SET doctor_id=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                        
                    case "covid_vaccine_received":
                        $sqlupdate = "UPDATE users SET covid_vaccine_received=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "first_dose":
                        $sqlupdate = "UPDATE users SET first_dose=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "second_dose":
                        $sqlupdate = "UPDATE users SET second_dose=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                    case "hepatit_b_date":
                        $sqlupdate = "UPDATE users SET hepatit_b_date=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;
                        
                    case "abnormalities":
                        $sqlupdate = "UPDATE users SET abnormalities=? WHERE userId=?";
                        $stmtupdateuser = $li->prepare($sqlupdate);
                        $stmtupdateuser->bind_param("si", $val, $userId);
                        $stmtupdateuser -> execute();
                        break;  
	            }
	    }            	        
	}
	
    /**************************************
     * Function removeEhrFromDB erases a selected EHR record  
     * ***********************************/
    public static function removeEhrFromDB($userId)
	{
        $li = Database::connect();
        $sqldelete = "DELETE FROM users WHERE userId='".$userId."'";
        $query = mysqli_query($li, $sqldelete);
	}

    /**************************************
     * Function removeMultipleEhrsFromDB erases multiple EHR records checked in the main page  
     * ***********************************/
    public static function removeMultipleEhrsFromDB($userIds)
	{
	    $li = Database::connect();
        foreach ($userIds as $userIdDel) {
            $sqldelete = "DELETE FROM users WHERE userId='".$userIdDel."'";
            $query = mysqli_query($li, $sqldelete);
        }
	}


    /********************
     * Function getAllEhrs returns all the EHR records related to the doctor account  
     * ********************/
    public static function getAllEhrs($doctor_id)
	{
		$li = Database::connect();
        $queryEhrs = "SELECT * FROM users WHERE doctor_id='".$doctor_id."'";
        $query = mysqli_query($li, $queryEhrs);

        $i=0;
        while ($data = mysqli_fetch_assoc($query))
        {
            $result[$i] = $data;
            $i++;
        }
        if(!empty($result)) {
	    	return $result;
        }
	}

    public static function addUserToDB($email, $lastName, $firstName, $gender, $date_of_birth, $address, $state, $weight, $height, $doctor_id, $covid_vaccine_received, $first_dose, $second_dose, $hepatit_b_date, $abnormalities)
	{
        $pdo = Database::connect();
        $sqlinsert = "INSERT users (email, lastName, firstName, gender, date_of_birth, address, state, weight, height, doctor_id, covid_vaccine_received, first_dose, second_dose, hepatit_b_date, abnormalities) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmtinsertuser = $pdo->prepare($sqlinsert);
        $stmtinsertuser->bind_param("sssssssssssssss", $email, $lastName, $firstName, $gender, $date_of_birth, $address, $state, $weight, $height, $doctor_id, $covid_vaccine_received, $first_dose, $second_dose, $hepatit_b_date, $abnormalities);
        $stmtinsertuser -> execute();
	}



/********* User registration **********


    function login($user)
	{
		return SJB_DB::query('UPDATE `?w` SET `listing_type_sid` = ?n, `user_sid` = ?n, `keywords` = ?s, ' .
							 '`activation_date` = ' . ($listing->getActivationDate() == null ? 'NOW()' : "'{$listing->getActivationDate()}'") . ' WHERE `sid` = ?n',
					'listings', $listing_type_sid, $listing->getUserSID(), $listing->getKeywords(), $listing->getSID());
	}

    function passwordReset($user)
	{
		return SJB_DB::query('UPDATE `?w` SET `listing_type_sid` = ?n, `user_sid` = ?n, `keywords` = ?s, ' .
							 '`activation_date` = ' . ($listing->getActivationDate() == null ? 'NOW()' : "'{$listing->getActivationDate()}'") . ' WHERE `sid` = ?n',
					'listings', $listing_type_sid, $listing->getUserSID(), $listing->getKeywords(), $listing->getSID());
	}

/********************/
}

