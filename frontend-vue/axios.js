import { notify } from "@kyvg/vue3-notification";
import axios from "axios";

axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL="http://localhost:8000";

axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 401) {
            notify({
                title: "Authentication Error",
                text: error.response.data.message || "You are not authenticated",
                type: "error",
            });
        }
        return Promise.reject(error);
    }
)