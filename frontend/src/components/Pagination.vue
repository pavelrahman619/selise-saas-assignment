<template>
    <div class="flex justify-center mt-4 space-x-2 flex-wrap">
        <button class="px-3 py-1 border rounded" :disabled="!pagination.prev_page_url"
            @click="$emit('changePage', pagination.current_page - 1)">
            Prev
        </button>

        <!-- Page numbers -->
        <button v-if="pagination.current_page > 3" class="px-3 py-1 border rounded text-sm mx-1 my-1"
            @click="$emit('changePage', 1)">
            1
        </button>

        <span v-if="pagination.current_page > 3" class="mx-1">...</span>

        <button v-for="page in visiblePages" :key="page" class="px-3 py-1 border rounded text-sm mx-1 my-1"
            :class="{ 'bg-blue-500 text-white': page === pagination.current_page }" @click="$emit('changePage', page)">
            {{ page }}
        </button>

        <span v-if="pagination.current_page < pagination.last_page - 2" class="mx-1">...</span>

        <button v-if="pagination.current_page < pagination.last_page - 2"
            class="px-3 py-1 border rounded text-sm mx-1 my-1" @click="$emit('changePage', pagination.last_page)">
            {{ pagination.last_page }}
        </button>

        <button class="px-3 py-1 border rounded" :disabled="!pagination.next_page_url"
            @click="$emit('changePage', pagination.current_page + 1)">
            Next
        </button>
    </div>
</template>

<script setup>
import { computed } from 'vue'
const props = defineProps({ pagination: Object })

// Compute the range of visible pages
const visiblePages = computed(() => {
    const range = []
    const maxPagesToShow = 5
    const pagination = props.pagination
    let start = Math.max(pagination.current_page - 2, 1)
    let end = Math.min(pagination.current_page + 2, pagination.last_page)

    // Adjust range to always show at least 1 page before and after current page
    if (end - start < maxPagesToShow - 1) {
        if (start === 1) {
            end = Math.min(start + maxPagesToShow - 1, pagination.last_page)
        } else if (end === pagination.last_page) {
            start = Math.max(end - maxPagesToShow + 1, 1)
        }
    }

    for (let i = start; i <= end; i++) {
        range.push(i)
    }
    return range
})
</script>
