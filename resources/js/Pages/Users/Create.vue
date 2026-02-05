<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import DataTable from '@/Components/DataTable/BaseTable.vue'
import ActionDropdown from '@/Components/DataTable/ActionDropdown.vue'
import SaveButton from '@/Components/Actions/SaveButton.vue';
import BackButton from '@/Components/Actions/BackButton.vue';
import {
    HomeIcon,
    ChevronRightIcon
} from '@heroicons/vue/24/outline'
import TextInput from '@/Components/Forms/TextInput.vue';
import SelectInput from '@/Components/Forms/SelectInput.vue';
import ToggleSwitch from '@/Components/Forms/ToggleSwitch.vue';
import { useToast } from "vue-toastification";

defineProps({
    roles: Array
})

const form = useForm({
	first_name:'',
	last_name:'',
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_id: null,
    phone_number:null,
    date_of_birth:null,
    nationality:'',
    marital_status:'',
    address_line_1: '',
    address_line_2: '',
    city: '',
    state: '',
    postal_code: '',
    country: '',

});

const toast = useToast();

const submit = () => {
    form.post(route('admin.users.store'),{
        preserveScroll: true,
        preserveState: true,
        onSuccess: () => {
            toast.success("Role created successfully.");
        },
        onError: (errors) => {
            toast.error("Role created error.");
            console.error(errors)
        }
    });
}

</script>

<template>
    <AppLayout title="User">
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">Home</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">User</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Create</span>
                </div>
            </div>
        </template>
        <div class="py-4">
            <h2 class="text-xl font-semibold mb-4">Create New User</h2>
            <div class="px-2 shadow rounded-md">
            	<form @submit.prevent="submit" class="">
	                <div class="grid grid-cols-2 gap-4">
	                	<text-input label="First Name" v-model="form.first_name" placeholder="Enter first name" :required="true" />
    					<text-input label="Last Name" v-model="form.last_name" placeholder="Enter last name" :required="true" />
	                    <text-input label="Name" v-model="form.name" type="text" :errors="form.errors.name" :required="true" placeholder="Enter name" />
	                    <select-input
					        label="Gender"
					        v-model="form.gender"
					        :options="[
					            { label: 'Male', value: 'male' },
					            { label: 'Female', value: 'female' },
					            { label: 'Other', value: 'other' }
					        ]"
					        placeholder="Select gender"
					    />
	                    <text-input label="Email" v-model="form.email" type="text" :errors="form.errors.email" :required="true" placeholder="Enter email" />
	                    <text-input label="Password" v-model="form.password" type="text" :errors="form.errors.password" :required="true" placeholder="Enter password" />
	                    <text-input label="Confirm Password" v-model="form.password_confirmation" type="text" :errors="form.errors.password_confirmation" :required="true" placeholder="Enter confirm password" />
	                    <select-input label="Role" v-model="form.role_id" :options="roles.map(role => ({ label: role.name, value: role.id }))" :required="true" />
	                    <text-input label="Date of Birth" v-model="form.date_of_birth" type="date" />
					    <text-input label="Phone Number" v-model="form.phone_number" placeholder="Enter phone number" />
					    <text-input label="Nationality" v-model="form.nationality" placeholder="Enter nationality" />
					    <text-input label="Marital Status" v-model="form.marital_status" placeholder="Enter marital status" />

					    <text-input label="Address Line 1" v-model="form.address_line_1" placeholder="Enter address line 1" />
					    <text-input label="Address Line 2" v-model="form.address_line_2" placeholder="Enter address line 2" />
					    <text-input label="City" v-model="form.city" placeholder="Enter city" />
					    <text-input label="State" v-model="form.state" placeholder="Enter state" />
					    <text-input label="Postal Code" v-model="form.postal_code" placeholder="Enter postal code" />
					    <text-input label="Country" v-model="form.country" placeholder="Enter country" />

	                </div>
	                <div class="flex py-4 justify-end text-center">
                        <save-button @click="submit" class="" />
                        <back-button label="Back" />
                    </div>
	            </form>
            </div>
        </div>
    </AppLayout>
</template>