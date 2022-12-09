// For popover
const popoverTriggerList = [].slice.call(
  document.querySelectorAll('[data-bs-toggle="popover"]')
)
const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
  return new bootstrap.Popover(popoverTriggerEl)
})

// To hide navbar
el_autohide = document.querySelector('.autohide')

// add padding-top to body (if necessary)
navbar_height = document.querySelector('.navbar').offsetHeight
document.body.style.paddingTop = navbar_height + 'px'

if (el_autohide) {
  let last_scroll_top = 0
  window.addEventListener('scroll', function () {
    let scroll_top = window.scrollY
    if (scroll_top < last_scroll_top) {
      el_autohide.classList.remove('scrolled-down')
      el_autohide.classList.add('scrolled-up')
    } else {
      el_autohide.classList.remove('scrolled-up')
      el_autohide.classList.add('scrolled-down')
    }
    last_scroll_top = scroll_top
  })
  // window.addEventListener
}

// For image checkbox
document.addEventListener('DOMNodeInserted', function () {
  const checkboxes = document.querySelectorAll('.isFeaturedCheck')

  checkboxes.forEach((checkbox) => {
    checkbox.addEventListener('change', (event) => {
      if (event.target.checked) {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false
        })
        event.target.checked = true
      }
    })
  })
})

// Check if at least one checkbox is checked
document.getElementById('button-send-trick').addEventListener('click', (event) => {
  // at least one checkbox must be checked
  const checkboxes = document.querySelectorAll('.isFeaturedCheck')
  let checked = false
  checkboxes.forEach((checkbox) => {
    if (checkbox.checked) {
      checked = true
    }
  })
  if (!checked) {
    alert('Vous devez choisir au moins une image à mettre en avant !')
    event.preventDefault()
  }
})



