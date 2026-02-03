<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import Sidebar from "./Sidebar.vue"
import Navbar from "./Navbar.vue"

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('admin.logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <Banner />

        <div class="h-screen antialiased text-gray-900 dark:bg-dark dark:text-light">
            <aside class="fixed inset-y-0 left-0 z-40 hidden w-64 bg-white border-r dark:border-primary-darker dark:bg-darker md:block">
                <div class="flex flex-col h-full">
                    <Sidebar />
                </div>
            </aside>
            <div class="ml-0 md:ml-64 h-full">
                <div class="fixed top-0 right-0 left-0 md:left-64 z-30 h-16 bg-white dark:bg-darker">
                    <Navbar />
                    <header v-if="$slots.header" class="bg-white border-b">
                        <div class="">
                            <slot name="header" />
                        </div>
                    </header>
                </div>

                <div class="pt-16 h-full overflow-y-auto">
                    <main class="p-4">
                        <slot />
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
