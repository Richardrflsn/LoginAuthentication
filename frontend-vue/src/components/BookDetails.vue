<template>
    <div class="container my-4">
        <button class="btn btn-secondary mb-3" @click="goBack">Back</button>
        <div class="card">
            <img :src="book.image" alt="Book Image" class="card-img-top" />
            <div class="card-body">
                <h1 class="card-title">{{ book.title }}</h1>
                <p><strong>Author:</strong> {{ book.author }}</p>
                <p><strong>Description:</strong> {{ book.description }}</p>
                <p><strong>Publish Date:</strong> {{ book.publish_date }}</p>
                <p><strong>ISBN:</strong> {{ book.isbn }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import axios from 'axios';

const route = useRoute();
const router = useRouter();

const book = ref({});

const fetchBookDetails = async () => {
    try {
        const response = await axios.get(`/api/books/${route.params.id}`);
        book.value = response.data.data;
    } catch (error) {
        console.error('Error fetching book details:', error);
    }
};

const goBack = () => {
    router.back();
};

onMounted(() => {
    fetchBookDetails();
});
</script>

<style scoped>
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
}

.card img {
    max-height: 300px;
    object-fit: cover;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
</style>
