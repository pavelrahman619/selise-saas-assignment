// src/stores/useEmployeeStore.js
import { defineStore } from 'pinia'
import employeeService from '../api/employeeService'

export const useEmployeeStore = defineStore('employee', {
    state: () => ({
        employees: [],
        pagination: {},
        loading: false,
        filters: {
            search: '',
            department_id: null,
            min_salary: null,
            max_salary: null,
            sort: 'joined_date',
            order: 'asc',
            page: 1,
        },
    }),
    actions: {
        async fetchEmployees() {
            this.loading = true
            try {
                const res = await employeeService.getAll(this.filters)
                this.employees = res.data.data
                this.pagination = res.data
            } catch (err) {
                console.error(err)
            } finally {
                this.loading = false
            }
        },
        setFilter(key, value) {
            this.filters[key] = value
            this.fetchEmployees()
        },
        setPage(page) {
            this.filters.page = page
            this.fetchEmployees()
        },
    },
})
