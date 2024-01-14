<?php
    // Connecting to the Database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "note";
    // Create a connection
    $conn = mysqli_connect($servername, $username, $password, $database);
    // Die if connection was not successful
    if (!$conn){
        die("Sorry we failed to connect: ". mysqli_connect_error());
    }

    if(isset($_GET['delete'])){
        $sno = $_GET['delete'];
        $sql = "DELETE FROM `todo` WHERE `sno` = $sno";
        $result = mysqli_query($conn, $sql);
        header("location:index.php");
      }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    if (isset( $_POST['snoEdit'])){
        // Update the record
          $sno = $_POST["snoEdit"];
          $title = $_POST["titleEdit"];
          $description = $_POST["descriptionEdit"];
      
        // Sql query to be executed
        $sql = "UPDATE `todo` SET `title` = '$title', `description`='$description' WHERE `sno` = '$sno'";
        $result = mysqli_query($conn, $sql);
        header("location:index.php");
       
      }
    else
    {
        $title = $_POST["title"];
        $description = $_POST["description"];
    
      // Sql query to be executed
      $sql = "INSERT INTO `todo` (`title`, `description`) VALUES ('$title', '$description')";
      $result = mysqli_query($conn, $sql);
      header("location:index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MyNotes</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css"
    />
  </head>

  <body>
    <div
      class="modal fade"
      id="editModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="editModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit this Note</h5>
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form action="/CURD/index.php" method="POST">
            <div class="modal-body">
              <input type="hidden" name="snoEdit" id="snoEdit" />
              <div class="form-group">
                <label for="title">Note Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="titleEdit"
                  name="titleEdit"
                  aria-describedby="emailHelp"
                />
              </div>

              <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea
                  class="form-control"
                  id="descriptionEdit"
                  name="descriptionEdit"
                  rows="3"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer  mr-auto">
              <button
                type="button"
                class="btn btn-secondary"
                data-dismiss="modal"
              >
                Close
              </button>
              <button type="submit" class="btn btn-primary">
                Save changes
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <nav class="navbar bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img
            src="logo.jpg"
            alt="Logo"
            width="50"
            height="30"
            class="d-inline-block align-text-top"
          />
          MyNotes
        </a>
      </div>
    </nav>
    <div class="container my-4 w-75">
      <h2>Add a note</h2>
      <form action="\CURD\index.php" method="post">
        <div class="mb-4">
          <label for="title" class="form-label">Title</label>
          <input
            type="text"
            class="form-control"
            id="title"
            placeholder="title"
            name="title"
          />
        </div>
        <div class="mb-3">
          <label for="desc" class="form-label">description</label>
          <textarea
            class="form-control"
            id="description"
            rows="3"
            placeholder="add a note"
            name="description"
          ></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
      </form>
    </div>
    <div class="container my-4 w-75">


<table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php 
      $sql = "SELECT * FROM `todo`";
      $result = mysqli_query($conn, $sql);
      $sno = 0;
      while($row = mysqli_fetch_assoc($result)){
        $sno = $sno + 1;
        echo "<tr>
        <th scope='row'>". $sno . "</th>
        <td>". $row['title'] . "</td>
        <td>". $row['description'] . "</td>
        <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>  </td>
      </tr>";
    } 
      ?>
  </tbody>
</table>
</div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://code.jquery.com/jquery-3.7.1.js"
      integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
      crossorigin="anonymous"
    ></script>
    <script src="//cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function () {
        $("#myTable").DataTable();
      });
    </script>
    <script>
      edits = document.getElementsByClassName("edit");
      Array.from(edits).forEach((element) => {
          element.addEventListener("click", (e) => {
          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;
          titleEdit.value = title;
          descriptionEdit.value = description;
          snoEdit.value = e.target.id;
          $("#editModal").modal("toggle");
        });
      });


      deletes = document.getElementsByClassName("delete");
      Array.from(deletes).forEach((element) => {
          element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1);

         if (confirm("Are you sure you want to delete this note!")) {
                    console.log("yes");
                    window.location = `/CURD/index.php?delete=${sno}`;
                }
        else {
                console.log("no");
                }
        });
      });  

    </script>
  </body>
</html>
