import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null);
    const isAuthenticated = ref(false);
    const token = ref(null);

    const login = async (userData) => {
        try {
            const { data } = await axios.post('/api/login', userData);
            token.value = data.token;
            axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;

            await fetchUser();
            isAuthenticated.value = true;
        } catch (error) {
            console.error('Login error:', error);
            throw error;
        }
    };

    const register = async (userData) => {
        try {
            const { data } = await axios.post('/api/register', userData);
            token.value = data.token;
            axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`;

            await fetchUser();
            isAuthenticated.value = true;
        } catch (error) {
            console.error('Register error:', error);
            throw error;
        }
    };

    const logout = async () => {
        try {
            await axios.post('/api/logout');
        } catch (error) {
            console.error('Logout error:', error);
        } finally {
            user.value = null;
            token.value = null;
            isAuthenticated.value = false;
            delete axios.defaults.headers.common['Authorization'];
        }
    };

    const fetchUser = async () => {
        try {
            const { data } = await axios.get('/api/user');
            user.value = data;
        } catch (error) {
            console.error('Fetch user error:', error);
            await logout();
        }
    };

    return {
        user,
        isAuthenticated,
        token,
        register,
        login,
        logout,
        fetchUser,
    };
});

