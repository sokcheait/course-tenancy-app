<template>
    <nav class="flex-1 px-2 py-4 space-y-2">
        <component
            v-for="(menu, i) in menus"
            :key="i"
            :is="menu.items?.length ? SidebarDropdown : SidebarItem"
            v-bind="menu"
        />
    </nav>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

import SidebarItem from './SidebarItem.vue'
import SidebarDropdown from './SidebarDropdown.vue'

import {
    HomeIcon,
    UserGroupIcon,
    CogIcon,
    ServerIcon,
    KeyIcon,
    UsersIcon,
} from '@heroicons/vue/24/outline'

const page = usePage()

const isActive = (href) => page.url === href

const menus = computed(() => [
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: HomeIcon,
        active: isActive('/dashboard')
    },
    {
        title: 'Domain',
        href: '/domains',
        icon: ServerIcon,
        active: page.url.startsWith('/domains')
    },
    {
        title: 'User',
        href: '/admin/users',
        icon: UsersIcon,
        active: page.url.startsWith('/admin/users')
    },
    {
        title: 'Role',
        href: '/admin/roles',
        icon: KeyIcon,
        active: page.url.startsWith('/admin/roles')
    },

    // {
    //     title: 'Domain',
    //     icon: UserGroupIcon,
    //     active: page.url.startsWith('/domains'),
    //     items: [
    //         { label: 'List', href: '/domains' },
    //     ]
    // },
    // {
    //     title: 'Settings',
    //     href: '/settings',
    //     icon: CogIcon,
    //     active: isActive('/settings')
    // }
])
</script>