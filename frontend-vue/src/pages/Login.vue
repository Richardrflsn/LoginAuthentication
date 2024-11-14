<template>
    <div class="container">
        <div class="col-md-6 m-auto">
            <h1>Login Page</h1>

            <div class="my-3" style="color: red;">
                {{ errorMessage }}
            </div>

            <div class="mt-3">
                <form @submit.prevent="submitLogin">
                    <div class="mb-3">
                        <label for="FormControlEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="FormControlEmail" placeholder="name@example.com" v-model="form.email">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="FormControlPassword" placeholder="*****" v-model="form.password">
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary mb-3">Login</button>
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

import { useRouter } from 'vue-router';

import { authStore } from '../stores/authstore';

const router = useRouter();
const useAuth = authStore();

const form = ref({
    email: '',
    password: ''
});

const errorMessage = ref('');

const submitLogin = async () => {
    try {
        await useAuth.getToken();
        await axios.post('/login', {
            email: form.value.email,
            password: form.value.password
        }).then(response => {
            if (response.status === 204) {
                router.push('/'); 
            }
            console.log(response.data.message);
            errorMessage.value = response.data.message;
        });
        router.push('/'); 
        
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