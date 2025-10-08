
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