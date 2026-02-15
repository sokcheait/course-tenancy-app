<template>
	<Dropdown align="right" width="48">
        <template #trigger>
            <div class="cursor-pointer p-2 rounded-full transition-colors bg-primary-50 text-primary-lighter hover:bg-primary-100 dark:bg-dark dark:hover:bg-primary-dark">
                <Cog6ToothIcon class="w-5 h-5" />
            </div>
        </template>
        <template #content>
            <div class="block px-4 py-2 text-xs text-gray-400 border-b">
                Settings Account
            </div>
            <nav class="flex-1 px-2 py-4 space-y-2">
		        <component
		            v-for="(setting, i) in settings"
		            :key="i"
		            :is="SidebarItem"
		            v-bind="setting"
		            :active="isActive(setting.href)"
		        />
		    </nav>
        </template>
    </Dropdown>
</template>
<script setup>
import { ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import Dropdown from '@/Components/Dropdown.vue';
import Settings from '@/Layouts/Settings/index.js'
import SidebarItem from '@/Layouts/SidebarItem.vue'
import {
    Cog6ToothIcon,
} from '@heroicons/vue/24/outline'

const page = usePage()

const isActive = (href) => {
    if (!href) return false
    return page.url.startsWith(href)
}

const settings = Settings

</script>