const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

registerBtn.addEventListener('click',()=>{
    container.classList.add('active');
});   

loginBtn.addEventListener('click',()=>{
    container.classList.remove('active')
});

// Authentication functionality
document.getElementById('loginForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    try {
        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);
        
        const response = await fetch('../backend/api/auth/login.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Store user data in session storage
            sessionStorage.setItem('user', JSON.stringify(result.data.user));
            
            // Redirect based on role
            if (result.data.user.role === 'admin') {
                window.location.href = 'admin-dashboard.php';
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

document.getElementById('registerForm').addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;
    
    if (password.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('password', password);
        
        const response = await fetch('../backend/api/auth/register.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            alert('Registro exitoso. Ahora puedes iniciar sesión.');
            container.classList.remove('active'); // Switch to login form
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Register error:', error);
        alert('Error de conexión. Intenta de nuevo.');
    }
});

// Social login functionality
document.getElementById('googleLogin').addEventListener('click', async (e) => {
    e.preventDefault();
    await handleGoogleLogin();
});

document.getElementById('githubLogin').addEventListener('click', async (e) => {
    e.preventDefault();
    await handleGithubLogin();
});

async function handleGoogleLogin() {
    try {
        // Simular token de Google para desarrollo
        // En producción, usarías Google Sign-In API
        const mockToken = btoa(JSON.stringify({
            sub: 'google_' + Date.now(),
            email: 'usuario.google@gmail.com',
            name: 'Usuario Google'
        }));
        
        const formData = new FormData();
        formData.append('token', mockToken);
        
        const response = await fetch('../backend/api/auth/google.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            sessionStorage.setItem('user', JSON.stringify(result.data.user));
            
            // Redirect based on role
            if (result.data.user.role === 'admin') {
                window.location.href = 'admin-dashboard.php';
            } else {
                window.location.href = 'dashboard.php';
            }
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Google login error:', error);
        alert('Error de conexión con Google. Intenta de nuevo.');
    }
}

async function handleGithubLogin() {
    try {
        // Simular código de GitHub para desarrollo
        // En producción, usarías GitHub OAuth
        const mockCode = 'github_code_' + Date.now();
        
        const formData = new FormData();
        formData.append('code', mockCode);
        
        const response = await fetch('../backend/api/auth/github.php', {
            method: 'POST',
            body: formData
        });
        
        const result = await response.json();
        
        if (result.success) {
            sessionStorage.setItem('user', JSON.stringify(result.data.user));
            
            // Redirect based on role
            if (result.data.user.role === 'admin') {
                window.location.href = 'admin-dashboard.php';
            } else {
                window.location.href = 'dashboard.php';
            }
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('GitHub login error:', error);
        alert('Error de conexión con GitHub. Intenta de nuevo.');
    }
}

// Check if user is already logged in
if (sessionStorage.getItem('user')) {
    const user = JSON.parse(sessionStorage.getItem('user'));
    if (user.role === 'admin') {
        window.location.href = 'admin-dashboard.php';
    } else {
        window.location.href = 'dashboard.php';
    }
}
