import type { PageProps as InertiaPageProps } from '@inertiajs/core'

export interface PageProps extends InertiaPageProps {
  auth: {
    user: {
      id: number
      name: stringz
      email: string
    } | null
  }
  ziggy: Record<string, any>
  sidebarOpen: boolean
  name: string
  quote: string
  flash: {
    message?: string
  }
}
