<template>
    <nav class="flex-1 px-2 py-4 space-y-2">
        <component
            v-for="(menu, i) in menus"
            :key="i"
            :is="menu.items?.length ? SidebarDropdown : SidebarItem"
            v-bind="menu"
            :active="isActive(menu.href)"
        />
    </nav>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import Sidebar from '@/Layouts/Sidebar/index.js'

import SidebarItem from './SidebarItem.vue'
import SidebarDropdown from './SidebarDropdown.vue'

const page = usePage()

const isActive = (href) => {
    if (!href) return false
    return page.url.startsWith(href)
}

const menus = Sidebar

</script>

// const menus = computed(() => [
//     {
//         title: 'Dashboard',
//         href: '/dashboard',
//         icon: HomeIcon,
//         active: isActive('/dashboard')
//     },
//     {
//         title: 'Domain',
//         href: '/domains',
//         icon: ServerIcon,
//         active: page.url.startsWith('/domains')
//     },
//     {
//         title: 'User',
//         href: '/admin/users',
//         icon: UsersIcon,
//         active: page.url.startsWith('/admin/users')
//     },
//     {
//         title: 'Role',
//         href: '/admin/roles',
//         icon: KeyIcon,
//         active: page.url.startsWith('/admin/roles')
//     },

//     // {
//     //     title: 'Domain',
//     //     icon: UserGroupIcon,
//     //     active: page.url.startsWith('/domains'),
//     //     items: [
//     //         { label: 'List', href: '/domains' },
//     //     ]
//     // },
//     // {
//     //     title: 'Settings',
//     //     href: '/settings',
//     //     icon: CogIcon,
//     //     active: isActive('/settings')
//     // }
// ])
