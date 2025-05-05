// src/api/productsApi.ts
import axiosInstance from './axiosInstance';

export const getProducts = () => axiosInstance.get('/products')
export const getProduct = (id: number) => axiosInstance.get(`/products/${id}`)
export const createProduct = (data: any) => axiosInstance.post('/products', data)
export const updateProduct = (id: number, data: any) => axiosInstance.put(`/products/${id}`, data)
export const deleteProduct = (id: number) => axiosInstance.delete(`/products/${id}`)
