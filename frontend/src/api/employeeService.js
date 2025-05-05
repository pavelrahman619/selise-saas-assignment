// src/api/employeeService.js
import axiosInstance from './axiosInstance';

export default {
    getAll(params) {
        return axiosInstance.get('/employees', { params })
    },
    create(data) {
        return axiosInstance.post('/employees', data)
    },
    update(id, data) {
        return axiosInstance.put(`/employees/${id}`, data)
    },
    delete(id) {
        return axiosInstance.delete(`/employees/${id}`)
    },
}
