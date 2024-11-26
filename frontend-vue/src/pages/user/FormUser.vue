<template>
    <div class="container">
        <div class="col-md-6 m-auto">
            <h1>Create User</h1>

            <div class="my-3" style="color: red;">
                {{ errorMessage }}
            </div>

            <div class="mt-3">
                <form @submit.prevent="submitCreate">
                    <div class="mb-3">
                        <label for="FormControlName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="FormControlName" placeholder="Your name"
                            v-model="form.name">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="FormControlEmail" placeholder="name@example.com"
                            v-model="form.email">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlPassword" class="form-label">Password</label>
                        <input type="password" class="form-control" id="FormControlPassword" placeholder="*****"
                            v-model="form.password">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlPasswordConfirmation" class="form-label">Password confirmation</label>
                        <input type="password" class="form-control" id="FormControlPasswordConfirmation"
                            placeholder="*****" v-model="form.password_confirmation">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlPhoto" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="FormControlPhoto" @change="onChangeFile">
                    </div>

                    <div v-if="img">
                        <img :src="imgPreview" width="100" height="100" alt="">
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary m-3" v-if="!isProcess">Save</button>
                        <button type="submit" class="btn btn-primary m-3" v-if="!isProcess" disabled>Loading</button>
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

import { authStore } from '../../stores/authstore';

const router = useRouter();
const useAuth = authStore();
const img = ref(null);
const imgPreview = ref(null);

const form = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    file: '',
});

const errorMessage = ref('');
const isProcess = ref(false);

const onChangeFile = (event) => {
    // Ensure a file is selected
    if (!event.target.files || event.target.files.length === 0) {
        return;
    }

    // Get the selected file
    img.value = event.target.files[0];

    // Validate file type (JPEG, PNG, GIF)
    if (!/\.(jpe?g|png|gif)$/i.test(img.value.name)) {
        alert("Invalid file type. Please select a JPEG, PNG, or GIF image.");
        img.value = null;
        return;
    }

    // Initialize FileReader to read the file
    const reader = new FileReader();
    reader.addEventListener("load", () => {
        imgPreview.value = reader.result; // Set the preview data
    });

    // Read the file as a data URL
    reader.readAsDataURL(img.value);
};

const submitCreate = async () => {
    isProcess.value = true;

    const config = {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }

    // Prepare FormData
    const formData = new FormData();
    formData.append('name', form.value.name);
    formData.append('email', form.value.email);
    formData.append('password', form.value.password);
    formData.append('password_confirmation', form.value.password_confirmation);
    if (img.value) {
        formData.append('profile_photo_path', img.value);
    }

    try {
        const response = await axios.post('/api/users', formData, config);

        if (response.status === 201) {
            router.push('/');
        }
    } catch (error) {
        isProcess.value = false;
        errorMessage.value = error.response.data.message || 'An error occurred.';
    }
};


</script>