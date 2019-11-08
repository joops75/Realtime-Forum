<template>
    <v-container fluid grid-list-md>
        <v-layout row wrap>
            <v-flex xs8>
                <Questions></Questions>
            </v-flex>
            <v-flex xs4>
                <v-card dark color="secondary">
                    <v-card-text class="px-0">Sidebar</v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
import Questions from './Questions';

export default {
    components: { Questions }
}
</script>