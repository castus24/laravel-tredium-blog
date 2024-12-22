import {defineStore} from 'pinia'
import {ref} from 'vue'
import {useRouter} from "vue-router"
import { useToast } from 'vue-toastification';

export const useAuthStore = defineStore('auth', () => {
    const router = useRouter()
    const toast = useToast();
    const userData = ref(null)
    const isAuthenticated = ref(false)
    const token = ref(localStorage.getItem('auth_token'))
    const isLoading = ref(false)
    const isAdmin = ref(false)

    const login = async (userData) => {
        try {
            const {data} = await axios.post('/api/users/login', userData)
            token.value = data.data.token
            if (token.value) {
                localStorage.setItem('auth_token', token.value)
            }

            await fetchUser()
            isAuthenticated.value = true

            await router.push({name: 'home'})
            return data
        } catch (error) {
            console.error('Login error:', error)
            toast.error('Login failed. Please try again.');
            throw error
        }
    };

    const register = async (userData) => {
        try {
            const {data} = await axios.post('/api/users/register', userData)
            return data
        } catch (error) {
            console.error('Register error:', error)
            toast.error('Registration failed. Please try again.');
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
            toast.error('Logout failed. Please try again.');
        }
    };

    const fetchUser = async () => {
        try {
            isLoading.value = true
            if (!token.value) {
                console.error('No token found')
                logout()
                return
            }

            const {data} = await axios.get('/api/users', {
                headers: {
                    Authorization: `Bearer ${token.value}`
                }
            });

            isAuthenticated.value = true
            userData.value = data.data
            isAdmin.value = userData.value.roles.some(role => role.name === 'admin')

            return userData.value
        } catch (error) {
            console.error('Fetch user error:', error)
            toast.error('Failed to fetch user data.');
            logout()
        } finally {
            isLoading.value = false
        }
    };

    const initializeAuth = async () => {
        try {
            if (token.value) {
                await fetchUser()
            }
        } catch (error) {
            console.error('Initialization error:', error)
            toast.error('Failed to initialize auth.');
            logout()
        }
    };

    return {
        userData,
        token,
        isAdmin,
        isAuthenticated,
        isLoading,
        login,
        logout,
        register,
        fetchUser,
        initializeAuth,
    };
});

