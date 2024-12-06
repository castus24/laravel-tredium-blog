<script setup>
import {useRouter} from "vue-router";

const router = useRouter()

const goToHomepage = () => {
    router.push({name: 'home'})
}
</script>

<template>
    <v-empty-state
        headline="Whoops, 404"
        title="Page not found"
        text="The page you were looking for does not exist"
        image="https://vuetifyjs.b-cdn.net/docs/images/logos/v.png"
    >
        <v-btn
            @click="goToHomepage"
        >
            To Home
        </v-btn>
    </v-empty-state>
</template>
