<template>

    <AppAside v-if="$route.meta.requiresAuth" />
    <router-view />
</template>

<script>
import AppAside from '@/layouts/components/AppAside.vue'
export default {
    name: 'App',
    components: {
        AppAside
    }
}
</script>