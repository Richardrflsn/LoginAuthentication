<template>
    <div class="container">
        <div class="col-md-6 m-auto">
            <h1>Edit User</h1>

            <div class="my-3" style="color: red;">
                {{ errorMessage }}
            </div>

            <div class="mt-3">
                <form @submit.prevent="submitUpdate">
                    <div class="mb-3">
                        <label for="FormControlName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="FormControlName"
                            :placeholder="form.name ? form.name : 'Your name'" v-model="form.name">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="FormControlEmail"
                            :placeholder="form.email ? form.email : 'name@example.com'" v-model="form.email">
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
                        <button type="submit" class="btn btn-primary m-3" v-if="!isProcess">Update</button>
                        <button type="submit" class="btn btn-primary m-3" v-if="!isProcess" disabled>Loading</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';

import { useRoute, useRouter } from 'vue-router';

import { authStore } from '../../stores/authstore';

const router = useRouter();
const route = useRoute();
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

onMounted(async () => {
    try {
        const response = await axios.get('/api/users/' + route.params.id);
        console.log(response); // Inspect the full response
        if (response.status === 200 && response.data && response.data.result) {
            form.value.name = response.data.result.name;
            form.value.email = response.data.result.email;
            imgPreview.value = response.data.result.profile;
        }
    } catch (error) {
        isProcess.value = false;
        errorMessage.value = error.response?.data?.message || 'An error occurred';
    }
});


const submitUpdate = async () => {
    isProcess.value = true;

    const config = {
        headers: {
            'Content-Type': 'multipart/form-data',
        }
    }

    await axios.post(`/api/users/${route.params.id}`, {
        name: form.value.name,
        email: form.value.email,
        password: form.value.password,
        password_confirmation: form.value.password_confirmation,
        profile_photo_path: img.value,
        _method: 'put'
    }, config).then(response => {
        if (response.status === 200) {
            isProcess.value = false;
            router.push('/');
        }
        console.log(response.data.message);

    }).catch(error => {
        isProcess.value = false;
        errorMessage.value = error.response.data.message;
    });
};

</script>