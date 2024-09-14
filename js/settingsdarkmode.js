  // Get button and menu elements
  const menuButton = document.querySelector('.menu-button');
  const menuContent = document.querySelector('.menu-content');
  const menuIcon = menuButton.querySelector('i'); 
  
  menuButton.addEventListener('click', function() {
      if (menuContent.style.display === 'block') {
          menuContent.style.display = 'none';
          menuIcon.classList.remove('fa-times');
          menuIcon.classList.add('fa-align-justify');
          menuIcon.style.transform = 'rotate(0deg)'; 
      } else {
          menuContent.style.display = 'block';
          menuIcon.classList.remove('fa-align-justify');
          menuIcon.classList.add('fa-times');
          menuIcon.style.transform = 'rotate(180deg)'; 
      }
  });
  
  // Close menu if clicked outside
  window.addEventListener('click', function(event) {
      if (!menuButton.contains(event.target) && !menuContent.contains(event.target)) {
          menuContent.style.display = 'none';
          menuIcon.classList.remove('fa-times');
          menuIcon.classList.add('fa-align-justify');
          menuIcon.style.transform = 'rotate(0deg)'; 
      }
  });
  
  // Get elements for settings
  const settingsLink = document.getElementById('settings-link');
  const settingsModal = document.getElementById('settings-modal');
  const closeSettingsModal = document.getElementById('close-settings-modal');
  const themeToggle = document.getElementById('theme-toggle');
  
  // Function to toggle dark mode
  function toggleDarkMode(isDarkMode) {
      document.body.classList.toggle('dark-mode', isDarkMode);
      localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
      themeToggle.checked = isDarkMode;
  }
  
  // Event listener for settings link
  settingsLink.addEventListener('click', function() {
      settingsModal.style.display = 'flex';
  });
  
  // Event listener for close button
  closeSettingsModal.addEventListener('click', function() {
      settingsModal.style.display = 'none';
  });
  
  // Event listener for theme toggle
  themeToggle.addEventListener('change', function() {
      toggleDarkMode(themeToggle.checked);
  });
  
  // Initialize theme based on localStorage
  document.addEventListener('DOMContentLoaded', function() {
      const darkMode = localStorage.getItem('darkMode') === 'enabled';
      toggleDarkMode(darkMode);
  });

// Upload Profile //

  document.getElementById('avatarImage').addEventListener('click', function() {
    document.getElementById('profilePicture').click();
});