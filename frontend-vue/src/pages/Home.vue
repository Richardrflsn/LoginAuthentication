<template>
    <div class="container">
        <h1>Home Page</h1>
        <div v-if="useAuth.user">
            <h1>Data User</h1>
            <router-link to="/create-user">
                <button class="btn btn-primary">Create User</button>
            </router-link>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Profile</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in useAuth.authUser" :key="index">
                        <td>{{ index + 1 }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <img :src="user.profile_photo_path || 'default-image-path.png'" alt="Profile Image"
                                width="100" height="100" />
                        </td>
                        <td>
                            <router-link :to="`/edit-user/${user.id}`">
                                <button class="btn btn-info m-2">Edit</button>
                            </router-link>
                            <button class="btn btn-danger m-2" @click="clickDelete(user.id, index)">Delete</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <p>No Data</p>
        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { authStore } from '../stores/authstore';
import Swal from 'sweetalert2';
import axios from 'axios';

const useAuth = authStore(); // Initialize the store instance

onMounted(async () => {
    await useAuth.getUser();  // Fetch the user data on component mount
});

const clickDelete = (id, index) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete('/api/users/' + id)
                .then(response => {
                    if (response.status === 200) {
                        useAuth.authUser.splice(index, 1);
                    }
                })
        }
    });
}

</script>
