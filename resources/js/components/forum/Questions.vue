<template>
    <div>
        <v-card v-for="question in questions" :key="question.title">
            <v-card-title primary-title>
                <div>
                    <h3 class="headline mb-0">
                        <router-link :to="question.path">
                            {{ question.title }}
                        </router-link>
                    </h3>
                    <div class="grey--text">Posted by {{ question.username }} {{ question.created_at }}</div>
                </div>
            </v-card-title>

            <v-card-text>{{ question.body }}</v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            questions: []
        }
    },
    created() {
        axios.get('/api/question')
            .then(res => {
                this.questions = res.data.data;
            })
            .catch(err => console.log(err.response.data));
    }
}
</script>