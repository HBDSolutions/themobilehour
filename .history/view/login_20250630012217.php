<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-title text-center">
          <h4>Account Login</h4>
        </div>
        <div class="d-flex flex-column text-center">
          <?php if (!empty($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); ?></div>
          <?php endif; ?>          
          <form action="/themobilehour/controller/authentication.php" method="POST">
            <div class="form-group">
              <input type="email" class="form-control" id="username" name="username" placeholder="Your email address...">
            </div>
            <div class="form-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Your password...">
            </div>
            <button type="submit" class="btn btn-info btn-block btn-round">Login</button>
          </form>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <div class="signup-section">Not a member yet? <a href="view/register.php" class="text-info"> Sign Up</a>.</div>
      </div>
      <?php if (!empty($_SESSION['error'])): ?>
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          $('#loginModal').modal('show');
        });
      </script>
      <?php unset($_SESSION['error']); ?>
      <?php endif; ?>
    </div>
  </div>
</div>