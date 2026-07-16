<div class="w-100">
  <div class="mb-4">
    <h3 class="mb-1">Create account</h3>
    <p class="muted mb-0">Start managing inventory in minutes</p>
  </div>

  <form method="POST" action="{{ route('register') }}" class="row g-3">
    @csrf
    <div class="col-12">
      <label class="form-label fw-semibold">Full name</label>
      <input type="text" name="name" class="form-control rounded-3" autocomplete="name" required>
    </div>
    <div class="col-12">
      <label class="form-label fw-semibold">Email</label>
      <input type="email" name="email" class="form-control rounded-3" autocomplete="email" required>
    </div>
    <div class="col-12">
      <label class="form-label fw-semibold">Password</label>
      <input type="password" name="password" class="form-control rounded-3" autocomplete="new-password" required>
    </div>
    <div class="col-12">
      <label class="form-label fw-semibold">Confirm password</label>
      <input type="password" name="password_confirmation" class="form-control rounded-3" autocomplete="new-password" required>
    </div>
    <div class="col-12">
      <button class="btn btn-primary w-100 rounded-3" type="submit">Create account</button>
    </div>
  </form>

  <div class="text-center mt-3">
    <small class="muted">Already registered? <a href="/design-login">Sign in</a></small>
  </div>
</div>
