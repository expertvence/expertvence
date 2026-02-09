
export const loadRecaptchaScript = (siteKey) => {
  return new Promise((resolve, reject) => {
    if (window.grecaptcha) return resolve()

    const script = document.createElement('script')
    script.src = `https://www.google.com/recaptcha/api.js?render=${siteKey}`
    script.async = true
    script.defer = true
    script.onload = resolve
    script.onerror = reject
    document.head.appendChild(script)
  })
}
