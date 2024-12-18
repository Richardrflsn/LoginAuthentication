<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand m-2" href="#">Oracle Library</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <router-link class="nav-link" to="/">Admin</router-link>
                </li>
                <li class="nav-item">
                    <router-link class="nav-link" to="Books">Books</router-link>
                </li>
                <li class="nav-item" v-if="!useAuth.user">
                    <router-link class="nav-link" to="Login">Login</router-link>
                </li>
                <li class="nav-item" v-if="!useAuth.user">
                    <router-link class="nav-link" to="Register" tabindex="-1">Register</router-link>
                </li>
                <li class="nav-item" v-if="useAuth.user">
                    <router-link class="nav-link" to="#" tabindex="-1">
                        <span @click="useAuth.logOut" class="logout-link">Logout</span>
                    </router-link>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script setup>
import { RouterLink } from 'vue-router';

import { authStore } from '../stores/authstore';

const useAuth = authStore();
</script>

<style scoped>
.nav-link.active {
    font-weight: bold;
}

.logout-link {
    color: red;
    /* Set the text color to red */
    cursor: pointer;
    /* Makes the span appear clickable */
}

.logout-link:hover {
    color: darkred;
    /* Change color when hovered */
}
</style>
