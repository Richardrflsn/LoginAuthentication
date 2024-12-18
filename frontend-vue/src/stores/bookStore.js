import { defineStore } from 'pinia';
import axios from 'axios';

export const useBookStore = defineStore('bookStore', {
    state: () => ({
        books: [],
        searchQuery: '',
        currentPage: 1,
        lastPage: 1,
    }),
    actions: {
        // Fetch books with pagination and search query
        async fetchBooks(page = 1, searchQuery = '') {
            try {
                const response = await axios.get('/api/books', {
                    params: {
                        page: page,
                        search: searchQuery,
                    },
                });
                // Update store with the response data
                this.books = response.data.data; // Books data
                this.currentPage = response.data.current_page;
                this.lastPage = response.data.last_page;
            } catch (error) {
                console.error('Error fetching books:', error);
            }
        },

        // Add a new book
        async addBook(book) {
            try {
                const response = await axios.post('/api/books', book);
                if (response.data) {
                    this.books.push(response.data); // Add new book to the store
                }
            } catch (error) {
                console.error('Error adding book:', error);
            }
        },

        // Update an existing book
        async updateBook(book) {
            try {
                const response = await axios.put(`/api/books/${book.id}`, book);
                const index = this.books.findIndex((b) => b.id === book.id);
                if (index !== -1 && response.data) {
                    this.books[index] = response.data; // Update the book in the store
                }
            } catch (error) {
                console.error('Error updating book:', error);
            }
        },

        // Delete a book
        async deleteBook(id, index) {
            try {
                const response = await axios.delete(`/api/books/${id}`);
                if (response.status === 200) {
                    this.books.splice(index, 1); // Remove the book from the store
                } else {
                    console.error('Failed to delete book:', response);
                }
            } catch (error) {
                console.error('Error deleting book:', error);
            }
        },

        // Search books based on the query
        async searchBooks(query) {
            this.searchQuery = query;
            this.currentPage = 1; // Reset to first page when searching
            await this.fetchBooks(this.currentPage, query); // Fetch books with the new search query
        }
    },
});
