const form = document.querySelector('form');

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  
  const fileInput = document.getElementById('profile-picture');
  const file = fileInput.files[0];
  
  const formData = new FormData();
  formData.append('username', document.getElementById('username').value);
  formData.append('email', document.getElementById('email').value);
  formData.append('password', document.getElementById('password').value);
  formData.append('profile-picture', file);
  
  const response = await fetch('register.php', {
    method: 'POST',
    body: formData
  });
  
  const result = await response.text();
  console.log(result);
});