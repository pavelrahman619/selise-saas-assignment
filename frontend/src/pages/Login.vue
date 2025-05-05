<template>
  <div class="max-w-md mx-auto mt-20 p-6 border rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Login</h2>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" class="input" required />
      <input v-model="password" type="password" placeholder="Password" class="input mt-2" required />
      <button class="btn mt-4 w-full" type="submit">Login</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'
import axiosInstance from '../api/axiosInstance'

const email = ref('')
const password = ref('')
const auth = useAuthStore()
const router = useRouter()

async function login() {
  try {
    // Request the CSRF token first, don't include the token header here
    await axiosInstance.get('/sanctum/csrf-cookie')

    // After the CSRF token is set, attempt to log in
    const response = await axios.post('/api/login', {
      email: email.value,
      password: password.value
    })

  // Handle login success
    router.push('/')
  } catch (err) {
    alert('Login failed. Please check your credentials.')
  }
}
</script>