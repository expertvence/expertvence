export function servicesInit() {
  console.log('Services page loaded')

  document.querySelectorAll('.card').forEach(card => {
    card.addEventListener('mouseenter', () => {
      card.classList.add('active')
    })

    card.addEventListener('mouseleave', () => {
      card.classList.remove('active')
    })
  })
}
