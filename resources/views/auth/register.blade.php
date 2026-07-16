<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register — Inventory</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      body{margin:0; font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial; background:linear-gradient(120deg,#fefce8 0%,#ecfeff 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px}
      .reg-page{width:min(100%, 1160px)}
      .reg-card{display:flex; flex-wrap:wrap; width:100%; min-height:660px; background:#fff; box-shadow:0 30px 80px rgba(2,6,23,0.10); border-radius:24px; overflow:hidden}
      .reg-left{flex:0 0 38%; padding:48px 42px; background:linear-gradient(135deg,#0f172a 0%,#111827 60%,#1d4ed8 100%); color:#fff; display:flex; flex-direction:column; justify-content:center}
      .reg-left h3{font-size:1.8rem; font-weight:700; margin-bottom:12px}
      .reg-left p{font-size:1rem; line-height:1.7; color:rgba(255,255,255,0.86)}
      .reg-right{flex:1 1 0; padding:48px 42px; display:flex; align-items:center}
      .form-control{border-radius:12px; border-color:#dbe4f0; padding:0.8rem 0.95rem}
      .form-control:focus{box-shadow:none; border-color:#6366f1}
      .btn-primary{background:linear-gradient(90deg,#111827,#2563eb); border:none; border-radius:12px; padding:0.8rem 1rem; font-weight:600}
      .btn-primary:hover{filter:brightness(1.03)}
      .muted{color:#64748b}
      @media (max-width:991px){.reg-card{min-height:auto}.reg-left{flex-basis:100%; min-height:260px}.reg-right{padding:32px 24px}}
      @media (max-width:576px){body{padding:16px}.reg-left{padding:28px 22px}.reg-right{padding:24px 18px}}
    </style>
  </head>
  <body>
    <div class="reg-page">
      <div class="reg-card">
        <div class="reg-left">
          <h3>Create your free account</h3>
          <p>Join now and unlock a polished inventory workspace with secure access, elegant controls, and fast onboarding.</p>
        </div>
        <div class="reg-right">
          @include('auth.components.register-component')
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
