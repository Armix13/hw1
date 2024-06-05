function checkName(event) {
    const input = event.currentTarget;
    if (input.value.length === 0) {
        alert("Il campo Nome non può essere vuoto.");
        return false;
    }
    return true;
}

function checkSurname(event) {
    const input = event.currentTarget;
    if (input.value.length === 0) {
        alert("Il campo Cognome non può essere vuoto.");
        return false;
    }
    return true;
}

function jsonCheckUsername(json) {
    if (json.exists) {
        alert("Nome utente già utilizzato.");
        return false;
    }
    return true;
}

function jsonCheckEmail(json) {
    if (json.exists) {
        alert("Email già utilizzata.");
        return false;
    }
    return true;
}

function fetchResponse(response) {
    if (!response.ok) return null;
    return response.json();
}

function checkUsername(event) {
    const input = event.currentTarget;
    if (input.value.length > 10) {
        alert("Il campo Nome Utente deve contenere al massimo 10 caratteri.");
        return false;
    } else {
        fetch("check_username.php?q=" + encodeURIComponent(input.value))
            .then(fetchResponse)
            .then(json => jsonCheckUsername(json));
    }
    return true;
}

function checkEmail(event) {
    const input = event.currentTarget;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    
    if (!emailPattern.test(String(input.value).toLowerCase())) {
        alert("Inserisci un'Email valida.");
        return false;
    } else {
        fetch("check_email.php?q=" + encodeURIComponent(String(input.value).toLowerCase()))
            .then(fetchResponse)
            .then(json => jsonCheckEmail(json));
    }
    return true;
}

function checkPassword(event) {
    const input = event.currentTarget;
    const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (!passwordPattern.test(input.value)) {
        alert("La Password deve contenere almeno 8 caratteri, una lettera maiuscola, un numero e un carattere speciale.");
        return false;
    }
    return true;
}

function checkConfirmPassword(event) {
    const input = event.currentTarget;
    const passwordInput = document.querySelector('.password input');

    if (input.value !== passwordInput.value) {
        alert("Le Password non coincidono.");
        return false;
    }
    return true;
}

function checkSignup(event) {
    const form = event.currentTarget;
    const validName = checkName({ currentTarget: form.querySelector('.name input') });
    const validSurname = checkSurname({ currentTarget: form.querySelector('.surname input') });
    const validUsername = checkUsername({ currentTarget: form.querySelector('.username input') });
    const validEmail = checkEmail({ currentTarget: form.querySelector('.email input') });
    const validPassword = checkPassword({ currentTarget: form.querySelector('.password input') });
    const validConfirmPassword = checkConfirmPassword({ currentTarget: form.querySelector('.password_confirm input') });

    if (!(validName && validSurname && validUsername && validEmail && validPassword && validConfirmPassword)) {
        event.preventDefault();
        alert("Per favore, completa correttamente tutti i campi.");
    }
}

document.querySelector('.name input').addEventListener('blur', checkName);
document.querySelector('.surname input').addEventListener('blur', checkSurname);
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.password_confirm input').addEventListener('blur', checkConfirmPassword);
document.querySelector('form').addEventListener('submit', checkSignup);
