// utils/employee.ts

// Ambil inisial dari nama
export const getInitials = (name: string): string => {
  return name
    .trim()
    .split(/\s+/)
    .map(word => word[0] || '')
    .join('')
    .toUpperCase()
    .slice(0, 2)
}

// Generate warna avatar berdasarkan nama
export const getAvatarColor = (name: string): string => {
  const colors = [
    'from-blue-500 to-purple-600',
    'from-green-500 to-teal-600',
    'from-pink-500 to-red-600',
    'from-yellow-500 to-orange-600',
    'from-indigo-500 to-blue-600',
    'from-purple-500 to-pink-600',
    'from-teal-500 to-green-600',
    'from-orange-500 to-red-600'
  ]

  const hash = Array.from(name).reduce(
    (acc, char) => acc + char.charCodeAt(0),
    0
  )
  return colors[hash % colors.length]
}
