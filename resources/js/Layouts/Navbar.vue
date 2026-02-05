<template>
    <header class="relative bg-white dark:bg-darker border-b dark:border-primary-darker">
        <div class="flex items-center justify-between px-4 py-2">
            <a href="/" class="text-xl font-bold tracking-wider uppercase text-primary-dark dark:text-light">
                Sok-Chea
            </a>

            <!-- Desktop actions -->
            <nav class="hidden md:flex items-center space-x-2">

                <!-- Dark mode toggle -->

                <!-- <button
                    @click="toggleTheme"
                    class="relative w-12 h-6 rounded-full bg-primary-100 dark:bg-primary-lighter"
                >
                    <span
                        class="absolute top-0 left-0 w-6 h-6 rounded-full transition-transform"
                        :class="isDark ? 'translate-x-6 bg-primary-darker' : 'bg-white'"
                    />
                </button> -->

                <!-- Notifications -->

                <div class="p-2 rounded-full transition-colors bg-primary-50 text-primary-lighter hover:bg-primary-100 dark:bg-dark dark:hover:bg-primary-dark">
                	<BellIcon class="w-5 h-5" />
                </div>

                <Dropdown align="right" width="48">
                    <template #trigger>
                        <div class="cursor-pointer p-2 rounded-full transition-colors bg-primary-50 text-primary-lighter hover:bg-primary-100 dark:bg-dark dark:hover:bg-primary-dark">
                            <Cog6ToothIcon class="w-5 h-5" />
                        </div>
                    </template>
                    <template #content>
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Settings Account
                        </div>
                    </template>
                </Dropdown>

                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-primary-300 transition">
                            <img class="h-8 w-8 rounded-full object-cover text-primary" :src="$page.props.auth.user.profile_photo_url" :alt="$page.props.auth.user.name">
                        </button>

                        <span v-else class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                {{ $page.props.auth.user.name }}

                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Manage Account
                        </div>

                        <DropdownLink :href="route('profile.show')">
                            Profile
                        </DropdownLink>

                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures" :href="route('api-tokens.index')">
                            API Tokens
                        </DropdownLink>

                        <div class="border-t border-gray-200" />

                        <!-- Authentication -->
                        <form @submit.prevent="logout">
                            <DropdownLink as="button">
                                Log Out
                            </DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </nav>
        </div>
    </header>
</template>

<script setup>
import { ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import { onClickOutside } from '@vueuse/core'
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';

import {
    Bars3Icon,
    BellIcon,
    Cog6ToothIcon,
    MagnifyingGlassIcon,
    UserCircleIcon
} from '@heroicons/vue/24/outline'


/* user */
const user = usePage().props.auth.user

/* state */
const isMobileMainMenuOpen = ref(false)
const userMenuOpen = ref(false)
const isDark = ref(false)

/* refs */
const userMenuRef = ref(null)

/* click outside */
onClickOutside(userMenuRef, () => {
    userMenuOpen.value = false
})

/* methods */
const toggleUserMenu = () => {
    userMenuOpen.value = !userMenuOpen.value
}

const toggleTheme = () => {
    isDark.value = !isDark.value
    document.documentElement.classList.toggle('dark', isDark.value)
}

const logout = () => {
    router.post(route('admin.logout'));
}
</script>
