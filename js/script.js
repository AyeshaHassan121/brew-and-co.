//HAMBURGER MENU
const hamburger = document.getElementById('hamburger');
const siteNav = document.getElementById('site-nav');

hamburger.addEventListener('click', () => {
  siteNav.classList.toggle('nav-open');
  const isOpen = siteNav.classList.contains('nav-open');
  hamburger.setAttribute('aria-expanded', isOpen);
});


//MENU TABS
const tabButtons = document.querySelectorAll('.tab-btn');
const categories = document.querySelectorAll('.menu-category');

tabButtons.forEach(button => {
  button.addEventListener('click', () => {
    const selected = button.getAttribute('data-category');

    tabButtons.forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');

    categories.forEach(cat => {
      cat.classList.toggle('active', cat.getAttribute('data-category') === selected);
    });
  });
});


//CART
let cart = [];

const cartCountEl = document.getElementById('cart-count');
const cartItemsEl = document.getElementById('cart-items');
const cartTotalEl = document.getElementById('cart-total');
const cartEmptyEl = document.getElementById('cart-empty');
const cartDropdown = document.getElementById('cart-dropdown');
const cartBtn = document.getElementById('cart-btn');

function updateCartUI() {
  const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
  cartCountEl.textContent = totalItems;
  cartItemsEl.innerHTML = '';

  if (cart.length === 0) {
    cartEmptyEl.style.display = 'block';
    cartTotalEl.textContent = '';
    return;
  }

  cartEmptyEl.style.display = 'none';

  let total = 0;
  cart.forEach((item) => {
    total += item.price * item.qty;
    const li = document.createElement('li');
    li.innerHTML = `
      <span>${item.name} x${item.qty} - Rs. ${item.price * item.qty}</span>
      <button class="remove-btn" data-name="${item.name}">Remove</button>
    `;
    cartItemsEl.appendChild(li);
  });

  cartTotalEl.textContent = `Total: Rs. ${total}`;
}

function findCartItem(name) {
  return cart.find(item => item.name === name);
}

document.querySelectorAll('.menu-item').forEach(item => {
  const name = item.getAttribute('data-name');
  const price = parseInt(item.getAttribute('data-price'));

  const addBtn = item.querySelector('.add-cart-btn');
  const qtyControls = item.querySelector('.qty-controls');
  const qtyValue = item.querySelector('.qty-value');
  const decreaseBtn = item.querySelector('.qty-decrease');
  const increaseBtn = item.querySelector('.qty-increase');

  addBtn.addEventListener('click', () => {
    cart.push({ name, price, qty: 1 });
    addBtn.style.display = 'none';
    qtyControls.style.display = 'flex';
    qtyValue.textContent = '1';
    updateCartUI();
    showToast('Item added to cart');
  });

  increaseBtn.addEventListener('click', () => {
    const cartItem = findCartItem(name);
    cartItem.qty += 1;
    qtyValue.textContent = cartItem.qty;
    updateCartUI();
  });

  decreaseBtn.addEventListener('click', () => {
    const cartItem = findCartItem(name);
    cartItem.qty -= 1;

    if (cartItem.qty <= 0) {
      cart = cart.filter(i => i.name !== name);
      qtyControls.style.display = 'none';
      addBtn.style.display = 'inline-block';
    } else {
      qtyValue.textContent = cartItem.qty;
    }

    updateCartUI();
  });
});

cartItemsEl.addEventListener('click', (e) => {
  if (!e.target.classList.contains('remove-btn')) return;

  const name = e.target.getAttribute('data-name');
  cart = cart.filter(i => i.name !== name);
  updateCartUI();

  const menuItem = document.querySelector(`.menu-item[data-name="${name}"]`);
  if (menuItem) {
    menuItem.querySelector('.add-cart-btn').style.display = 'inline-block';
    menuItem.querySelector('.qty-controls').style.display = 'none';
  }
});

cartBtn.addEventListener('click', () => {
  cartDropdown.classList.toggle('open');
});


//TOAST MESSAGE
const toast = document.getElementById('toast');
let toastTimeout;

function showToast(message) {
  toast.textContent = message;
  toast.classList.add('show');

  clearTimeout(toastTimeout);
  toastTimeout = setTimeout(() => {
    toast.classList.remove('show');
  }, 2000);
}


//IMAGE SLIDER
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

// only run slider code if the slider actually exists on this page
if (prevBtn && nextBtn) {

  let currentSlide = 0;

  function showSlide(index) {
    slides.forEach(slide => slide.classList.remove('active'));
    dots.forEach(dot => dot.classList.remove('active'));

    slides[index].classList.add('active');
    dots[index].classList.add('active');

    currentSlide = index;
  }

  nextBtn.addEventListener('click', () => {
    let nextIndex = currentSlide + 1;
    if (nextIndex >= slides.length) {
      nextIndex = 0;
    }
    showSlide(nextIndex);
  });

  prevBtn.addEventListener('click', () => {
    let prevIndex = currentSlide - 1;
    if (prevIndex < 0) {
      prevIndex = slides.length - 1;
    }
    showSlide(prevIndex);
  });

  dots.forEach(dot => {
    dot.addEventListener('click', () => {
      const index = parseInt(dot.getAttribute('data-index'));
      showSlide(index);
    });
  });

}


//CONTACT FORM VALIDATION
const contactForm = document.getElementById('contact-form');
if (contactForm) {

  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    let isValid = true;

    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const messageInput = document.getElementById('message');

    const nameError = document.getElementById('name-error');
    const emailError = document.getElementById('email-error');
    const messageError = document.getElementById('message-error');

    nameError.classList.remove('show');
    emailError.classList.remove('show');
    messageError.classList.remove('show');

    if (nameInput.value.trim() === '') {
      nameError.textContent = 'Please enter your name';
      nameError.classList.add('show');
      isValid = false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(emailInput.value.trim())) {
      emailError.textContent = 'Please enter a valid email address';
      emailError.classList.add('show');
      isValid = false;
    }

    if (messageInput.value.trim() === '') {
      messageError.textContent = 'Please enter a message';
      messageError.classList.add('show');
      isValid = false;
    }

    if (isValid) {
      showToast('Message sent successfully');
      contactForm.reset();
    }
  });

}