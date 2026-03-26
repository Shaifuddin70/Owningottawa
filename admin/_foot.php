</div>
<?php if (!empty($_SESSION['admin_ok'])): ?>
  </div><!-- /.admin-main -->
</div><!-- /.admin-app -->
<script>
(function () {
  var app = document.getElementById('adminApp');
  var toggle = document.getElementById('adminMenuToggle');
  var backdrop = document.getElementById('adminSidebarBackdrop');
  if (!app || !toggle) return;

  function setOpen(open) {
    if (open) {
      app.classList.add('admin-sidebar-open');
      document.body.classList.add('admin-sidebar-open');
      toggle.setAttribute('aria-expanded', 'true');
      toggle.setAttribute('aria-label', 'Close menu');
      if (backdrop) backdrop.setAttribute('aria-hidden', 'false');
    } else {
      app.classList.remove('admin-sidebar-open');
      document.body.classList.remove('admin-sidebar-open');
      toggle.setAttribute('aria-expanded', 'false');
      toggle.setAttribute('aria-label', 'Open menu');
      if (backdrop) backdrop.setAttribute('aria-hidden', 'true');
    }
  }

  toggle.addEventListener('click', function () {
    setOpen(!app.classList.contains('admin-sidebar-open'));
  });

  if (backdrop) {
    backdrop.addEventListener('click', function () {
      setOpen(false);
    });
  }

  app.querySelectorAll('.admin-sidebar a').forEach(function (a) {
    a.addEventListener('click', function () {
      if (window.matchMedia('(max-width: 991.98px)').matches) {
        setOpen(false);
      }
    });
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && app.classList.contains('admin-sidebar-open')) {
      setOpen(false);
    }
  });

  window.addEventListener('resize', function () {
    if (window.matchMedia('(min-width: 992px)').matches) {
      setOpen(false);
    }
  });
})();
</script>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
