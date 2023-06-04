<style>
  <?php
  include '../../CSS/header.css'; ?>
</style>
<div class="pageheader">
  <!-- <div class="navbar navbar-fixed-top navbar-custom "> -->
  <!-- <div class="container"> -->
  <div class="navbar-header">
    <a class="navbar-brand" href="#"><img class="logo" src="../../IMAGES/logo.png" alt=""></a>
  </div>
  <!-- <div class="nav navbar-nav navbar-right"> -->
  <div class="dropdown toggle-position">

    <button class="btn btn-secondary dropdown-toggle " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php
      echo $_SESSION['bio']['firstname']; ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
      <!-- <li class="dropdown-item">
echo $_SESSION['bio']['Firstname'];  
<?php  ?>
</li> -->
      <li class="dropdown-item">
        <?php echo $_SESSION['bio']['userid']; ?>
      </li>
      <li class="dropdown-item">
        <?php $usertype = $_SESSION['bio']['usertype'];
        if ($usertype == 1)
          echo "Student";
        if ($usertype == 2)
          echo "Faculty";
        if ($usertype == 3)
          echo "Admin";
        ?>
      </li>
      <form method="POST" id="logout">
        <input type="submit" name="logout" value="Logout" id="logout">
      </form>
      <script>
        $('#logout').submit(function(e) {
          e.preventDefault();
          $('#logout button[type="submit"]').attr('disabled', true).html('Logging out...');
          $.ajax({
            url: '../../admin/ajax.php?action=logout',
            method: 'GET',
            error: err => {
              alert("Unknown error occurred");
              $('#logout button[type="submit"]').removeAttr('disabled').html('Logout');
            },
            success: function(resp) {
              var response = JSON.parse(resp);
              if (response.success) {
                window.location.href = response.redirect;
              } else {
                alert("Logout failed. Please try again.");
                $('#logout button[type="submit"]').removeAttr('disabled').html('Logout');
              }
            }
          });
        });
      </script>
    </div>
  </div>
</div>