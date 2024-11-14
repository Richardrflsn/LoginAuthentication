<template>
    <div class="container">
        <h1>Home Page</h1>
        <div v-if="useAuth.user">
            <h2>Welcome, {{ useAuth.user.name }}</h2>
            <p>Email: {{ useAuth.user.email }}</p>
        </div>
        <div v-else>
            <p>No Data</p>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { authStore } from '../stores/authstore';

const useAuth = authStore(); // Initialize the store instance

onMounted(async () => {
    await useAuth.getUser();  // Fetch the user data on component mount
});
</script>
