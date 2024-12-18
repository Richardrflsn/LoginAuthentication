<template>
    <div class="container">
        <div class="col-md-6 m-auto">
            <h1>Edit Book</h1>

            <!-- Back Button -->
            <div class="mt-3">
                <button @click="goBack" class="btn btn-primary">Back</button>
            </div>

            <div class="my-3" style="color: red;">
                {{ errorMessage }}
            </div>

            <div class="mt-3">
                <form @submit.prevent="submitUpdate">
                    <div class="mb-3">
                        <label for="FormControlTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="FormControlTitle"
                            :placeholder="form.title ? form.title : 'Book title'" v-model="form.title">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlAuthor" class="form-label">Author</label>
                        <input type="text" class="form-control" id="FormControlAuthor"
                            :placeholder="form.author ? form.author : 'Author name'" v-model="form.author">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlIsbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="FormControlIsbn"
                            :placeholder="form.isbn ? form.isbn : 'ISBN'" v-model="form.isbn">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlPublishDate" class="form-label">Publish Date</label>
                        <input type="date" class="form-control" id="FormControlPublishDate"
                            :placeholder="form.publish_date ? form.publish_date : 'Publish date'"
                            v-model="form.publish_date">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlCover" class="form-label">Cover</label>
                        <input type="file" class="form-control" id="FormControlCover" @change="onChangeImage">
                    </div>

                    <div v-if="img || imgPreview">
                        <img :src="imgPreview" width="100" height="100" alt="Book Cover">
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary m-3" :disabled="isProcess">
                            {{ isProcess ? "Loading..." : "Update" }}
                        </button>
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

const router = useRouter();
const route = useRoute();

const form = ref({
    title: '',
    author: '',
    description: '',
    isbn: '',
    publish_date: '',
    file: '',
});

const imgPreview = ref(null);
const img = ref(null);
const errorMessage = ref('');
const isProcess = ref(false);

onMounted(async () => {
    try {
        console.log("Fetching book details...");
        console.log("Book ID:", route.params.id);

        const response = await axios.get('/api/books/' + route.params.id);
        console.log("API Response:", response); // Log the full response to check data structure

        if (response.status === 200 && response.data) {
            console.log("Book data received:", response.data);

            // Check if response contains the expected properties
            form.value.title = response.data.data.title;
            form.value.author = response.data.data.author;
            form.value.isbn = response.data.data.isbn;  // Set ISBN
            form.value.publish_date = response.data.data.publish_date;  // Set publish date
            form.value.description = response.data.data.description;
            imgPreview.value = response.data.data.image; // Use 'image' for cover

            console.log("Book data set:", form.value); // Log the form object to check if it's populated correctly
        } else {
            throw new Error("Invalid data format");
        }
    } catch (error) {
        console.error("Error fetching book data:", error);
        errorMessage.value = error.response?.data?.message || 'An error occurred while fetching the book details';
    }
});

// Handle file input change for the book image
const onChangeImage = (event) => {
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

const submitUpdate = async () => {
    isProcess.value = true;

    let imageUrl = imgPreview.value; // Use existing image if no new image is selected

    // Prepare the form data for the book update
    const updateFormData = new FormData();
    updateFormData.append('title', form.value.title);
    updateFormData.append('author', form.value.author);
    updateFormData.append('isbn', form.value.isbn);
    updateFormData.append('publish_date', form.value.publish_date);
    updateFormData.append('description', form.value.description);
    if (img.value) {
        updateFormData.append('image', img.value);
    }

    updateFormData.append('_method', 'put'); // Specify the method override for PUT

    const config = { headers: { 'Content-Type': 'multipart/form-data' } };

    try {
        const response = await axios.post(`/api/books/${route.params.id}`, updateFormData, config);
        console.log("Update Response:", response);

        if (response.status === 200) {
            isProcess.value = false;
            router.push('/'); // Navigate back to the book list
        }
    } catch (error) {
        console.error("Error updating book:", error);
        isProcess.value = false;
        errorMessage.value = error.response?.data?.message || 'Failed to update the book';
    }
};

// Back button handler
const goBack = () => {
    router.go(-1); // Go back to the previous page in the history
};
</script>

<style scoped>
.container {
    padding: 20px;
}

button {
    margin-right: 5px;
}
</style>
