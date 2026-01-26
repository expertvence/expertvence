export function galleryInit() {
  console.log('Gallery loaded')

  document.querySelectorAll('.img-box').forEach(img => {
    img.addEventListener('click', () => {
      alert('Gallery item clicked')
    })
  })
}
