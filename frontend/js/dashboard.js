document.addEventListener('DOMContentLoaded', () => {
    const sideMenu = document.querySelector("aside");
    const menuBtn = document.querySelector("#menu-btn");
    const closeBtn = document.querySelector("#close-btn");

    // Get the dark mode toggle elements
    const darkModeToggle = document.querySelector('.dark-mode-toggle');
    const lightModeIcon = document.getElementById('light-mode-toggle');
    const darkModeIcon = document.getElementById('dark-mode-toggle');

    // Load theme from localStorage
    // Check if a theme preference is stored in the user's browser.
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        // If the saved theme is 'dark', apply the 'dark-theme' class to the body
        // and set the dark mode icon as active.
        document.body.classList.add('dark-theme');
        lightModeIcon.classList.remove('active');
        darkModeIcon.classList.add('active');
    } else {
        // Otherwise, ensure the light mode icon is active (default).
        lightModeIcon.classList.add('active');
        darkModeIcon.classList.remove('active');
    }

    // Toggle dark mode
    // Add an event listener to the dark mode toggle container.
    darkModeToggle.addEventListener('click', () => {
        // Toggle the 'dark-theme' class on the body element.
        // This class will trigger CSS changes for dark mode.
        document.body.classList.toggle('dark-theme');

        // Update localStorage and icon active states based on current theme.
        if (document.body.classList.contains('dark-theme')) {
            // If dark theme is active, save 'dark' to localStorage.
            localStorage.setItem('theme', 'dark');
            lightModeIcon.classList.remove('active');
            darkModeIcon.classList.add('active');
        } else {
            // If light theme is active, save 'light' to localStorage.
            localStorage.setItem('theme', 'light');
            lightModeIcon.classList.add('active');
            darkModeIcon.classList.remove('active');
        }
    });

    // Sidebar functionality (if you have it)
    // Add event listeners for sidebar menu and close buttons.
    if (menuBtn) {
        menuBtn.addEventListener('click', () => {
            sideMenu.style.display = 'block';
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            sideMenu.style.display = 'none';
        });
    }
});