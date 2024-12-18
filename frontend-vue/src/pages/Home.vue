<template>
    <div class="container">
        <h1>Admin Panel</h1>

        <!-- User Data Section -->
        <div v-if="useAuth.authUser && useAuth.authUser.length > 0">
            <h3>User Data</h3>
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
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in useAuth.authUser" :key="user.id">
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
                            <button class="btn btn-danger m-2" @click="clickDeleteUser(user.id, index)">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-else>
            <p>No User Data Available</p>
        </div>

        <!-- Admin Panel for Book Management -->
        <div v-if="books.data.length > 0">
            <h2>Book Management</h2>
            <router-link to="/create-book">
                <button class="btn btn-success mb-3">Create New Book</button>
            </router-link>

            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(book, index) in books.data" :key="book.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ book.title }}</td>
                        <td>{{ book.author }}</td>
                        <td>
                            <router-link :to="`/edit-book/${book.id}`">
                                <button class="btn btn-warning m-2">Edit</button>
                            </router-link>
                            <button class="btn btn-danger m-2" @click="clickDeleteBook(book.id, index)">
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <!-- Pagination controls -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <button class="btn btn-primary" :disabled="books.current_page === 1"
                    @click="changePage(books.current_page - 1)">
                    Previous
                </button>
                <span>Page {{ books.current_page }} of {{ books.last_page }}</span>
                <button class="btn btn-primary" :disabled="books.current_page === books.last_page"
                    @click="changePage(books.current_page + 1)">
                    Next
                </button>
            </div>
        </div>

        <div v-else>
            <p>No Book Data Available</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { authStore } from '../stores/authStore';
import Swal from 'sweetalert2';
import axios from 'axios';

const useAuth = authStore(); // Initialize the user store
const books = ref({
    data: [],
    current_page: 1,
    last_page: 1,
});

const fetchBooks = async (page = 1) => {
    try {
        const response = await axios.get('/api/books', {
            params: {
                page,
                per_page: 5, // Define items per page
            },
        });
        books.value = response.data.data;
    } catch (error) {
        console.error('Error fetching books:', error);
    }
};

const changePage = (page) => {
    if (page < 1 || page > books.value.last_page) return;
    fetchBooks(page);
};

// Fetch data on component mount
onMounted(async () => {
    try {
        await useAuth.getUser(); // Load user data
        await fetchBooks(); // Load book data
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

// Delete user logic
const clickDeleteUser = (id, index) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the user permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.delete(`/api/users/${id}`);
                if (response.status === 200) {
                    useAuth.authUser.splice(index, 1); // Remove user from the list
                }
            } catch (error) {
                console.error('Error deleting user:', error);
            }
        }
    });
};

// Delete book logic
const clickDeleteBook = (id, index) => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will delete the book permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await axios.delete(`/api/books/${id}`);
                if (response.status === 200) {
                    books.value.data.splice(index, 1); // Remove book from the list
                }
            } catch (error) {
                console.error('Error deleting book:', error);
            }
        }
    });
};
</script>

<style scoped>
.container {
    padding: 20px;
}

.table {
    margin-top: 20px;
    width: 100%;
    text-align: left;
}

button {
    margin-right: 5px;
}
</style>
