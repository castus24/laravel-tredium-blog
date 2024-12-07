import {defineStore} from 'pinia'
import {ref} from 'vue'

export const useAuthStore = defineStore('auth', () => {
    const userData = ref(null)
    const isAuthenticated = ref(false)
    const token = ref(null)

    const login = async (userData) => {
        try {
            const {data} = await axios.post('/api/user/login', userData)
            token.value = data.data.token
            if (data.data.token) {
                localStorage.setItem('auth_token', data.data.token)
            }

            await fetchUser()
            isAuthenticated.value = true

            return data
        } catch (error) {
            console.error('Login error:', error)
            throw error
        }
    };

    const register = async (userData) => {
        try {
            const {data} = await axios.post('/api/user/register', userData)
            return data
        } catch (error) {
            console.error('Register error:', error)
            throw error
        }
    };

    const logout = () => {
        try {
            localStorage.removeItem('auth_token')
            userData.value = null
            token.value = null
            isAuthenticated.value = false
        } catch (error) {
            console.error('Logout error:', error)
        }
    };

    const fetchUser = async () => {
        try {
            const token = localStorage.getItem('auth_token')
            if (!token) {
                console.error('No token found');
                logout();
                return;
            }

            const {data} = await axios.get('/api/user', {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            });

            userData.value = data.data
            return data.data
        } catch (error) {
            console.error('Fetch user error:', error)
            logout()
        }
    };

    return {
        userData,
        isAuthenticated,
        token,
        login,
        logout,
        register,
        fetchUser,
    };
});

