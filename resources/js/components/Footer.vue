<script>
export default {
    data: () => ({
        icons: [
            'mdi-facebook',
            'mdi-twitter',
            'mdi-linkedin',
            'mdi-instagram',
        ],
    }),
    computed: {
        currentYear() {
            return new Date().getFullYear();
        },
    },
}
</script>

<template>
    <v-footer class="text-center d-flex flex-column">
        <v-container>
            <v-row justify="space-between">
                <v-col>
                    <v-card
                        elevation="4"
                        class="mb-4 footer-card"
                        max-width="360"
                        rounded="1.7"
                        variant="text"
                    >
                        <v-col>
                            <v-card-title>
                                <h1>Тредиум</h1>
                            </v-card-title>
                            <v-card-text>
                                <p>@ {{ currentYear }} Все права защищены</p>
                            </v-card-text>
                        </v-col>
                    </v-card>
                </v-col>

                <v-col class="d-flex justify-center align-center flex-column">
                    <v-container>
                        <v-row justify="center">
                            <v-btn
                                v-for="icon in icons"
                                :key="icon"
                                :icon="icon"
                                class="mx-4"
                                variant="text"
                            ></v-btn>
                        </v-row>
                    </v-container>
                    <p>Как перестать прокрастинировать и начать жить</p>
                </v-col>
            </v-row>
        </v-container>
    </v-footer>
</template>

<style scoped>
.v-card-text p:first-child {
    padding-bottom: 10px;
    font-size: medium;
}

.footer-card {
    transition: transform 0.3s, border-color 0.3s;
    border: 2px solid transparent;
}

.footer-card:hover {
    border-color: #2196F3;
}
</style>
