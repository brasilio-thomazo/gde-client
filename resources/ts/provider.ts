export function phoneMask(str: string) {
  const regex = /([0-9]{2})(9?)([0-9]{4})([0-9]{4})/
  return str.replace(regex, '($1) $2$3-$4')
}

export function dateFormat(str: string) {
  return new Date(str).toLocaleString('pt-BR').replace(',', '\n')
}

export function parseDate(str: string) {
  return str.replace(/([0-9]{4})-([0-9]{2})-([0-9]{2})/, '$3/$2/$1')
}

export function maskDocument(str: string) {
  const cpf = /([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/
  const cnpj = /([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})/
  if (cnpj.test(str)) return str.replace(cnpj, '$1.$2.$3/$4-$5')
  return str.replace(cpf, '$1.$2.$3-$4')
}

export function mask(str: string, isPhone = false): string {
  const cpf = /([0-9]{3})([0-9]{3})([0-9]{3})([0-9]{2})/
  const cnpj = /([0-9]{2})([0-9]{3})([0-9]{3})([0-9]{4})([0-9]{2})/
  const phone = /([0-9]{2})(9?)([0-9]{4})([0-9]{4})/
  if (cnpj.test(str)) return str.replace(cnpj, '$1.$2.$3/$4-$5')
  else if (cpf.test(str) && !isPhone) return str.replace(cpf, '$1.$2.$3-$4')
  return str.replace(phone, '($1) $2$3-$4')
}

export function interval(str: string | null) {
  if (!str) return '0 00:00:00'
  const start = new Date(str)
  const now = new Date()
  let ms = now.getTime() - start.getTime()
  const s = Math.floor((ms / 1000) % 60)
  const m = Math.floor((ms / 1000 / 60) % 60)
  const h = Math.floor((ms / 1000 / 60 / 60) % 60)
  const d = Math.floor((ms / 1000 / 60 / 60 / 24) % 60)

  const seconds = `${s}`.padStart(2, '0')
  const minutes = `${m}`.padStart(2, '0')
  const hours = `${h}`.padStart(2, '0')
  const days = `${d}`.padStart(2, '0')

  return `${days} ${hours}:${minutes}:${seconds}`
}
