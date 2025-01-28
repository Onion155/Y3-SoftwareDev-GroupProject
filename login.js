document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from submitting the traditional way

    // retreving html data 
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const message = document.getElementById('message');

    // data base
    const Users = ['Marco', 'Ben', 'David', 'Susan', 'Karen'];
    const Paswords = ['123', '456', '789', '101', '000'];

    function CorrectUser() // returns true if the user is in the data base (both password and Name)
    {
        for (let i= 0; i < Users.length; i++)
    {
        // return true if there is a user or false if there is not
        if (username == Users[i] && password == Paswords[i])
        {
            return true;
        }
    }
    return false;
    }

    
    if (CorrectUser()) {
        message.textContent = 'Login successful!';
        message.style.color = 'green';
        window.location.href = 'DoctorPage.html';
        // in here it should log the user in and give them the correct permissions/ access attched to their account 
    } else {
        message.textContent = 'Invalid username or password.';
        message.style.color = 'red';
        // if it gets here it means their account doesnt exist
    }
});