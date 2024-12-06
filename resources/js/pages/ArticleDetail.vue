<script setup>
import {onMounted, ref} from 'vue'

const props = defineProps({
    slug: {
        type: String,
        required: true,
    },
})

const article = ref(null)
const isLoading = ref(false)
const subject = ref('')
const body = ref('')
const submitting = ref(false)
const error = ref(null)
const success = ref(null)

const loadArticle = async () => {
    console.log(article)
    this.isLoading = true
    try {
        const response = await axios.get(`/api/articles/${props.slug}`)
        article.value = response.data
        isLoading.value = false
    } catch (error) {
        console.error("Article detail loading error: ", error)
        error.value = "Article detail loading error."
        isLoading.value = false
    }
}

const submitComment = async () => {
    submitting.value = true
    error.value = null
    success.value = null

    try {
        const response = await axios.post(`/api/articles/${props.slug}/comment`, {
            subject: subject.value,
            body: body.value
        })
        success.value = response.data.message
        subject.value = ""
        body.value = ""
    } catch (err) {
        console.error("Failed to submit comment: ", err)
        error.value = "Failed to submit comment. Please try again."
    } finally {
        submitting.value = false
    }
}

onMounted(loadArticle)
</script>

<template>
    <v-container class="mt-5">
        <v-row>
            <v-col cols="12">
                <v-card v-if="isLoading" class="text-center">
                    <v-card-text>
                        <v-progress-circular indeterminate></v-progress-circular>
                        <p>Загрузка статьи...</p>
                    </v-card-text>
                </v-card>

                <v-card v-else elevation="5" class="article-detail">
                    <v-card-title class="text-h4 font-weight-bold">
                        {{ article.title }}
                    </v-card-title>
                    <v-card-subtitle class="text-body-2 mb-4">
                        {{ article.created_at }}
                    </v-card-subtitle>
                    <v-card-text class="article-content">
                        {{ article.content }}
                    </v-card-text>

                    <v-card-text>
                        <v-form>
                            <v-text-field
                                label="Тема сообщения"
                                v-model="subject"
                                :disabled="submitting"
                                outlined
                                required
                            ></v-text-field>
                            <v-textarea
                                label="Сообщение"
                                v-model="body"
                                :disabled="submitting"
                                outlined
                                required
                            ></v-textarea>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-center align-center text-center mb-4">
                        <v-btn
                            :disabled="submitting"
                            color="blue-darken-3"
                            @click="submitComment"
                        >
                            Отправить
                        </v-btn>
                        <v-progress-circular
                            v-if="submitting"
                            indeterminate
                            color="primary"
                            size="24"
                        ></v-progress-circular>
                    </v-card-actions>
                </v-card>

                <v-alert v-if="error" type="error">{{ error }}</v-alert>
                <v-alert v-if="success" type="success">{{ success }}</v-alert>
            </v-col>
        </v-row>
    </v-container>
</template>

<style scoped>
.article-detail {
    margin-bottom: 32px;
    transition: transform 0.3s, border-color 0.3s;
}

.article-detail:hover {
    border-color: #2196F3;
}

.article-content {
    white-space: pre-wrap;
    color: #333;
    line-height: 1.6;
    font-size: 16px;
}
</style>
