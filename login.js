document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting the traditional way

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const message = document.getElementById('message');

    // Simple validation (for demonstration purposes)
    if (username === 'user' && password === 'password') {
        message.textContent = 'Login successful!';
        message.style.color = 'green';
    } else {
        message.textContent = 'Invalid username or password.';
        message.style.color = 'red';
    }
});