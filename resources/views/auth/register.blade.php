@include('layout.shopping-base')

  <link rel="icon" type="image/png" href="{{ asset('favicon.ico') }}">
  <link rel="stylesheet" href="{{ asset('assets/register.css') }}">
  <title>Register</title>

  <div class="form-container">
    <img src="{{ asset('images/logo.png') }}" alt="EcoScan" class="register-logo" />
    <h2 style="color: white;">Register</h2>

    <x-success-message />
    <x-validation-errors />

    <form id="register-form" method="POST" action="{{ route('register.post') }}">
      @csrf
      <div class="row">
          <div class="col-md-6">
            <input type="text" name="first_name" class="input-field" placeholder="First Name" value="{{ old('first_name') }}" required autofocus>
          </div>

          <div class="col-md-6">
            <input type="text" name="last_name" class="input-field" placeholder="Last Name" value="{{ old('last_name') }}" required autofocus>
          </div>
        </div>

      <input type="email" name="email" class="input-field" placeholder="Email" value="{{ old('email') }}" required>

      <div style="position: relative; width: 100%;">
        <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
        <button type="button" class="toggle-password" data-target="password">👁️</button>
      </div>

      <ul id="password-checklist">
        <li id="length">✖ At least 8 characters</li>
        <li id="lowercase">✖ At least one lowercase letter</li>
        <li id="uppercase">✖ At least one uppercase letter</li>
        <li id="number">✖ At least one number</li>
        <li id="special">✖ At least one special character (@$!%*?&)</li>
      </ul>

      <div style="position: relative; width: 100%;">
        <input type="password" id="password_confirmation" name="password_confirmation" class="input-field" placeholder="Confirm Password" required>
        <button type="button" class="toggle-password" data-target="password_confirmation">👁️</button>
      </div>

      <button type="submit" class="register-btn">Register</button>

      <div class="links">
        <a href="{{ route('login') }}">Already registered? Log in here</a>
      </div>
    </form>
  </div>

<script>
document.querySelectorAll(".toggle-password").forEach(button => {
  button.addEventListener("click", function () {
    const targetId = this.getAttribute("data-target");
    const field = document.getElementById(targetId);
    field.type = field.type === "password" ? "text" : "password";
    this.textContent = field.type === "password" ? "👁️" : "🙈";
  });
});

const checklist = {
  length: false,
  lowercase: false,
  uppercase: false,
  number: false,
  special: false
};

document.getElementById("password").addEventListener("input", function () {
  const value = this.value;
  checklist.length = value.length >= 8;
  checklist.lowercase = /[a-z]/.test(value);
  checklist.uppercase = /[A-Z]/.test(value);
  checklist.number = /\d/.test(value);
  checklist.special = /[@$!%*?&]/.test(value);

  for (let key in checklist) {
    updateChecklist(key, checklist[key]);
  }

  const allPassed = Object.values(checklist).every(v => v);
});

function updateChecklist(id, isValid) {
  const item = document.getElementById(id);
  item.style.color = isValid ? "lime" : "red";
  item.textContent = `${isValid ? '✔' : '✖'} ${item.textContent.slice(2)}`;
}

document.getElementById("register-form").addEventListener("submit", function (event) {
  const password = document.getElementById("password").value;
  const confirmPassword = document.getElementById("password_confirmation").value;
  const allPassed = Object.values(checklist).every(v => v);

  if (!allPassed) {
    alert("Password does not meet all the requirements.");
    event.preventDefault();
  } else if (password !== confirmPassword) {
    alert("Passwords do not match!");
    event.preventDefault();
  }
});

</script>