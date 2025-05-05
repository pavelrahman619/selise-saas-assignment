<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Products</h1>
    <button class="btn mb-4" @click="openCreateModal">+ New Product</button>

    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Name</th>
          <th class="p-2">Price</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td class="p-2">{{ product.name }}</td>
          <td class="p-2">{{ product.price }}</td>
          <td class="p-2">
            <button class="text-blue-500" @click="editProduct(product)">Edit</button>
          </td>
        </tr>
      </tbody>
    </table>

    <ProductFormModal v-if="showModal" :product="selectedProduct" @close="closeModal" @saved="fetchProducts" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ProductFormModal from '../components/ProductFormModal.vue'
import axiosInstance from '../api/axiosInstance'

const products = ref([])
const showModal = ref(false)
const selectedProduct = ref(null)

async function fetchProducts() {
  const res = await axiosInstance.get('/products')
  products.value = res.data
}

function openCreateModal() {
  selectedProduct.value = null
  showModal.value = true
}

function editProduct(product) {
  selectedProduct.value = { ...product }
  showModal.value = true
}

function closeModal() {
  showModal.value = false
}

onMounted(fetchProducts)
</script>