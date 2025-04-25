<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $worksite_id = $_POST['worksite_id'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];
    $remarks = $_POST['remarks'];

    if (empty($employee_id)) {
        $error_message = "Please select an employee.";
    } elseif (empty($worksite_id)) {
        $error_message = "Please select a worksite.";
    } elseif (empty($date)) {
        $error_message = "Please enter a date.";
    } elseif (empty($hours) || !is_numeric($hours) || $hours <= 0) {
        $error_message = "Please enter valid hours.";
    } else {
        try {
            $stmt = $conn->prepare("INSERT INTO timesheets (employee_id, worksite_id, date, hours, remarks) VALUES (:employee_id, :worksite_id, :date, :hours, :remarks)");
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->bindParam(':worksite_id', $worksite_id);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':hours', $hours);
            $stmt->bindParam(':remarks', $remarks);
            $stmt->execute();

            header("Location: timesheets.php?success=1");
            exit();

        } catch (PDOException $e) {
            $error_message = "Error adding timesheet: " . $e->getMessage();
            error_log("Error adding timesheet: " . $e->getMessage(), 3, "error.log");
        }
    }
}

?>

<h2>Add Timesheet</h2>
<?php if (isset($error_message)): ?>
    <div class="alert alert-danger"><?php echo $error_message; ?></div>
<?php endif; ?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div class="form-group">
        <label for="employee_id">Employee:</label>
        <input type="hidden" id="employee_id" name="employee_id" required>
        <input type="text" class="form-control" id="employee_search" placeholder="Search Employee" autocomplete="off">
        <div id="employee_suggestions" class="list-group"></div>
    </div>

    <div class="form-group">
        <label for="worksite_id">Worksite:</label>
        <input type="hidden" id="worksite_id" name="worksite_id" required>
        <input type="text" class="form-control" id="worksite_search" placeholder="Search Worksite" autocomplete="off">
        <div id="worksite_suggestions" class="list-group"></div>
    </div>

    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" class="form-control" id="date" name="date" required>
    </div>

    <div class="form-group">
        <label for="remarks">Remarks:</label>
        <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Enter any extra allocated fuel or travel">
    </div>

    <div class="form-group">
        <label for="hours">Hours:</label>
        <input type="number" step="0.01" class="form-control" id="hours" name="hours" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Timesheet</button>
</form>

<link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/flatpickr.min.css">
<script src="https://npmcdn.com/flatpickr"></script>

<script>
    const employeeSearch = document.getElementById('employee_search');
    const employeeId = document.getElementById('employee_id');
    const employeeSuggestions = document.getElementById('employee_suggestions');

    employeeSearch.addEventListener('input', function() {
        const searchTerm = this.value;

        if (searchTerm.length < 2) {
            employeeSuggestions.innerHTML = '';
            return;
        }

        fetch('search_employees.php?search=' + searchTerm)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                employeeSuggestions.innerHTML = '';
                if (data.length === 0) {
                    const noResults = document.createElement('a');
                    noResults.href = "#";
                    noResults.textContent = "No employees found";
                    noResults.classList.add('list-group-item', 'list-group-item-action', 'disabled');
                    employeeSuggestions.appendChild(noResults);
                    return;
                }
                data.forEach(employee => {
                    const a = document.createElement('a');
                    a.href = "#";
                    a.textContent = employee.name;
                    a.classList.add('list-group-item', 'list-group-item-action');
                    a.addEventListener('click', function() {
                        employeeSearch.value = employee.name;
                        employeeId.value = employee.id;
                        employeeSuggestions.innerHTML = '';
                    });
                    employeeSuggestions.appendChild(a);
                });
            });
    });

    const worksiteSearch = document.getElementById('worksite_search');
    const worksiteId = document.getElementById('worksite_id');
    const worksiteSuggestions = document.getElementById('worksite_suggestions');

    worksiteSearch.addEventListener('input', function() {
        const searchTerm = this.value;

        if (searchTerm.length < 2) {
            worksiteSuggestions.innerHTML = '';
            return;
        }

        fetch('search_worksites.php?search=' + searchTerm)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                worksiteSuggestions.innerHTML = '';
                if (data.length === 0) {
                    const noResults = document.createElement('a');
                    noResults.href = "#";
                    noResults.textContent = "No worksites found";
                    noResults.classList.add('list-group-item', 'list-group-item-action', 'disabled');
                    worksiteSuggestions.appendChild(noResults);
                    return;
                }
                data.forEach(worksite => {
                    const a = document.createElement('a');
                    a.href = "#";
                    a.textContent = worksite.name;
                    a.classList.add('list-group-item', 'list-group-item-action');
                    a.addEventListener('click', function() {
                        worksiteSearch.value = worksite.name;
                        worksiteId.value = worksite.id;
                        worksiteSuggestions.innerHTML = '';
                    });
                    worksiteSuggestions.appendChild(a);
                });
            })
            .catch(error => {
                console.error("Error fetching worksites:", error);
                worksiteSuggestions.innerHTML = '';
                const errorItem = document.createElement('a');
                errorItem.href = "#";
                errorItem.textContent = "Error loading worksites";
                errorItem.classList.add('list-group-item', 'list-group-item-action', 'disabled');
                worksiteSuggestions.appendChild(errorItem);
            });
    });

    flatpickr("#date", {
        enableTime: false,
        dateFormat: "Y-m-d",
    });
</script>


<?php
include '../partials/footer.php';
?>