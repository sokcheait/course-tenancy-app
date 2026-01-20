<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'

const form = useForm({
    company_name: '',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submit = () => {
    form.post('/domains')
}
</script>

<template>
    <AppLayout title="Domain">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Domain
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="max-w-xl mx-auto p-6 bg-white shadow rounded">
                        <h1 class="text-xl font-bold mb-4">Add Domain</h1>

                        <form @submit.prevent="submit" class="space-y-4">
                            <div>
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
                            <div>
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
                            <div>
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
                            <div>
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
                            <div>
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

                            <button
                              class="bg-blue-600 text-white px-4 py-2 rounded"
                              :disabled="form.processing"
                            >
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>