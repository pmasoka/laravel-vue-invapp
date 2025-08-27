import type { PageProps as InertiaPageProps } from '@inertiajs/core'

export interface PageProps extends InertiaPageProps {
  auth: {
    user: {
      id: number
      name: string
      email: string
    } | null
  }
  ziggy: Record<string, any>
  sidebarOpen: boolean
  name: string
  quote: {
    message: string
    author: string
  }
  flash: {
    message?: string
  }
}
