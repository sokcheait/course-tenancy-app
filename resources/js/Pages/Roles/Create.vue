<script setup>
import { reactive } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/Forms/TextInput.vue';
import ToggleSwitch from '@/Components/Forms/ToggleSwitch.vue';
import { HomeIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import SaveButton from '@/Components/Actions/SaveButton.vue';
import BackButton from '@/Components/Actions/BackButton.vue';
import PermissionSelector from './PermissionSelector.vue'
import { useToast } from "vue-toastification";

const props = defineProps({
    list_permissions: Object
})

const form = useForm({
    name: '',
    is_active: false,
    permissions: {}
})
const toast = useToast();

const submit = () => {
    form.post(route('admin.roles.store'),{
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
    <AppLayout title="Roles">
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">
                        <Link :href="route('admin.roles.index')" preserve-state>
                            Home
                        </Link>
                    </span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Role</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Create</span>
                </div>
            </div>
        </template>

        <div class="py-2">
            <div class="px-0">
                <div class="bg-white shadow rounded-lg overflow-hidden p-4">
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <text-input 
                                label="Name" 
                                v-model="form.name"
                                type="text"
                                :errors="form.errors.name"
                                :required="true"
                                placeholder="Please input name" 
                            />
                            <ToggleSwitch v-model="form.is_active" label="Status" :errors="form.errors.is_active" />
                        </div>

                        <!-- Permissions -->

                        <PermissionSelector
                            v-model="form.permissions"
                            :permissions="list_permissions"
                        />
                        
                        <div class="flex py-4 justify-end text-center">
                            <save-button @click="submit" class="" />
                            <back-button label="Back" />
                        </div>
                    </form>        
                </div>
            </div>
        </div>
    </AppLayout>
</template>