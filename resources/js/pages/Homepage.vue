<script>
export default {
    data() {
        return {
            articles: [],
        };
    },
    mounted() {
        this.loadArticles();
    },
    methods: {
        async loadArticles() {
            try {
                const response = await axios.get(`/api`);
                this.articles = response.data.data;
            } catch (error) {
                console.error("Ошибка загрузки статей:", error);
            }
        },
        goToArticle(slug) {
            this.$router.push({name: "articleDetail", params: {slug}});
        },
    },
};
</script>

<template>
    <div class="header-block">
        <v-container>
            <v-row>
                <h1>Успех</h1>
            </v-row>
        </v-container>
    </div>

    <v-container>
        <v-row>
            dsd
        </v-row>
    </v-container>

    <v-container class="mt-3 mb-6">
        <v-row>
            <v-col
                cols="12"
                sm="4"
                v-for="(article, index) in articles"
                :key="index"
            >
                <v-card
                    class="home-card d-flex flex-column"
                    elevation="5"
                    @click="goToArticle(article.slug)"
                    height="500"
                >
                    <v-row class="image">
                        <v-img
                            :src="article.thumbnail_image"
                            cover
                        >
                            <template v-slot:placeholder>
                                <div class="d-flex align-center justify-center fill-height">
                                    <v-progress-circular
                                        color="grey-lighten-4"
                                        indeterminate
                                    ></v-progress-circular>
                                </div>
                            </template>
                        </v-img>
                    </v-row>
                    <v-row class="content d-flex flex-column justify-space-between">
                        <v-row class="card-content mt-3">
                            <v-card-text class="card-title">{{ article.title }}</v-card-text>
                            <v-card-text class="card-text">{{ article.content }}</v-card-text>
                        </v-row>
                        <v-row justify="space-between" class="article-content">
                            <v-btn variant="plain">
                                <v-icon icon="mdi-heart-outline" size="x-large"></v-icon>
                            </v-btn>
                            <v-btn variant="plain">
                                <v-icon icon="mdi-eye" size="x-large"></v-icon>
                            </v-btn>
                        </v-row>
                    </v-row>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
.header-block {
    width: 100%;
    height: 30vh;
    background-color: #E8ECEF;
    display: flex;
    align-items: center;
    padding-left: 20px;
}

.content {
    height: 50%;
}

.image {
    height: 50%;
}

.card-content {
    padding: 0 20px 0 20px;
}

.card-title {
    word-break: break-all;
    font-size: large;
    font-weight: bolder;
    padding-bottom: 0;
    transition: color 0.3s;
}

.card-text {

}

.card-title:hover {
    color: #2196F3;
}

.home-card {
    transition: transform 0.3s;
}

.home-card:hover {
    transform: translateY(-5px);
}

.article-content {
    padding: 0 20px 0 20px;
}
</style>
