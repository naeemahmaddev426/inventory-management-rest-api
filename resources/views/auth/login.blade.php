<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Login — Inventory</title>
		<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<style>
			:root{color-scheme:light}
		    body{margin:0; font-family:Inter,system-ui,-apple-system,"Segoe UI",Roboto,"Helvetica Neue",Arial; background:radial-gradient(circle at top left,#eef2ff 0%,#f8fafc 45%,#fef3c7 100%); min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px}
			.auth-page{width:min(100%, 1180px)}
			.auth-card{display:flex; flex-wrap:wrap; width:100%; min-height:620px; background:rgba(255,255,255,0.96); box-shadow:0 30px 80px rgba(2,6,23,0.12); border-radius:24px; overflow:hidden}
			.auth-left{flex:0 0 44%; padding:48px 42px; background:linear-gradient(135deg,#4338ca 0%,#2563eb 55%,#0f766e 100%); color:#fff; display:flex; flex-direction:column; justify-content:center}
			.brand-badge{display:inline-flex; width:48px; height:48px; border-radius:14px; align-items:center; justify-content:center; background:rgba(255,255,255,0.2); font-weight:700; letter-spacing:0.2px; margin-bottom:24px}
			.brand{font-weight:700; letter-spacing:0.3px; font-size:1.9rem; margin-bottom:10px}
			.auth-left p{font-size:1rem; line-height:1.7; color:rgba(255,255,255,0.9)}
			.auth-left ul{padding-left:18px; margin-top:18px; color:rgba(255,255,255,0.9)}
			.auth-left li{margin-bottom:8px}
			.auth-right{flex:1 1 0; padding:56px 48px; display:flex; align-items:center}
			.form-control{border-radius:12px; border-color:#dbe4f0; padding:0.8rem 0.95rem}
			.form-control:focus{box-shadow:none; border-color:#6366f1}
			.btn-primary{background:linear-gradient(90deg,#4f46e5,#06b6d4); border:none; border-radius:12px; padding:0.8rem 1rem; font-weight:600}
			.btn-primary:hover{filter:brightness(1.03)}
			.muted{color:#64748b}
			@media (max-width:991px){.auth-card{min-height:auto}.auth-left{flex-basis:100%; min-height:280px}.auth-right{padding:32px 24px}}
			@media (max-width:576px){body{padding:16px}.auth-left{padding:28px 22px}.auth-right{padding:24px 18px}}
		</style>
	</head>
	<body>
		<div class="auth-page">
			<div class="auth-card">
				<div class="auth-left">
					<div class="brand-badge">IP</div>
					<h2 class="brand">Inventory<span class="fw-light">Portal</span></h2>
					<p>Smart inventory insights, elegant workflows, and a clean dashboard for every team member.</p>
					<ul>
						<li>Fast product search</li>
						<li>Easy category management</li>
						<li>Secure REST API access</li>
					</ul>
				</div>
				<div class="auth-right">
					@include('auth.components.login-component')
				</div>
			</div>
		</div>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
		<script>
			document.addEventListener('click', function(e){
				if(e.target && e.target.matches('.toggle-password')){
					const input = document.querySelector('#password');
					if(input){
						input.type = input.type === 'password' ? 'text' : 'password';
						e.target.textContent = input.type === 'password' ? 'Show' : 'Hide';
					}
				}
			})
		</script>
	</body>
</html>
