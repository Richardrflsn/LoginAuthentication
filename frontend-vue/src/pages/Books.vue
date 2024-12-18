<template>
    <div class="container my-4">
        <h1 class="text-center mb-4">Available Books</h1>

        <!-- Search Books -->
        <div class="mb-4">
            <input v-model="searchTerm" type="text" class="form-control" placeholder="Search for books..."
                @input="searchBooks" />
        </div>

        <!-- Display book cards if there are books -->
        <div v-if="books.data.length" class="row">
            <div class="col-md-4 mb-4" v-for="(book, index) in books.data" :key="book.id">
                <BookCard :book="book" />
            </div>

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

        <!-- Message when there are no books -->
        <div v-else>
            <p class="text-center">No books available</p>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import BookCard from '../components/BookCard.vue';

const books = ref({
    data: [],
    current_page: 1,
    last_page: 1,
});

const searchTerm = ref('');

const fetchBooks = async (page = 1, searchQuery = '') => {
    try {
        const response = await axios.get('/api/books', {
            params: {
                page: page,
                per_page: 6,
                search: searchQuery,
            },
        });
        books.value = response.data.data;
    } catch (error) {
        console.error('Error fetching books:', error);
    }
};

const changePage = (page) => {
    if (page < 1 || page > books.value.last_page) return;
    fetchBooks(page, searchTerm.value);
};

const searchBooks = () => {
    fetchBooks(1, searchTerm.value);
};

onMounted(() => {
    fetchBooks();
});
</script>
