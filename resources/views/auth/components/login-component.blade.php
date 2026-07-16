<div class="w-100">
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-2 mb-4">
    <div>
      <h3 class="mb-1">Welcome back</h3>
      <p class="muted mb-0">Sign in to manage your inventory</p>
    </div>
    <div class="text-end d-none d-md-block">
      <small class="muted">No account? <a href="/design-register">Create one</a></small>
    </div>
  </div>

  <form method="POST" action="{{ route('login') }}" class="row g-3">
    @csrf
    <div class="col-12">
      <label class="form-label fw-semibold">Email</label>
      <input type="email" name="email" class="form-control form-control-lg rounded-3" placeholder="" required>
    </div>
    <div class="col-12">
      <label class="form-label fw-semibold">Password</label>
      <div class="input-group">
        <input id="password" type="password" name="password" class="form-control form-control-lg rounded-start-3" placeholder="" required>
        <button type="button" class="btn btn-outline-secondary toggle-password rounded-end-3">Show</button>
      </div>
    </div>
    <div class="col-12 d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="remember" id="remember">
        <label class="form-check-label muted" for="remember">Remember me</label>
      </div>
      <a href="/forgot-password" class="muted">Forgot password?</a>
    </div>
    <div class="col-12">
      <button class="btn btn-primary btn-lg w-100 rounded-3" type="submit">Sign in</button>
    </div>
  </form>

  <div class="text-center mt-4 d-md-none">
    <small class="muted">No account? <a href="/design-register">Create one</a></small>
  </div>
</div>
