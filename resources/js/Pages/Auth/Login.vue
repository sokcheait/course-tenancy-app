<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('admin.login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Log in" />
    <div class="flex flex-col items-center justify-center min-h-screen p-4 space-y-4 antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
        <a href="" class="inline-block mb-6 text-3xl font-bold tracking-wider uppercase text-primary-dark dark:text-light">
            K-WD
        </a>
        <main class="">
            <div class="w-full max-w-sm px-4 py-6 space-y-6 bg-white rounded-md dark:bg-darker">
                <h1 class="text-xl font-semibold text-center">Login</h1>
                <form @submit.prevent="submit" class="space-y-6">
                    <input v-model="form.email" class="w-full px-4 py-2 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100 dark:focus:ring-primary-darker" type="email" name="email" placeholder="Email address" required />
                    <input v-model="form.password" class="w-full px-4 py-2 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100 dark:focus:ring-primary-darker" type="password" name="password" placeholder="Password" required />

                    <div class="flex items-center justify-between">
                        <!-- Remember me toggle -->
                        <label class="flex items-center">
                            <div class="relative inline-flex items-center">
                                <input type="checkbox" name="remembr_me" class="w-10 h-4 transition bg-gray-200 border-none rounded-full shadow-inner outline-none appearance-none toggle checked:bg-primary-light disabled:bg-gray-200 focus:outline-none"/>
                                <span class="absolute top-0 left-0 w-4 h-4 transition-all transform scale-150 bg-white rounded-full shadow-sm"></span>
                            </div>
                            <span class="ml-3 text-sm font-normal text-gray-500 dark:text-gray-400">Remember me</span>
                        </label>
                        <a href="#" class="text-sm text-blue-600 hover:underline">Forgot Password?</a>
                    </div>
                    <div class="">
                        <button type="submit" class="w-full px-4 py-2 font-medium text-center text-white transition-colors duration-200 rounded-md bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:focus:ring-offset-darker">
                            Login
                        </button>
                    </div>
                </form>
                <div class="flex items-center justify-center space-x-2 flex-nowrap">
                    <span class="w-20 h-px bg-gray-300"></span>
                    <span>OR</span>
                    <span class="w-20 h-px bg-gray-300"></span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    Don't have an account yet? <a href="#" class="text-blue-600 hover:underline">Register</a>
                </div>
            </div>
        </main>
    </div>
</template>
