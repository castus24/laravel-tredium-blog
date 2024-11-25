<script>
export default {
    name: 'Article',
    methods: {
        handleClick() {
            alert('Button clicked!');
        }
    }
};
</script>

<template>
    <v-app>
        <v-main>
            <v-container>
                <h1>Article</h1>
                <v-btn
                @click="handleClick"
                >
                    Button
                </v-btn>
            </v-container>
        </v-main>
    </v-app>
</template>

<style scoped>

</style>
