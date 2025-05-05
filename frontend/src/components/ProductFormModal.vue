<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded shadow w-96">
      <h2 class="text-lg font-bold mb-4">{{ product?.id ? 'Edit' : 'Create' }} Product</h2>
      <form @submit.prevent="submitForm">
        <input v-model="form.name" placeholder="Name" class="input mb-2" required />
        <input v-model="form.description" placeholder="Description" class="input mb-2" required />
        <input v-model.number="form.price" placeholder="Price" class="input mb-2" required type="number" step="0.1" />
        <input v-model.number="form.stock" placeholder="Stock" class="input mb-4" required type="number" />

        <div class="flex justify-end gap-2">
          <button type="button" @click="$emit('close')" class="btn bg-gray-300 text-black">Cancel</button>
          <button type="submit" class="btn bg-blue-600 text-white">{{ product?.id ? 'Update' : 'Create' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, defineProps, defineEmits } from 'vue'
import axiosInstance from '../api/axiosInstance'

const props = defineProps({ product: Object })
const emit = defineEmits(['close', 'saved'])

const form = ref({
  name: '',
  description: '',
  price: 0,
  stock: 0
})

watch(() => props.product, (newProduct) => {
  form.value = newProduct ? { ...newProduct } : { name: '', price: 0 }
}, { immediate: true })

async function submitForm() {
  try {
    if (props.product?.id) {
      await axiosInstance.put(`/products/${props.product.id}`, form.value)
    } else {
      await axiosInstance.post('/products', form.value)
    }
    emit('saved')
    emit('close')
  } catch (err) {
    alert('Save failed.')
  }
}
</script>
