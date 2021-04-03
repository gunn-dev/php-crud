<?php
require_once 'config.php';
$name = $address = $salary = '';
$name_err = $address_err = $salary_err = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$input_name = trim($_POST['name']);
	$input_address = trim($_POST['address']);
	$input_salary = trim($_POST['salary']);

	if (empty($input_name)) {
		$name_err = 'Please enter a name';
	} elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP,
		array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
		$name_err = 'Please enter a valid name.';
	} else {
		$name = $input_name;
	}

	if (empty($input_address)) {
		$address_err = 'Please enter address.';
	} else {
		$address = $input_address;
	}

	if (empty($input_salary)) {
		$salary_err = 'Please enter salary.';
	} elseif (!ctype_digit($input_salary)) {
		$salary_err = 'Please enter a positive integer number';
	} else {
		$salary = $input_salary;
	}

	if (empty($name_err) && empty($address_err) && empty($salary_err)) {
		$sql = 'INSERT INTO employees(name, address, salary) VALUES(:name, :address, :salary)';
		if ($stmt = $pdo->prepare($sql)) {
			$stmt->bindParam(':name', $param_name);
			$stmt->bindParam(':address', $param_address);
			$stmt->bindParam(':salary', $param_salary);

			$param_name = $name;
			$param_address = $address;
			$param_salary = $salary;

			if ($stmt->execute()) {
				header('location: index.php');
				exit();
			} else {
				echo 'Something went wrong. Please try agian later.';
			}
			unset($stmt);
			unset($pdo);
		} else {
			echo 'ERROR: Could not be execute ' . $sql . $mysqli->error;
		}
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <link rel="stylesheet" href="bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container pt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Create Record</h2>
                </div>
                <p class="text-info">Please Fill this form and submit to add employee record to the databasse</p>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
                        <span class="help-block text-danger"><?php echo $name_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($address_err)) ? 'has-error' : ''; ?>">
                        <label for="address">Address</label>
                        <textarea name="address" id="address" class="form-control"><?php echo $address; ?></textarea>
                        <span class="help-block text-danger"><?php echo $address_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($salary)) ? 'has-error' : ''; ?>">
                        <label for="salary">Salary</label>
                        <input type="number" name="salary" id="salary" class="form-control" value="<?php echo $salary; ?>">
                        <span class="help-block text-danger"><?php echo $salary_err; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>