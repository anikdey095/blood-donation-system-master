<?php
session_start();
include('header/header.php');
include('header/connection.php');
if(isset($_SESSION['loggedin'])==true){
    include('header/navadmin.php');
}
else {
    include('header/navuser.php');
}
?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration | Blood Donation System</title>
    <link rel="icon" href="icon/reg.png" />
    <style type="text/css">
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        
        h1 {
            text-align: center;
            color: #e74c3c;
            margin-bottom: 30px;
            font-size: 2.5rem;
        }
        
        .registration-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            width: 80%;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        
        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #e74c3c;
            outline: none;
            box-shadow: 0 0 5px rgba(231, 76, 60, 0.3);
        }
        
        select.form-control {
            height: 45px;
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        .radio-group {
            display: flex;
            gap: 15px;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn {
            padding: 12px 25px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-weight: bold;
        }
        
        .btn-submit {
            background-color: #e74c3c;
            color: white;
        }
        
        .btn-submit:hover {
            background-color: #c0392b;
        }
        
        .btn-reset {
            background-color: #95a5a6;
            color: white;
            margin-left: 10px;
        }
        
        .btn-reset:hover {
            background-color: #7f8c8d;
        }
        
        .button-group {
            text-align: center;
            margin-top: 30px;
        }
        
        .success-message {
            color: #27ae60;
            text-align: center;
            font-weight: bold;
            margin-top: 20px;
            padding: 15px;
            background-color: rgba(39, 174, 96, 0.1);
            border-radius: 5px;
        }
        
        @media (max-width: 768px) {
            .registration-form {
                width: 100%;
                padding: 20px;
            }
            
            .radio-group {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Patient Registration</h1>
    
    <div class="registration-form">
        <form method="post">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Full Name" autofocus required />
            </div>
            
            <div class="form-group">
                <label for="bgroup">Blood Group:</label>
                <select id="bgroup" name="bgroup" class="form-control" required>
                    <option value="">Select Blood Group</option>
                    <option>A+</option>
                    <option>A-</option>
                    <option>B+</option>
                    <option>B-</option>
                    <option>AB+</option>
                    <option>AB-</option>
                    <option>O+</option>
                    <option>O-</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Gender:</label>
                <div class="radio-group">
                    <div class="radio-option">
                        <input type="radio" id="male" name="gender" value="Male" required />
                        <label for="male">Male</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="female" name="gender" value="Female" />
                        <label for="female">Female</label>
                    </div>
                    <div class="radio-option">
                        <input type="radio" id="others" name="gender" value="Others" />
                        <label for="others">Others</label>
                    </div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" class="form-control" min="1" max="120" required />
            </div>
            
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="number" class="form-control" placeholder="+8801********" required />
            </div>
            
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" class="form-control" placeholder="Please include your Division & City" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="hospital">Hospital Name:</label>
                <input type="text" id="hospital" name="hospital" class="form-control" placeholder="Enter hospital name" required />
            </div>
            
            <div class="form-group">
                <label for="reason">Reason for Blood Need:</label>
                <textarea id="reason" name="reason" class="form-control" placeholder="Please describe why you need blood (e.g., surgery, treatment, etc.)" required></textarea>
            </div>
            
            <div class="button-group">
                <input type="submit" name="sub" value="Submit" class="btn btn-submit" />
                <input type="reset" value="Reset" class="btn btn-reset" />
            </div>
        </form>
        
        <?php
        if(isset($_POST['sub'])){
            // Input validation
            $required_fields = ['name', 'bgroup', 'gender', 'age', 'number', 'address', 'hospital', 'reason'];
            foreach ($required_fields as $field) {
                if (empty($_POST[$field])) {
                    die("<script>alert('Please fill all required fields')</script>");
                }
            }

            $id = uniqid();
            $name = $_POST['name'];
            $bgroup = $_POST['bgroup'];
            $gender = $_POST['gender'];
            $age = $_POST['age'];
            $number = $_POST['number'];
            $address = $_POST['address'];
            $hospital = $_POST['hospital'];
            $reason = $_POST['reason'];

            try {
                $q = $db->prepare("INSERT INTO patient(id, name, bgroup, gender, age, number, address, hospital, reason) 
                                  VALUES (:id, :name, :bgroup, :gender, :age, :number, :address, :hospital, :reason)");

                $q->bindParam(':id', $id);
                $q->bindParam(':name', $name);
                $q->bindParam(':bgroup', $bgroup);
                $q->bindParam(':gender', $gender);
                $q->bindParam(':age', $age);
                $q->bindParam(':number', $number);
                $q->bindParam(':address', $address);
                $q->bindParam(':hospital', $hospital);
                $q->bindParam(':reason', $reason);

                if($q->execute()){
                    echo '<div class="success-message">Registration Successful! We will contact you soon.</div>';
                    // Clear form after successful submission
                    echo '<script>document.querySelector("form").reset();</script>';
                } else {
                    $error = $q->errorInfo();
                    throw new PDOException($error[2]);
                }
            } catch (PDOException $e) {
                error_log("Database Error: " . $e->getMessage());
                echo "<script>alert('Registration Failed: " . addslashes($e->getMessage()) . "')</script>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>