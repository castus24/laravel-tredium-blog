<script>
import Header from '../components/Header.vue'
import Footer from '../components/Footer.vue'
export default {
    name: 'App',
    components: {
        'app-header': Header,
        'app-footer': Footer,
    }
}
</script>

<template>
    <v-app>
        <app-header></app-header>

        <v-main>
            <router-view></router-view>
        </v-main>

        <app-footer></app-footer>
    </v-app>
</template>
