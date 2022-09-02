// For popover
const popoverTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="popover"]'));
const popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl);
});

// To hide navbar
el_autohide = document.querySelector('.autohide');

// add padding-top to bady (if necessary)
navbar_height = document.querySelector('.navbar').offsetHeight;
document.body.style.paddingTop = navbar_height + 'px';

if (el_autohide) {
  let last_scroll_top = 0;
  window.addEventListener('scroll', function() {
    let scroll_top = window.scrollY;
    if (scroll_top < last_scroll_top) {
      el_autohide.classList.remove('scrolled-down');
      el_autohide.classList.add('scrolled-up');
    } else {
      el_autohide.classList.remove('scrolled-up');
      el_autohide.classList.add('scrolled-down');
    }
    last_scroll_top = scroll_top;
  });
  // window.addEventListener
}