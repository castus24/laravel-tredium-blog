<script>
export default {
    data: () => ({
        tab: null,
    }),
};
</script>

<template>
    <v-app-bar
        class="bg-grey-lighten-5x"
    >
        <v-container>
            <v-row class="d-flex justify-space-between align-center">
                <v-app-bar-title class="ml-4">Тредиум</v-app-bar-title>
                <v-tabs
                    v-model="tab"
                    align-tabs="center"
                    color="blue-darken-3"
                >
                    <v-tab :value="1" link exact :to="{ name: 'home' }">Главная</v-tab>
                    <v-tab :value="2" link exact :to="{ name: 'articles' }">Каталог статей</v-tab>
                </v-tabs>
            </v-row>
        </v-container>
    </v-app-bar>
</template>
