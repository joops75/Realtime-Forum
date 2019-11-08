<template>
    <v-container>
        <v-form @submit.prevent="createQuestion">
            <v-text-field
                label="Title"
                v-model="form.title"
                type="text"
                required
            ></v-text-field>

            <v-autocomplete
                :items="categories"
                item-text="name"
                item-value="id"
                v-model="form.category_id"
                color="white"
                label="Category"
            ></v-autocomplete>

            <vue-simplemde v-model="form.body" />
            
            <v-btn
                color="green"
                type="submit"
            >Create Question</v-btn>
        </v-form>
    </v-container>
</template>

<script>
export default {
    data() {
        return {
            form: {
                title: null,
                body: null,
                category_id: null
            },
            categories: [],
            error: null
        }
    },
    created() {
        axios.get('/api/category')
            .then(res => {
                this.categories = res.data.data;
            })
            .catch(err => console.log(err.response.data));
    },
    methods: {
        createQuestion() {
            axios.post('/api/question', this.form)
                .then(res => {
                    this.$router.push(res.data.path);
                })
                .catch(err => this.error = err.response.data.error);
        }
    }
}
</script>