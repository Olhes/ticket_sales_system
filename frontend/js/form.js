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

if (sessionStorage.getItem('user')) {
    const user = JSON.parse(sessionStorage.getItem('user'));
    if (user.role === 'admin') {
        window.location.href = 'dashboard-admin.php';
    } else {
        window.location.href = 'dashboard.php';
    }
}
