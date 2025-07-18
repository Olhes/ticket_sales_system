const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click',()=>{
    container.classList.add('active');
});   

loginBtn.addEventListener('click',()=>{
    container.classList.remove('active')
});

const loginForm = document.querySelector('.form-box.login form');
if (loginForm) {
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const email = loginForm.email.value;
        const password = loginForm.password.value;
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        try {
            const response = await fetch('../backend/api/auth/login.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                sessionStorage.setItem('user', JSON.stringify(result.data.user));
                if (result.data.user.role === 'admin') {
                    window.location.href = 'dashboard-admin.php';
                } else {
                    window.location.href = 'dashboard.php';
                }
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Login error:', error);
            alert('Error de conexión. Intenta de nuevo.');
        }
    });
}

const registerForm = document.querySelector('.form-box.register form');
if (registerForm) {
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        // Eliminar mensaje de error previo si existe
        const prevError = registerForm.querySelector('.error-message');
        if (prevError) prevError.remove();

        const name = registerForm.name.value;
        const email = registerForm.email.value;
        const password = registerForm.password.value;
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        try {
            const response = await fetch('../backend/api/auth/register.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                // Puedes mostrar un mensaje de éxito o redirigir
                alert('Registro exitoso. Ahora puedes iniciar sesión.');
                // Opcional: cambiar a la vista de login
                container.classList.remove('active');
            } else {
                // Mostrar error arriba del botón REGISTRATE
                const errorDiv = document.createElement('div');
                errorDiv.className = 'error-message';
                errorDiv.style.color = 'red';
                errorDiv.style.marginBottom = '10px';
                errorDiv.style.textAlign = 'center';
                errorDiv.textContent = result.message;
                const btn = registerForm.querySelector('button[type="submit"], button.btn');
                btn.parentNode.insertBefore(errorDiv, btn);
            }
        } catch (error) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.style.color = 'red';
            errorDiv.style.marginBottom = '10px';
            errorDiv.style.textAlign = 'center';
            errorDiv.textContent = 'Error de conexión. Intenta de nuevo.';
            const btn = registerForm.querySelector('button[type="submit"], button.btn');
            btn.parentNode.insertBefore(errorDiv, btn);
        }
    });
}

if (sessionStorage.getItem('user')) {
    const user = JSON.parse(sessionStorage.getItem('user'));
    if (user.role === 'admin') {
        window.location.href = 'dashboard-admin.php';
    } else {
        window.location.href = 'dashboard.php';
    }
}
