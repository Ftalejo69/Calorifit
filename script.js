document.getElementById('openProfile').addEventListener('click', function(event) {
    event.preventDefault();
    document.getElementById('profileModal').classList.add('active');
  });
  
  document.getElementById('closeProfile').addEventListener('click', function() {
    document.getElementById('profileModal').classList.remove('active');
  });
  
  document.getElementById('profileModal').addEventListener('click', function(event) {
    if (event.target === this) {
      this.classList.remove('active');
    }
  });
  