<?php
session_start();
include '../config/config.php';
include '../partials/header.php';

if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
  header("Location: login.php");
  exit();
}

?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Worksites</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Worksites</h3>
              <div class="card-tools">
                <a href="add_worksite.php" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Worksite</a>
              </div>
            </div>
            <div class="card-body">
              <table id="worksites-table" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th>Company</th>
                    <th>Worksite</th>
                    <th>Address</th>
                    <th style="width: 150px;">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sql = "SELECT c.name AS company_name, w.name AS worksite_name, w.address, w.id 
                          FROM worksites w 
                          JOIN companies c ON w.company_id = c.id "; 

                  $stmt = $conn->prepare($sql);
                  $stmt->execute();
                  $worksites = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  foreach ($worksites as $worksite) : ?>
                    <tr>
                      <td><?php echo $worksite['company_name']; ?></td>
                      <td><?php echo $worksite['worksite_name']; ?></td>
                      <td><?php echo $worksite['address']; ?></td>
                      <td>
                        <a href="edit_worksite.php?id=<?php echo $worksite['id']; ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a> 
                        <a href="delete_worksite.php?id=<?php echo $worksite['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this worksite?')"><i class="fas fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
include '../partials/footer.php';
?>

<script>
  $(function () {
    $("#worksites-table").DataTable({
      "responsive": true, 
      "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]] 
    });
  });
</script>