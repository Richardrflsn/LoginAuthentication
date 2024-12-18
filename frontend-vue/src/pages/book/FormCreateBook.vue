<template>
    <div class="container">
        <div class="col-md-6 m-auto">
            <h1>Create Book</h1>

            <div class="my-3" style="color: red;">
                {{ errorMessage }}
            </div>

            <div class="mt-3">
                <form @submit.prevent="submitCreate">
                    <div class="mb-3">
                        <label for="FormControlTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="FormControlTitle" placeholder="Enter book title"
                            v-model="form.title">
                    </div>

                    <div class="mb-3">
                        <label for="FormControlAuthor" class="form-label">Author</label>
                        <input type="text" class="form-control" id="FormControlAuthor" placeholder="Enter book author"
                            v-model="form.author">
                    </div>

                    <div class="mb-3">
                        <label for="FormControlDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="FormControlDescription" placeholder="Enter book description"
                            v-model="form.description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="FormControlPublishDate" class="form-label">Publish Date</label>
                        <input type="date" class="form-control" id="FormControlPublishDate" v-model="form.publishDate">
                    </div>

                    <div class="mb-3">
                        <label for="FormControlISBN" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="FormControlISBN" placeholder="Enter ISBN"
                            v-model="form.isbn">
                    </div>

                    <div class="mb-3">
                        <label for="FormControlImage" class="form-label">Book Image</label>
                        <input type="file" class="form-control" id="FormControlImage" @change="onChangeImage">
                    </div>

                    <div v-if="imgPreview">
                        <img :src="imgPreview" width="100" height="100" alt="Image Preview" />
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary m-3" v-if="!isProcess">Create</button>
                        <button type="submit" class="btn btn-primary m-3" v-if="isProcess" disabled>Loading...</button>
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

const router = useRouter();

const form = ref({
    title: '',
    author: '',
    description: '',
    publishDate: '',
    isbn: '',
    file: '',
});

const imgPreview = ref(null);
const img = ref(null);
const errorMessage = ref('');
const isProcess = ref(false);

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

const submitCreate = async () => {
    isProcess.value = true;

    const formData = new FormData();
    formData.append('title', form.value.title);
    formData.append('author', form.value.author);
    formData.append('description', form.value.description);
    formData.append('publish_date', form.value.publishDate);
    formData.append('isbn', form.value.isbn);
    if (img.value) {
        formData.append('image', img.value);
    }

    // Log formData to inspect the content
    console.log('Form Data:', formData);

    try {
        const response = await axios.post('/api/books', formData);
        if (response.status === 201) {
            isProcess.value = false;
            router.push('/');  // Redirect to the admin library page
        }
    } catch (error) {
        isProcess.value = false;
        console.error("Error response:", error.response); 
        errorMessage.value = error.response?.data?.message || 'An error occurred';
    }
};

</script>
