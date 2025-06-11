// composables/usePermissions.ts
import { useUserStore } from '@/stores/userStore'
import { computed } from 'vue'

export function usePermissions() {
  const userStore = useUserStore()

  const permissions = computed(() => userStore.permissions)


  function hasPermission(permission: string): boolean {
    return permissions.value.includes(permission)
  }

  function hasAnyPermission(requiredPermissions: string[]): boolean {
    return requiredPermissions.some(p => hasPermission(p))
  }

  return {
    hasPermission,
    hasAnyPermission,
    permissions,
  }
}