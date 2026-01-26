export function homeInit() {
  console.log('Home page loaded')

  const hero = document.querySelector('.home-hero')
  if (hero) {
    hero.classList.add('fade-in')
  }
}

