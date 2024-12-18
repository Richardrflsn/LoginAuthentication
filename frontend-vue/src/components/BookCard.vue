<template>
    <router-link :to="{ name: 'BookDetails', params: { id: book.id } }" class="card-link">
        <div class="card">
            <img :src="book.image" alt="Book Image" class="card-img-top" />
            <div class="card-body">
                <h5 class="card-title">{{ book.title }}</h5>
                <p class="card-text"><strong>Author:</strong> {{ book.author }}</p>
                <p class="card-text"><strong>Publish Date:</strong> {{ book.publish_date }}</p>
                <p class="card-text"><strong>ISBN:</strong> {{ book.isbn }}</p>
            </div>
        </div>
    </router-link>
</template>

<script setup>
// Define props for the component
defineProps({
    book: {
        type: Object,
        required: true,
    },
});
</script>

<style scoped>
.card-link {
    text-decoration: none;
    color: inherit;
}

.card {
    cursor: pointer;
    border: 1px solid #ddd;
    border-radius: 8px;
    transition: transform 0.2s;
}

.card:hover {
    transform: scale(1.05);
}

.card img {
    max-height: 150px;
    object-fit: cover;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}
</style>
