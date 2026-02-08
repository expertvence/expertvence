import { rawCountries } from './countries.raw'

// ✅ Vite-safe glob (IMPORTANT)
const flagModules = import.meta.glob(
  '/resources/js/assets/flags/*.svg'
)

// async flag loader
export const getFlagAsync = async (iso) => {
  const key = `/resources/js/assets/flags/${iso.toLowerCase()}.svg`

  if (!flagModules[key]) {
    // optional: no console.warn to avoid spam
    return null
  }

  const module = await flagModules[key]()
  return module.default
}

// main loader
export const loadCountries = async () => {
  return Promise.all(
    rawCountries.map(async (c) => ({
      // map country_name → name
      name: c.country_name,
      iso: c.iso,
      dial_code: c.dial_code,
      flag: await getFlagAsync(c.iso)
    }))
  )
}

// sync helper (for already loaded countries)
export const getFlag = (iso, countries) => {
  const country = countries.find(c => c.iso === iso)
  return country?.flag || ''  // safe fallback
}
