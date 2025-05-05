<template>
    <div>
        <div class="flex justify-between items-center mb-4">
            <input v-model="search" @input="onSearch" type="text" placeholder="Search by name or email" class="input" />
            <button class="btn bg-blue-600 text-white" @click="openForm()">+ New</button>
        </div>

        <div class="flex gap-4 mb-4">
            <input type="number" v-model.number="minSalary" @input="applyFilters" placeholder="Min Salary"
                class="input" />
            <input type="number" v-model.number="maxSalary" @input="applyFilters" placeholder="Max Salary"
                class="input" />
            <select v-model="departmentId" @change="applyFilters" class="input">
                <option value="">All Departments</option>
                <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
            </select>
        </div>


        <table class="w-full text-left border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Department</th>
                    <th class="p-2">Designation</th>
                    <th class="p-2">Joined</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="employee in store.employees" :key="employee.id">
                    <td class="p-2">{{ employee.name }}</td>
                    <td class="p-2">{{ employee.email }}</td>
                    <td class="p-2">{{ employee.department?.name }}</td>
                    <td class="p-2">{{ employee.detail?.designation }}</td>
                    <td class="p-2">{{ employee.detail?.joined_date }}</td>
                    <td class="p-2 flex gap-2">
                        <button class="btn bg-yellow-400" @click="openForm(employee)">Edit</button>
                        <button class="btn bg-red-500 text-white" @click="deleteEmployee(employee.id)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>

        <Pagination :pagination="store.pagination" @changePage="store.setPage" />

        <EmployeeForm v-if="showForm" :employee="selected" @close="closeForm" @saved="onSaved" />
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { onMounted } from 'vue'
import { useEmployeeStore } from '../stores/useEmployeeStore'
import EmployeeForm from './EmployeeForm.vue'
import Pagination from './Pagination.vue'
import axiosInstance from '../api/axiosInstance'
import employeeService from '../api/employeeService'
import { debounce } from 'lodash'

const store = useEmployeeStore()
store.fetchEmployees()

const showForm = ref(false)
const selected = ref(null)
const search = ref('')

function openForm(employee = null) {
    selected.value = employee
    showForm.value = true
}

function closeForm() {
    showForm.value = false
    selected.value = null
}

const debouncedSearch = debounce(() => {
    store.setFilter('search', search.value)
}, 500)

function onSearch() {
    debouncedSearch()
}

async function deleteEmployee(id) {
    if (confirm('Are you sure?')) {
        await employeeService.delete(id)
        await store.fetchEmployees()
    }
}

function onSaved() {
    store.fetchEmployees()
}

// min max salary
const minSalary = ref('')
const maxSalary = ref('')
const departmentId = ref('')
const departments = ref([])

async function fetchDepartments() {
    const res = await axiosInstance.get('/departments')
    departments.value = res.data
}

function applyFilters() {
    store.setFilter('min_salary', minSalary.value || null)
    store.setFilter('max_salary', maxSalary.value || null)
    store.setFilter('department_id', departmentId.value || null)
}

onMounted(fetchDepartments)

</script>