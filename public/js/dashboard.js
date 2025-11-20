document.addEventListener('DOMContentLoaded', function () {
  const cartButton = document.getElementById('cartButton');
  const closeCartButton = document.getElementById('closeCartButton');
  const cartDrawer = document.getElementById('cartDrawer');

  if (cartButton && closeCartButton && cartDrawer) {
    cartButton.addEventListener('click', function () {
      cartDrawer.classList.add('show');
    });

    closeCartButton.addEventListener('click', function () {
      cartDrawer.classList.remove('show');
    });

    document.addEventListener('click', function (event) {  
      if (!cartDrawer.contains(event.target) && !cartButton.contains(event.target)) {
        cartDrawer.classList.remove('show');
      }
    });
  }
});

// ========== HAMBURGER MENU TOGGLE ==========
const hamburgerBtn = document.getElementById('hamburgerBtn');
const headerContent = document.getElementById('headerContent');

// Create overlay element
const overlay = document.createElement('div');
overlay.className = 'overlay';
document.body.appendChild(overlay);

// Toggle menu
function toggleMenu() {
    hamburgerBtn.classList.toggle('active');
    headerContent.classList.toggle('active');
    overlay.classList.toggle('active');
    
    // Prevent body scroll when menu is open
    if (headerContent.classList.contains('active')) {
        document.body.classList.add('menu-open');
    } else {
        document.body.classList.remove('menu-open');
    }
}

// Event listeners
hamburgerBtn.addEventListener('click', toggleMenu);
overlay.addEventListener('click', toggleMenu);

// Close menu when clicking nav links (mobile)
const navLinks = document.querySelectorAll('.nav-links a');
navLinks.forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            toggleMenu();
        }
    });
});

// Close menu on window resize
window.addEventListener('resize', () => {
    if (window.innerWidth > 768 && headerContent.classList.contains('active')) {
        toggleMenu();
    }
});