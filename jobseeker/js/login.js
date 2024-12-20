document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const username = document.getElementById('username').value.trim();
    const password = document.getElementById('password').value;


    if (username === '') {
        alert('Username is required.');
        return;
    }

    if (password === '') {
        alert('Password is required.');
        return;
    }

});