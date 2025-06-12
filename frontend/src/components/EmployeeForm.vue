<template>
    <div class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center">
        <div class="bg-white p-6 w-96 rounded">
            <h2 class="text-lg font-bold mb-4">{{ employee?.employee_id ? 'Edit' : 'Create' }} Employee</h2>
            
            <form @submit.prevent="submit">
                <!-- Name -->
                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                    <input v-model="form.name" id="name" class="input" placeholder="Full name" required />
                </div>

                <!-- Email -->
                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input v-model="form.email" id="email" class="input" type="email" placeholder="Email address" required />
                </div>

                <!-- Designation -->
                <div class="mb-2">
                    <label for="designation" class="block text-sm font-medium text-gray-700">Designation</label>
                    <input v-model="form.designation" id="designation" class="input" placeholder="Job title" required />
                </div>

                <!-- Department -->
                <div class="mb-2">
                    <label for="department_id" class="block text-sm font-medium text-gray-700">Department</label>
                    <select v-model="form.department_id" id="department_id" class="input" required>
                        <option value="">Select a department</option>
                        <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                            {{ dept.name }}
                        </option>
                    </select>
                </div>

                <!-- Address -->
                <div class="mb-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input v-model="form.address" id="address" class="input" placeholder="Address" required />
                </div>

                <!-- Salary -->
                <div class="mb-2">
                    <label for="salary" class="block text-sm font-medium text-gray-700">Salary</label>
                    <input v-model="form.salary" id="salary" class="input" type="number" placeholder="e.g., 50000" />
                </div>

                <!-- Joined Date -->
                <div class="mb-4">
                    <label for="joined_date" class="block text-sm font-medium text-gray-700">Date of Joining</label>
                    <input v-model="form.joined_date" id="joined_date" class="input" type="date" required />
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-2">
                    <button class="btn bg-gray-300" @click="$emit('close')" type="button">Cancel</button>
                    <button class="btn bg-blue-600 text-white" type="submit">{{ employee?.employee_id ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits, onMounted } from 'vue'
import axiosInstance from '../api/axiosInstance'
import employeeService from '../api/employeeService'

const props = defineProps({ employee: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
    name: '',
    email: '',
    designation: '',
    department_id: '',
    address: '',
    salary: '',
    joined_date: '',
})

const departments = ref([])

onMounted(async () => {
    const res = await axiosInstance.get('/departments')
    departments.value = res.data
})

watch(() => props.employee, (e) => {
    if (e) {
        form.value = {
            name: e.name,
            email: e.email,
            designation: e.detail?.designation || '',
            department_id: e.department?.id || '',
            address: e.detail?.address || '',
            salary: e.detail?.salary || '',
            joined_date: e.detail?.joined_date || '',
        }
    } else {
        form.value = {
            name: '',
            email: '',
            designation: '',
            department_id: '',
            address: '',
            salary: '',
            joined_date: '',
        }
    }
}, { immediate: true })

async function submit() {
    console.log('Updating employee with ID:', props.employee?.employee_id);

    try {
        if (props.employee?.employee_id) {
            await employeeService.update(props.employee.employee_id, form.value)
        } else {
            await employeeService.create(form.value)
        }
        emit('saved')
        emit('close')
    } catch (err) {
        alert('Failed to save employee.')
        console.error(err)
    }
}
</script>
