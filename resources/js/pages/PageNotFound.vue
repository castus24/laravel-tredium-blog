<script setup>
import {useRouter} from "vue-router";
import trediumLogo from '../assets/images/tredium_logo_tp_white.png'

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
        :image="trediumLogo"
    >
        <v-btn
            @click="goToHomepage"
        >
            To Home
        </v-btn>
    </v-empty-state>
</template>
