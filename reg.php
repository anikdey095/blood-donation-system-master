<?php
session_start();
include('header/header.php');
include('header/connection.php');

// Check if user is logged in to show appropriate navigation
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    include('header/navadmin.php');
} else {
    include('header/navuser.php');
}

// Process form submission
if (isset($_POST['sub'])) {
    try {
        // Validate and sanitize inputs
        $id = uniqid();
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $bgroup = filter_input(INPUT_POST, 'bgroup', FILTER_SANITIZE_STRING);
        $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_STRING);
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 18]
        ]);
        $weight = filter_input(INPUT_POST, 'weight', FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 40]
        ]);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $number = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_STRING);
        $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);

        // Validate all required fields
        if (!$name || !$bgroup || !$gender || !$age || !$weight || !$date || !$number || !$address) {
            throw new Exception("Please fill all required fields correctly");
        }

        // Insert into database
        $q = $db->prepare("INSERT INTO donor(id, name, bgroup, gender, age, weight, date, number, address) 
                          VALUES (:id, :name, :bgroup, :gender, :age, :weight, :date, :number, :address)");
        
        $q->execute([
            ':id' => $id,
            ':name' => $name,
            ':bgroup' => $bgroup,
            ':gender' => $gender,
            ':age' => $age,
            ':weight' => $weight,
            ':date' => $date,
            ':number' => $number,
            ':address' => $address
        ]);

        $success = "Registration Successful!";
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donor Registration | Blood Donation System</title>
    <link rel="icon" href="icon/reg.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #e74c3c;
            --secondary-color: #c0392b;
            --light-color: #f5f5f5;
            --dark-color: #333;
            --success-color: #27ae60;
            --info-color: #3498db;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: var(--primary-color);
            text-align: center;
            margin-bottom: 2rem;
            font-size: 2.2rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
            transition: border 0.3s;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(231, 76, 60, 0.2);
        }
        
        .radio-group {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .radio-option {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-align: center;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .alert {
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
                margin: 1rem;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-plus"></i> Donor Registration</h1>
        
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your full name" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="bgroup" class="form-label">Blood Group</label>
                <select id="bgroup" name="bgroup" class="form-control" required>
                    <option value="">Select Blood Group</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Gender</label>
                <div class="radio-group">
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Male" required> Male
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Female"> Female
                    </label>
                    <label class="radio-option">
                        <input type="radio" name="gender" value="Others"> Others
                    </label>
                </div>
            </div>
            
            <div class="form-group">
                <label for="age" class="form-label">Age</label>
                <input type="number" id="age" name="age" class="form-control" min="18" required>
            </div>
            
            <div class="form-group">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" id="weight" name="weight" class="form-control" min="40" required>
            </div>
            
            <div class="form-group">
                <label for="date" class="form-label">Last Donation Date</label>
                <input type="date" id="date" name="date" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="number" class="form-label">Phone Number</label>
                <input type="tel" id="number" name="number" class="form-control" placeholder="+8801XXXXXXXXX" required>
            </div>
            
            <div class="form-group">
                <label for="address" class="form-label">Address</label>
                <textarea id="address" name="address" class="form-control" rows="3" placeholder="Please include your Division & City" required></textarea>
            </div>
            
            <div class="form-group" style="text-align: center;">
                <button type="submit" name="sub" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i> Register
                </button>
            </div>
        </form>
    </div>

    <script>
        // Set default date to today
        document.getElementById('date').valueAsDate = new Date();
        
        // Phone number validation
        document.getElementById('number').addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });
    </script>
</body>
</html>