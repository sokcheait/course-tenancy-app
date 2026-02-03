<script setup>
import { reactive } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import TextInput from '@/Components/Forms/TextInput.vue';
import ToggleSwitch from '@/Components/Forms/ToggleSwitch.vue';
import { HomeIcon, ChevronRightIcon } from '@heroicons/vue/24/outline'
import SaveButton from '@/Components/Actions/SaveButton.vue';
import BackButton from '@/Components/Actions/BackButton.vue';

const props = defineProps({
    list_permissions: Object
})

// Form using Inertia
const form = useForm({
    name: '',
    is_active: false,
    permissions: {}
})

// --- Helper Functions ---

// Ensure nested array exists

function getPermissionModel(groupName, key) {
    if (!form.permissions[groupName]) form.permissions[groupName] = {}
    if (!form.permissions[groupName][key]) form.permissions[groupName][key] = []
    return form.permissions[groupName][key]
}

// Get array of permission keys (third-level object)
function getPermissionKeys(groupName, key) {
    return Object.keys(props.list_permissions[groupName][key] || {})
}

// Check if parent checkbox is fully selected
function isGroupSelected(groupName, key) {
    const perms = getPermissionModel(groupName, key)
    const allKeys = getPermissionKeys(groupName, key)
    return perms.length === allKeys.length
}

// Check if parent checkbox is partially selected
function isGroupPartial(groupName, key) {
    const perms = getPermissionModel(groupName, key)
    const allKeys = getPermissionKeys(groupName, key)
    return perms.length > 0 && perms.length < allKeys.length
}

// Toggle all child permissions
function toggleGroup(groupName, key) {
    const allKeys = getPermissionKeys(groupName, key)
    const model = getPermissionModel(groupName, key)
    if (isGroupSelected(groupName, key)) {
        form.permissions[groupName][key] = []
    } else {
        form.permissions[groupName][key] = [...allKeys]
    }
}

// Toggle individual permission (child)
function togglePermission(groupName, key, permissionKey, checked) {
    const model = getPermissionModel(groupName, key)
    if (checked) {
        if (!model.includes(permissionKey)) model.push(permissionKey)
    } else {
        const index = model.indexOf(permissionKey)
        if (index > -1) model.splice(index, 1)
    }
}
function getFlattenedPermissions() {
    const result = {}
    for (const groupName in form.permissions) {
        result[groupName] = []
        const modules = form.permissions[groupName]
        for (const moduleName in modules) {
            const perms = modules[moduleName]
            perms?.forEach(p => {
                // Flatten format: group.module.permission
                result[groupName].push(`${groupName}.${p}`)
            })
        }
    }
    return result
}

const submit = () => {
    form.permissions = getFlattenedPermissions()
    form.post(route('admin.roles.store'),{
        onSuccess: () => {
            console.log('Role created', payload)
        },
        onError: (errors) => {
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
                    <span class="mx-1 mt-[3px]">Home</span>
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
                                required
                                placeholder="Please input name" 
                            />
                            <ToggleSwitch v-model="form.is_active" label="Status" :errors="form.errors.is_active" />
                        </div>

                        <!-- Permissions -->
                        <div class="grid grid-cols-1 gap-4">
                            <div v-for="(groupPermissions, groupName, index) in props.list_permissions" :key="index" class="border rounded">
                                <div class="flex items-center mb-2 px-1 py-3 shadow">
                                    <label class="ml-1 font-medium capitalize">{{ groupName }}</label>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-3">
                                    <div v-for="(permissionsObj, key) in groupPermissions" :key="key" class="w-full py-2">
                                        <!-- Parent Permission -->
                                        <div class="w-full flex items-center border-b py-1">
                                            <input 
                                                type="checkbox" 
                                                class="form-checkbox h-4 w-4" 
                                                :checked="isGroupSelected(groupName, key)"
                                                :indeterminate="isGroupPartial(groupName, key)"
                                                @change="toggleGroup(groupName, key)"
                                            />
                                            <label class="ml-2 font-semibold capitalize">{{ key }}</label>
                                        </div>

                                        <!-- Child Permissions -->
                                        <div v-for="permission in getPermissionKeys(groupName, key)" :key="permission" class="flex items-center px-4 py-1">
                                            <input type="checkbox" class="form-checkbox h-4 w-4" :checked="getPermissionModel(groupName, key).includes(permission)" @change="e => togglePermission(groupName, key, permission, e.target.checked)" />
                                            <label class="ml-2">{{ permission }}</label>
                                        </div>
                                    </div>
                                </div>
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
    </AppLayout>
</template>