<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import SaveButton from '@/Components/Actions/SaveButton.vue';
import BackButton from '@/Components/Actions/BackButton.vue';
import {
    HomeIcon,
    ChevronRightIcon
} from '@heroicons/vue/24/outline'

const form = useForm({
    company_name: '',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submit = () => {
    form.post('admin/domains')
}
</script>

<template>
    <AppLayout title="Domain">
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">Home</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Domain</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Create</span>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="px-0">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-4 bg-white shadow rounded">
                        <h1 class="text-xl font-bold mb-4">Add Domain</h1>
                        <form @submit.prevent="submit" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="">
                                    <label class="block text-sm font-medium">Company Name</label>
                                    <input
                                        v-model="form.company_name"
                                        type="text"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="company name"
                                    />
                                    <p v-if="form.errors.company_name" class="text-red-500 text-sm">
                                        {{ form.errors.company_name }}
                                    </p>
                                </div>
                                <div class="">
                                    <label class="block text-sm font-medium">Name</label>
                                    <input
                                        v-model="form.name"
                                        type="text"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="name"
                                    />
                                    <p v-if="form.errors.name" class="text-red-500 text-sm">
                                        {{ form.errors.name }}
                                    </p>
                                </div>
                                <div class="">
                                    <label class="block text-sm font-medium">Email</label>
                                    <input
                                        v-model="form.email"
                                        type="text"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="email"
                                    />
                                    <p v-if="form.errors.email" class="text-red-500 text-sm">
                                        {{ form.errors.email }}
                                    </p>
                                </div>
                                <div class="">
                                    <label class="block text-sm font-medium">Password</label>
                                    <input
                                        v-model="form.password"
                                        type="text"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="password"
                                    />
                                    <p v-if="form.errors.password" class="text-red-500 text-sm">
                                        {{ form.errors.password }}
                                    </p>
                                </div>
                                <div class="">
                                    <label class="block text-sm font-medium">Confirm Password</label>
                                    <input
                                        v-model="form.password_confirmation"
                                        type="text"
                                        class="w-full border rounded px-3 py-2"
                                        placeholder="password_confirmation"
                                    />
                                    <p v-if="form.errors.password_confirmation" class="text-red-500 text-sm">
                                        {{ form.errors.password_confirmation }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex py-4 justify-end text-center">
                                <save-button @click="submit" class="" />
                                <back-button label="Back" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>