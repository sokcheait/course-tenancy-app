<script setup>
import { onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { useForm } from '@inertiajs/inertia-vue3'
import TextInput from '@/Components/Forms/TextInput.vue'
import ToggleSwitch from '@/Components/Forms/ToggleSwitch.vue'
import { HomeIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import SaveButton from '@/Components/Actions/SaveButton.vue'
import BackButton from '@/Components/Actions/BackButton.vue'
import PermissionSelector from './PermissionSelector.vue'

/* =========================
   Props
========================= */
const props = defineProps({
    list_permissions: Object,
    role: Object,
    existing: Array
})

/* =========================
   Form
========================= */
const form = useForm({
    name: props.role.name,
    is_active: props.role.is_active,
    permissions: props?.existing, // UI state
})

/* =========================
   Submit
========================= */
const submit = () => {
    form
        .transform(data => ({
            ...data,
        }))
        .put(route('admin.roles.update', props.role.id))
}
</script>

<template>
    <AppLayout title="Roles">
        <!-- Header -->
        <template #header>
            <div class="flex w-full items-center p-2">
                <div class="flex items-center text-sm text-gray-600 dark:text-white">
                    <HomeIcon class="w-4 h-4 mx-1" />
                    <span class="mx-1 mt-[3px]">Home</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Role</span>
                    <ChevronRightIcon class="w-4 h-4 mx-1 mt-[1px]" />
                    <span class="mx-1 mt-[3px]">Edit</span>
                </div>
            </div>
        </template>

        <div class="bg-white shadow rounded-lg p-4">
            <form @submit.prevent="submit" class="space-y-4">

                <!-- Basic info -->
                <div class="grid grid-cols-2 gap-4">
                    <TextInput
                        label="Name"
                        v-model="form.name"
                        :errors="form.errors.name"
                        required
                    />
                    <ToggleSwitch
                        v-model="form.is_active"
                        label="Status"
                        :errors="form.errors.is_active"
                    />
                </div>

                <PermissionSelector
                    v-model="form.permissions"
                    :permissions="list_permissions"
                    :existing="props.role?.permissions || []"
                />

                <!-- Actions -->
                <div class="flex justify-end gap-2 pt-4">
                    <save-button @click="submit" class="" />
                    <BackButton />
                </div>
            </form>
        </div>
    </AppLayout>
</template>