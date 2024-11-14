<template>
    <div class="container">
        <div class="col-md-6 m-auto">
            <h1>Reset Password</h1>

            <div class="my-3" style="color: red;">
                {{ errorMessage }}
            </div>

            <div class="mt-3">
                <form @submit.prevent="submitReset">
                    <div class="mb-3">
                        <label for="FormControlEmail" class="form-label">Password</label>
                        <input type="password" class="form-control" id="FormControlEmail" placeholder="name@example.com" v-model="form.password">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="FormControlPassword" placeholder="*****" v-model="form.password_confirmation">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary mb-3">Reset</button>
                        <router-link to="/forgot">Forgot Password?</router-link>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';

import { useRouter, useRoute } from 'vue-router';

import { authStore } from '../stores/authstore';

const route = useRoute();
const router = useRouter();
const useAuth = authStore();

const form = ref({
    token: route.params.token,
    email: route.query.email,
    password: '',
    password_confirmation: ''
});

const errorMessage = ref('');

const submitReset = async () => {
    try {
        await useAuth.getToken();
        await axios.post('/reset-password', {
            token: form.value.token,
            email: form.value.email,
            password: form.value.password,
            password_confirmation: form.value.password_confirmation
        }).then(response => {
            if (response.status != null) {
                router.push('/login'); 
            }
            console.log(response.data.message);
            errorMessage.value = response.data.message;
        });
        router.push('/login'); 
        
    } catch (error) {
        // Handle authentication error
        alert(error.response.data.message);
        if (error.response && error.response.status === 422) {
            errorMessage.value = "Invalid email or password.";
        } else {
            errorMessage.value = "An error occurred. Please try again later.";
        }
    }
};

</script>