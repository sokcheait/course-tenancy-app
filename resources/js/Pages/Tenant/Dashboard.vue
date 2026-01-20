<script setup>
import AppLayout from '@/Layouts/Tenant/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Head, Link, useForm,usePage } from '@inertiajs/vue3';
const { props } = usePage()
const user = props.auth.user
const tenant = props.auth.tenant
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
					    <h1>Welcome, {{ user.name }}</h1>
					    <p>Tenant ID: {{ tenant.id }}</p>
					</div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
