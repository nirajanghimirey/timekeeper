<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

// Handle filter options
$search = isset($_GET['search']) ? $_GET['search'] : '';

?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h2>Employees</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a href="add_employee.php" class="btn btn-primary mb-3">Add Employee</a> 
        </div>
        <div class="col-md-6">
            <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="float-right">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search" name="search" value="<?php echo $search; ?>" placeholder="Search by Name">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Pay Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM employees"; 

                    if (!empty($search)) {
                        $sql .= " WHERE name LIKE :search";
                    }

                    $stmt = $conn->prepare($sql);

                    if (!empty($search)) {
                        $search = "%".$search."%"; 
                        $stmt->bindParam(':search', $search);
                    }

                    $stmt->execute();
                    $employees = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($employees as $employee): ?>
                        <tr>
                            <td><?php echo $employee['name']; ?></td>
                            <td><?php echo $employee['phone']; ?></td>
                            <td><?php echo $employee['email']; ?></td>
                            <td><?php echo $employee['pay_rate']; ?></td>
                            <td>
                                <a href="edit_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="delete_employee.php?id=<?php echo $employee['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this employee?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include '../partials/footer.php';
?>