document.addEventListener("DOMContentLoaded", function () {
    var form = document.querySelector("form");
    var passwords = document.querySelectorAll('input[type="password"]');

    // Feature 1: "Show password" checkbox
    if (passwords.length > 0) {
        var label = document.createElement("label");
        label.className = "show-pass";
        label.innerHTML = '<input type="checkbox"> Show password';
        var last = passwords[passwords.length - 1];
        last.insertAdjacentElement("afterend", label);

        label.querySelector("input").addEventListener("change", function () {
            passwords.forEach(function (p) {
                p.type = this.checked ? "text" : "password";
            }, this);
        });
    }

    // Feature 2: simple checks before the form is sent (signup page)
    var confirm = document.querySelector('input[name="confirm_password"]');
    if (form && confirm) {
        form.addEventListener("submit", function (e) {
            var pass = document.querySelector('input[name="password"]').value;
            if (pass.length < 8) {
                alert("Password must contain at least 8 characters.");
                e.preventDefault();
            } else if (pass !== confirm.value) {
                alert("Passwords do not match.");
                e.preventDefault();
            }
        });
    }
});
