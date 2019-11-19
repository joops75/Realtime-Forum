<template>
    <v-dialog
      v-model="dialog"
      fullscreen
      hide-overlay
    >
        <v-card>
            <v-container>
                <v-card-title>
                    <div class="headline">{{ mode }} Question</div>
                </v-card-title>
                <v-form @submit.prevent="handleSubmit">
                    <v-text-field
                        label="Title"
                        v-model="question.title"
                        type="text"
                        required
                    ></v-text-field>

                    <v-autocomplete
                        :items="categories"
                        item-text="name"
                        item-value="id"
                        v-model="question.category_id"
                        color="white"
                        label="Category"
                    ></v-autocomplete>

                    <vue-simplemde v-model="question.body" />
                    
                    <v-card-actions>
                        <v-btn icon type="submit">
                            <v-icon color="teal">save</v-icon>
                        </v-btn>
                        
                        <v-btn icon @click="dialog = false">
                            <v-icon>cancel</v-icon>
                        </v-btn>
                    </v-card-actions>
                </v-form>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    data() {
        return {
            question: {},
            dialog: false,
            mode: 'Create',
            categories: [],
            error: null
        }
    },
    created() {
        EventBus.$on('showQuestionModal', question => {
            this.getCategories();
            this.question = question || { body: '' };
            this.mode = question ? 'Edit' : 'Create';
            this.dialog = true;
        })
    },
    methods: {
        handleSubmit() {
            axios({
                method: this.mode === 'Create' ? 'post' : 'put',
                url: this.mode === 'Create' ? '/api/question' : `/api/question/${this.question.slug}`,
                data: this.question
            })
                .then(res => {
                    this.dialog = false;
                    // navigate away and then back to refresh page without hard reload
                    this.$router.push('/loading')
                        .then(() => this.$router.push(res.data.path));
                })
                .catch(err => Exception.handle(err));
        },
        getCategories() {
            axios.get('/api/category')
                .then(res => this.categories = res.data.data)
                .catch(err => Exception.handle(err));
        }
    }
}
</script>